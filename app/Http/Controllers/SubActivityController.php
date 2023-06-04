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
            'title' => 'required|string|min:3|max:20',
        ], [
            'title.required' => 'العنوان مطلوب',
            'title.min' => 'لا يقبل أقل من 3 حروف',
            'title.max' => 'لا يقبل أكثر من 20 حروف',
        ]);

        DB::beginTransaction();

        if (!$validator->fails()) {
            try {
                $subActivity = new SubActivity();
                $subActivity->title = $request->get('titleActivity');
                $subActivity->end = $request->get('endActivity');
                $subActivity->start = $request->get('startActivity');
                $subActivity->activity_id = $request->get('project_id');
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
    public function update(Request $request, SubActivity $subActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubActivity  $subActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubActivity $subActivity)
    {
        //
    }
}
