<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\SubActivity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function getSubActivity($id)
    {
        $subActivities = SubActivity::where('activity_id', $id)->get();
        return response()->json($subActivities);
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
            'titleSubActivity' => 'required|string|min:3|max:20',
        ], [
            'titleSubActivity.required' => 'العنوان مطلوب',
            'titleSubActivity.min' => 'لا يقبل أقل من 3 حروف',
            'titleSubActivity.max' => 'لا يقبل أكثر من 20 حروف',
        ]);

        DB::beginTransaction();

        if (!$validator->fails()) {
            try {
                $subActivity = new SubActivity();
                $subActivity->title = $request->get('titleSubActivity');
                $subActivity->end = $request->get('startSubActivity');
                $subActivity->start = $request->get('endSubActivity');
                $subActivity->activity_id = $request->get('activity_id');
                $isSaved = $subActivity->save();
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
     * @param  \App\Models\SubActivity  $subActivity
     * @return \Illuminate\Http\Response
     */
    public function show(SubActivity $subActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubActivity  $subActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(SubActivity $subActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubActivity  $subActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'titleSub_ActivitytUpdate' => 'required|string|min:3|max:20',
        ], [
            'titleSub_ActivitytUpdate.required' => 'العنوان مطلوب',
            'titleSub_ActivitytUpdate.min' => 'لا يقبل أقل من 3 حروف',
            'titleActivitytUpdate.max' => 'لا يقبل أكثر من 20 حروف',
        ]);

        DB::beginTransaction();

        try {
            if (!$validator->fails()) {
                $sub_activity = SubActivity::findOrFail($id);
                $sub_activity->title = $request->get('titleSub_ActivitytUpdate');
                $sub_activity->end = $request->get('startSub_ActivitytUpdate');
                $sub_activity->start = $request->get('endSub_ActivitytUpdate');
                $isSaved = $sub_activity->save();

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
     * @param  \App\Models\SubActivity  $subActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $SubActivity = SubActivity::destroy($id);
        return response()->json(['icon' => 'success', 'title' => 'Deleted is Successfully'], $SubActivity ? 200 : 400);
    }
}
