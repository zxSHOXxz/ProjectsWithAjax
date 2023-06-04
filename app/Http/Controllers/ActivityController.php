<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        ], [
            'titleActivity.required' => 'العنوان مطلوب',
            'titleActivity.min' => 'لا يقبل أقل من 3 حروف',
            'titleActivity.max' => 'لا يقبل أكثر من 20 حروف',
        ]);

        DB::beginTransaction();

        if (!$validator->fails()) {
            try {
                $activity = new Activity();
                $activity->title = $request->get('titleActivity');
                $activity->end = $request->get('endActivity');
                $activity->start = $request->get('startActivity');
                $activity->project_id = $request->get('project_id');
                $isSaved = $activity->save();
                if ($request->has('titleProject')) {
                    $project = new Project();
                    $project->title = $request->get('titleProject');
                    $project->end = $request->get('endProject');
                    $project->start = $request->get('startProject');
                    $isSaved = $project->save();
                    if ($isSaved) {
                        DB::commit();
                        return response()->json(['icon' => 'success', 'title' => "تمت الإضافة بنجاح"], 200);
                    } else {
                        DB::rollBack();
                        return response()->json(['icon' => 'error', 'title' => "فشلت عملية التخزين"], 400);
                    }
                }
                if ($isSaved) {
                    DB::commit();
                    return response()->json(['icon' => 'success', 'title' => "تمت الإضافة بنجاح"], 200);
                } else {
                    DB::rollBack();
                    return response()->json(['icon' => 'error', 'title' => "فشلت عملية التخزين"], 400);
                }
            } catch (Exception $e) {
                DB::rollBack();
                return response()->json(['icon' => 'error', 'title' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['icon' => 'error', 'title' => $validator->getMessageBag()->first()], 400);
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
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
