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
        $mainActivityA = $request->input('mainActivity');
        $subActivity = $request->input('subActivity');

        $mainActivity = json_encode($mainActivityA);
        $subActivity = json_encode($subActivity); 

        $validator = validator([
            'titleMainProject' => $request->input('titleMainProject'),
            'startMainProject' => $request->input('startMainProject'),
            'endMainProject' => $request->input('endMainProject'),
            'mainActivity' => $mainActivity,
            'subActivity' => $subActivity,
        ], [
            'titleMainProject' => 'required',
            'startMainProject' => 'required|date',
            'endMainProject' => 'required|date|after:startMainProject',
            'mainActivity.*.title' => 'required',
            'mainActivity.*.startDate' => 'required|date',
            'mainActivity.*.endDate' => 'required|date|after:mainActivity.*.startDate',
            'subActivity.*.parentTitle' => 'required',
            'subActivity.*.subActivityTitle' => 'required',
            'subActivity.*.subActivityStartDate' => 'required|date',
            'subActivity.*.subActivityEndDate' => 'required|date|after:subActivity.*.subActivityStartDate',
        ], [
            'titleMainProject.required' => 'عنوان المشروع الرئيسي مطلوب',
            'startMainProject.required' => 'تاريخ البدء في المشروع الرئيسي مطلوب',
            'startMainProject.date' => 'تاريخ البدء في المشروع الرئيسي يجب أن يكون تاريخ صالح',
            'endMainProject.required' => 'تاريخ الانتهاء في المشروع الرئيسي مطلوب',
            'endMainProject.date' => 'تاريخ الانتهاء في المشروع الرئيسي يجب أن يكون تاريخ صالح',
            'endMainProject.after' => 'تاريخ الانتهاء في المشروع الرئيسي يجب أن يكون بعد تاريخ البدء',
            'mainActivity.required' => 'الأنشطة الرئيسية مطلوبة',
            'mainActivity.*.title.required' => 'عنوان النشاط الرئيسي مطلوب',
            'mainActivity.*.startDate.required' => 'تاريخ البدء في النشاط الرئيسي مطلوب',
            'mainActivity.*.startDate.date' => 'تاريخ البدء في النشاط الرئيسي يجب أن يكون تاريخ صالح',
            'mainActivity.*.endDate.required' => 'تاريخ الانتهاء في النشاط الرئيسي مطلوب',
            'mainActivity.*.endDate.date' => 'تاريخ الانتهاء في النشاط الرئيسي يجب أن يكون تاريخ صالح',
            'mainActivity.*.endDate.after' => 'تاريخ الانتهاء في النشاط الرئيسي يجب أن يكون بعد تاريخ البدء',
            'subActivity.required' => 'الأنشطة الفرعية مطلوبة',
            'subActivity.*.parentTitle.required' => 'عنوان النشاط الرئيسي للنشاط الفرعي مطلوب',
            'subActivity.*.subActivityTitle.required' => 'عنوان النشاط الفرعي مطلوب',
            'subActivity.*.subActivityStartDate.required' => 'تاريخ البدء في النشاط الفرعي مطلوب',
            'subActivity.*.subActivityStartDate.date' => 'تاريخ البدء في النشاط الفرعي يجب أن يكون تاريخ صالح',
            'subActivity.*.subActivityEndDate.required' => 'تاريخ الانتهاء في النشاط الفرعي مطلوب',
            'subActivity.*.subActivityEndDate.date' => 'تاريخ الانتهاء في النشاط الفرعي يجب أن يكون تاريخ صالح',
            'subActivity.*.subActivityEndDate.after' => 'تاريخ الانتهاء في النشاط الفرعي يجب أن يكون بعد تاريخ البدء',
        ]);


        if ($validator->fails()) {
            return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
        }

        DB::beginTransaction();

        try {
            $project = new Project();
            $project->title = $request->get('titleMainProject');
            $project->start = $request->get('startMainProject');
            $project->end = $request->get('endMainProject');

            if (!$project->save()) {
                DB::rollBack();
                return response()->json(['icon' => 'error', 'title' => 'حدث خطأ أثناء حفظ المشروع الرئيسي'], 400);
            }

            foreach ($mainActivityA as $activity) {
                $activityData = json_decode($activity, true);

                $activityTitle = $activityData['title'];
                $activityStartDate = $activityData['startDate'];
                $activityEndDate = $activityData['endDate'];

                $mainActivity = new Activity();
                $mainActivity->title = $activityTitle;
                $mainActivity->start = $activityStartDate;
                $mainActivity->end = $activityEndDate;
                $mainActivity->project_id = $project->id;

                if (!$mainActivity->save()) {
                    DB::rollBack();
                    return response()->json(['icon' => 'error', 'title' => 'حدث خطأ أثناء حفظ النشاط الرئيسي'], 400);
                }

                $subActivities = $request->input('subActivity');

                foreach ($subActivities as $subActivity) {
                    $subActivityData = json_decode($subActivity, true);

                    $parentTitle = $subActivityData['parentTitle'];
                    $subActivityTitle = $subActivityData['subActivityTitle'];
                    $subActivityStartDate = $subActivityData['subActivityStartDate'];
                    $subActivityEndDate = $subActivityData['subActivityEndDate'];

                    $subActivity = new Activity();
                    $subActivity->title = $subActivityTitle;
                    $subActivity->start = $subActivityStartDate;
                    $subActivity->end = $subActivityEndDate;
                    $subActivity->project_id = $project->id;

                    if (!$subActivity->save()) {
                        DB::rollBack();
                        return response()->json(['icon' => 'error', 'title' => 'حدث خطأ أثناء حفظ النشاط الفرعي'], 400);
                    }
                }
            }

            DB::commit();
            return response()->json(['icon' => 'success', 'title' => "تمت الإضافة بنجاح"], 200);
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
