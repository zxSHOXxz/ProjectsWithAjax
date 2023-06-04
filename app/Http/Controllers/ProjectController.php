<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Project;
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
        $validator = validator($request->all(), [
            'title' => 'required|string|min:3|max:20',
        ], [
            'title.required' => 'العنوان مطلوب',
            'title.min' => 'لا يقبل أقل من 3 حروف',
            'title.max' => 'لا يقبل أكثر من 20 حروف',
        ]);

        DB::beginTransaction();

        try {
            if (!$validator->fails()) {
                $project = new Project();
                $project->title = $request->get('title');
                $project->end = $request->get('end');
                $project->start = $request->get('start');
                $isSaved = $project->save();

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
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
