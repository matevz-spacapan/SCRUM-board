<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $stories = DB::select("(SELECT * from stories WHERE project_id={$project->id} AND priority != 4) UNION (SELECT * from stories WHERE project_id={$project->id} AND priority = 4)");
        $sprints = DB::select("SELECT * from sprints WHERE project_id={$project->id} ORDER BY start_date ASC");
        return view('project.show', ['stories' => $stories, 'project' => $project, 'sprints' => $sprints]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update_stories(Request $request, Project $project)
    {
        // update time estimates for stories
        if($request->has('time')){
            $validator = Validator::make($request->all(), [
                'time_estimate.*' => ['nullable', 'numeric', 'between:1,10'],
            ])->validate();
            foreach ($validator['time_estimate'] as $id => $value){
                $story = Story::find($id);
                if (is_null($story->time_estimate) || isset($value)) {
                    $story->time_estimate = $value;
                    $story->save();
                }
            }
        }
        // add selected stories to active sprint
        else{

        }
        return redirect()->route('project.show', $project->id);
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
