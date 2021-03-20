<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;
use App\Models\Story;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function index(Story $story)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function create(Story $story)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Story $story)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, Story $story, Task $task)
    {
        Story::findOrFail($story->id);

        $active_sprint = Sprint::query()
            ->where('project_id', $project->id)
            ->where('start_date', '<=', Carbon::now()->toDateString())
            ->where('end_date', '>=', Carbon::now()->toDateString())->get();


        return view('task.show', ['story' => $story, 'project' => $project, 'story_list' => [$story], 'active_sprint' => $active_sprint]);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Story  $story
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Story $story, Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Story  $story
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Story $story, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Story  $story
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Story $story, Task $task)
    {
        //
    }
}
