<?php

namespace App\Http\Controllers;

use App\Models\Project;
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
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        Project::findOrFail($project->id);
        $this->authorize('view', [Project::class, $project]);
        $active_sprint = DB::select("SELECT * from sprints WHERE project_id={$project->id} AND start_date <= DATE(NOW()) AND end_date >= DATE(NOW())");
        if (count($active_sprint) > 0){
            $stories_project = DB::select("(SELECT * from stories WHERE project_id={$project->id} AND priority != 4 AND (sprint_id IS NULL OR sprint_id != {$active_sprint[0]->id})) UNION (SELECT * from stories WHERE project_id={$project->id} AND priority = 4 AND (sprint_id IS NULL OR sprint_id != {$active_sprint[0]->id}))");
            $stories_sprint = DB::select("(SELECT * from stories WHERE project_id={$project->id} AND sprint_id = {$active_sprint[0]->id})");
        }
        else{
            $stories_project = DB::select("(SELECT * from stories WHERE project_id={$project->id} AND priority != 4) UNION (SELECT * from stories WHERE project_id={$project->id} AND priority = 4)");
            $stories_sprint = [];
        }
        $sprints = DB::select("SELECT * from sprints
                WHERE project_id={$project->id}
                and sprints.deleted_at IS NULL
                and sprints.end_date >= CURDATE()");
        return view('project.show', ['stories_project' => $stories_project, 'stories_sprint' => $stories_sprint, 'project' => $project, 'sprints' => $sprints, 'user' => auth()->user(), 'active_sprint' => $active_sprint]);
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
