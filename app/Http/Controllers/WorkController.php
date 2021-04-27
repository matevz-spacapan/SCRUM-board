<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project, Task $task)
    {
        Project::findOrFail($project->id);
        Task::findOrFail($task->id);
        $this->authorize('view', [Project::class, $project]);

        $works = Work::query()
            ->where('task_id', $task->id)
            ->get();

        return view('work.show', ['project' => $project, 'task' => $task, 'works' => $works]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function store_direct(Task $task, Work $work)
    {
        $this->authorize('create', [Work::class, $task]);
        $work_in_database = Work::where('day', $work->day)
            ->where('task_id', $work->task->id)
            ->where('user_id', $work->user->id)
            ->first();

        if ($work_in_database) {
            $combined_time = $work_in_database->amount_min + $work->amount_min;
            $work_in_database->update(array('amount_min' => $combined_time));
        } else {
            Work::create($work->attributesToArray());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\Response
     */
    public function show(Work $work)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\Response
     */
    public function edit(Work $work)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Work $work)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Work $work
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        $this->authorize('delete', [Work::class, $work]);
        $work->delete();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
