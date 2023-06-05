<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Project;
use App\Models\SubActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        $activities = Activity::all();
        return view('cms.projects.index', compact('projects', 'activities'));
    }

    public function getProjects()
    {
        $projects = Project::all();
        return response()->json($projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mainActivity = $request->input('mainActivity');
        $subActivity = $request->input('subActivity');
        $validator = validator($request->all(), [
            'mainActivity' => 'required',
            'subActivity' => 'required',
        ], [
            'mainActivity.required' => 'العنوان مطلوب',
            'subActivity.required' => 'العنوان مطلوب',

        ]);

        DB::beginTransaction();

        try {
            if (!$validator->fails()) {
                $project = new Project();
                $project->title = $request->get('titleMainProject');
                $project->start = $request->get('startMainProject');
                $project->end = $request->get('endMainProject');
                if (strtotime($project->start) >= strtotime($project->end)) {
                    return response()->json(['icon' => 'error', 'title' => 'تاريخ البدء يجب أن يكون قبل تاريخ الانتهاء في المشروع الرئيسي'], 400);
                }
                $isSaved = $project->save();
                foreach ($mainActivity as $activity) {
                    $activityData = json_decode($activity, true);

                    $activityTitle = $activityData['title'];
                    $activityStartDate = $activityData['startDate'];
                    $activityEndDate = $activityData['endDate'];

                    $mainActivity = new Activity();
                    $mainActivity->title = $activityTitle;
                    $mainActivity->start = $activityStartDate;
                    $mainActivity->end = $activityEndDate;
                    if (strtotime($mainActivity->start) >= strtotime($mainActivity->end)) {
                        return response()->json(['icon' => 'error', 'title' => 'تاريخ البدء يجب أن يكون قبل تاريخ الانتهاء في النشاط الرئيسي'], 400);
                    }
                    $mainActivity->project_id = $project->id;

                    $mainActivity->save();

                    $subActivities = $request->input('subActivity');

                    foreach ($subActivities as $subActivity) {
                        $subActivityData = json_decode($subActivity, true);

                        $subActivityParentTitle = $subActivityData['parentTitle'];
                        $subActivityTitle = $subActivityData['subActivityTitle'];
                        $subActivityStartDate = $subActivityData['subActivityStartDate'];
                        $subActivityEndDate = $subActivityData['subActivityEndDate'];

                        if ($subActivityParentTitle === $mainActivity->title) {
                            $subActivity = new SubActivity();
                            $subActivity->title = $subActivityTitle;
                            $subActivity->start = $subActivityStartDate;
                            $subActivity->end = $subActivityEndDate;
                            $subActivity->activity_id = $mainActivity->id;
                            if (strtotime($subActivity->start) >= strtotime($subActivity->end)) {
                                return response()->json(['icon' => 'error', 'title' => 'تاريخ البدء يجب أن يكون قبل تاريخ الانتهاء في النشاط الفرعي'], 400);
                            }
                            $subActivity->save();
                        }
                    }
                }
                if ($isSaved) {
                    DB::commit();
                    return response()->json(['icon' => 'success', 'title' => "تمت الإضافة بنجاح"], 200);
                } else {
                    DB::rollBack();
                    return response()->json(['icon' => 'error', 'title' => "فشلت عملية التخزين"], 400);
                }
            } else {
                return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['icon' => 'error', 'title' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'titleProjectUpdate' => 'required|string|min:3|max:20',
        ], [
            'titleProjectUpdate.required' => 'العنوان مطلوب',
            'titleProjectUpdate.min' => 'لا يقبل أقل من 3 حروف',
            'titleProjectUpdate.max' => 'لا يقبل أكثر من 20 حروف',
        ]);

        DB::beginTransaction();

        try {
            if (!$validator->fails()) {
                $project = Project::findOrFail($id);
                $project->title = $request->get('titleProjectUpdate');
                $project->end = $request->get('startProjectUpdate');
                $project->start = $request->get('endProjectUpdate');
                $isSaved = $project->save();

                if ($isSaved) {
                    DB::commit();
                    return response()->json(['icon' => 'success', 'title' => "تم التعديل بنجاح"], 200);
                } else {
                    DB::rollBack();
                    return response()->json(['icon' => 'error', 'title' => "فشلت عملية التعديل"], 400);
                }
            } else {
                return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['icon' => 'error', 'title' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activities = Activity::where('project_id', $id)->get();
        foreach ($activities as $activity) {
            $subActivities = SubActivity::where('activity_id', $activity->id)->get();
            foreach ($subActivities as $subActivity) {
                $subActivity->destroy($subActivity->id);
            }
            $activity->destroy($activity->id);
        }
        $project = Project::destroy($id);
        return response()->json(['icon' => 'success', 'title' => 'Deleted is Successfully'], $project ? 200 : 400);
    }
}
