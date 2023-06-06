<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Project;
use App\Models\SubActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function getActivity()
    {
        $activity = Activity::all();
        return response()->json($activity);
    }
    public function getActivityForProject($id)
    {
        $activity = Activity::where('project_id', $id)->get();
        return response()->json($activity);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'titleActivity' => 'required|string|min:3|max:20',
            'titleProject' => 'required|string|min:3|max:20',
            'endActivity' => 'required',
            'startActivity' => 'required',
            'endProject' => 'required',
            'startProject' => 'required',
        ], [
            'titleActivity.required' => 'العنوان النشاط مطلوب',
            'titleActivity.min' => 'لا يقبل عنوان النشاط أقل من 3 حروف',
            'titleActivity.max' => 'لا يقبل عنوان النشاط أكثر من 20 حروف',
            'titleProject.required' => 'العنوان  عنوان المشروع مطلوب',
            'titleProject.min' => 'لا يقبل عنوان المشروع أقل من 3 حروف',
            'titleProject.max' => 'لا يقبل عنوان المشروع أكثر من 20 حروف',
            'endActivity.required' => 'تاريخ انتهاء النشاط مطلوب',
            'startActivity.required' => 'تاريخ بدءالنشاط مطلوب',
            'endProject.required' => 'تاريخ انتهاء المشروع مطلوب',
            'startProject.required' => 'تاريخ بدء المشروع مطلوب',
        ]);

        if (!$validator->fails()) {
            DB::beginTransaction();

            try {
                $project = new Project();
                $project->title = $request->get('titleProject');
                $project->end = $request->get('endProject');
                $project->start = $request->get('startProject');
                $isProjectSaved = $project->save();

                $activity = new Activity();
                $activity->title = $request->get('titleActivity');
                $activity->end = $request->get('endActivity');
                $activity->start = $request->get('startActivity');
                $activity->project_id = $project->id;
                $isActivitySaved = $activity->save();

                if ($isProjectSaved && $isActivitySaved) {
                    DB::commit();
                    return response()->json(['icon' => 'success', 'title' => "تمت الإضافة بنجاح"], 200);
                } else {
                    DB::rollback();
                    return response()->json(['icon' => 'error', 'title' => "فشلت عملية التخزين"], 400);
                }
            } catch (Exception $e) {
                DB::rollback();
                return response()->json(['icon' => 'error', 'title' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
        }
    }
    public function projectActivityStore(Request $request)
    {

        $data = $request->get('subActivities');
        $request_activity = $request->get('mainActivity');

        $main_activityData = explode(',', $request_activity[0]);
        $main_activity_title = $main_activityData[0];
        $main_activity_startDate = $main_activityData[1];
        $main_activity_project_id = $main_activityData[2];
        $main_activity_endDate = $main_activityData[3];

        $main_activity = [
            'title' => $main_activity_title,
            'start_date' => $main_activity_startDate,
            'end_date' => $main_activity_endDate,
            'project_id' => $main_activity_project_id
        ];

        $subActivities = [];

        foreach ($data as $activityItem) {
            $activityData = explode(',', $activityItem);
            $title = $activityData[0];
            $startDate = $activityData[1];
            $endDate = $activityData[2];

            $activity = [
                'title' => $title,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ];

            $subActivities[] = $activity;
        }

        $validator = validator(
            [
                'mainActivity' => $main_activity,
                'subActivity' => $subActivities,
            ],
            [
                'mainActivity' => 'required|array',
                'mainActivity.title' => 'required|string',
                'mainActivity.start_date' => 'required|date',
                'mainActivity.end_date' => 'required|date|after:mainActivity.start_date',
                'subActivity' => 'required|array',
                'subActivity.*.title' => 'required|string',
                'subActivity.*.start_date' => 'required|date',
                'subActivity.*.end_date' => 'required|date|after:subActivity.*.start_date',
            ],
            []
        );

        if ($validator->fails()) {
            return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
        }
        DB::beginTransaction();

        try {
            $activity = new Activity();
            $activity->title = $main_activity['title'];
            $activity->end = $main_activity['start_date'];
            $activity->start = $main_activity['end_date'];
            $activity->project_id = $main_activity['project_id'];
            $isActivitySaved = $activity->save();

            foreach ($subActivities as $subActivity) {
                $sub_activity = new SubActivity();
                $sub_activity->title = $subActivity['title'];
                $sub_activity->start = $subActivity['start_date'];
                $sub_activity->end = $subActivity['end_date'];
                $sub_activity->activity_id = $activity->id;
                $isSubActivitySaved = $sub_activity->save();
            }

            if ($isActivitySaved && $isSubActivitySaved) {
                DB::commit();
                return response()->json(['icon' => 'success', 'title' => "تمت الإضافة بنجاح"], 200);
            } else {
                DB::rollback();
                return response()->json(['icon' => 'error', 'title' => "فشلت عملية التخزين"], 400);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['icon' => 'error', 'title' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'titleActivitytUpdate' => 'required|string|min:3|max:20',
        ], [
            'titleActivitytUpdate.required' => 'العنوان مطلوب',
            'titleActivitytUpdate.min' => 'لا يقبل أقل من 3 حروف',
            'titleActivitytUpdate.max' => 'لا يقبل أكثر من 20 حروف',
        ]);

        DB::beginTransaction();

        try {
            if (!$validator->fails()) {
                $activity = Activity::findOrFail($id);
                $activity->title = $request->get('titleActivitytUpdate');
                $activity->end = $request->get('startActivitytUpdate');
                $activity->start = $request->get('endActivitytUpdate');
                $isSaved = $activity->save();

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
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subActivities = SubActivity::where('activity_id', $id)->get();
        foreach ($subActivities as $subActivity) {
            $subActivity->destroy($subActivity->id);
        }
        $activity = Activity::destroy($id);
        return response()->json(['icon' => 'success', 'title' => 'Deleted is Successfully'], $activity ? 200 : 400);
    }
}
