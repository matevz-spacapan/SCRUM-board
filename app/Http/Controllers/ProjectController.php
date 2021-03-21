<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;
use App\Models\Story;
use Carbon\Carbon;
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
        $active_sprint = Sprint::query()
                            ->where('project_id', $project->id)
                            ->where('start_date', '<=', Carbon::now()->toDateString())
                            ->where('end_date', '>=', Carbon::now()->toDateString())->first();

        $a = Story::query()->where('project_id', $project->id)
            ->where('accepted', 0)
            ->where('priority', 4)
            ->whereNull('sprint_id');
        $stories_project = Story::query()->where('project_id', $project->id)
            ->where('accepted', 0)
            ->where('priority', '<>', 4)
            ->whereNull('sprint_id')
            ->union($a)->get();

        if ($active_sprint) {
            $stories_sprint = Story::query()->where('project_id', $project->id)
                ->where('accepted', 0)
                ->where('sprint_id', $active_sprint[0]->id)->get();
            $stories_old = Story::query()->where('project_id', $project->id)
                ->where('accepted', 0)
                ->whereNotNull('sprint_id')
                ->where('sprint_id', '<>', $active_sprint[0]->id)->get();
        } else {
            $stories_sprint = [];
            $stories_old = Story::query()->where('project_id', $project->id)
                ->where('accepted', 0)
                ->whereNotNull('sprint_id')->get();
        }

        $sprints = Sprint::query()
            ->where('project_id', $project->id)
            ->where('deleted_at')
            ->where('end_date', '>=', Carbon::now())
            ->get();

        if ($active_sprint){
            $sprint_sum = DB::select("SELECT sum(stories.time_estimate) AS time_estimate from stories WHERE sprint_id = {$active_sprint[0]->id}")[0]->time_estimate;
        }
        else{
            $sprint_sum = 0;
        }

        return view('project.show', ['stories_project' => $stories_project, 'stories_sprint' => $stories_sprint, 'stories_old' => $stories_old, 'project' => $project, 'sprints' => $sprints, 'user' => auth()->user(), 'active_sprint' => $active_sprint, 'sprint_sum' => $sprint_sum]);
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
