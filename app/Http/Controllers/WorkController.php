<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        $this->authorize('viewAny', [Work::class, $project]);

        $works = Work::query()
            ->where('task_id', $task->id)
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('work.show', ['project' => $project, 'task' => $task, 'works' => $works]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project, Task $task)
    {
        $this->authorize('viewAny', [Task::class, $project]);
        if (!$task->user || $task->user->id !== Auth::user()->id || $task->accepted === 3) {
            abort(403);
        }
        return view('work.create', ['project' => $project, 'task' => $task]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project, Task $task)
    {
        $this->authorize('view', [Project::class, $project]);
        $request->request->add(['task_id' => $task->id]);
        $request->request->add(['user_id' => Auth::user()->id]);

        $data = $request->validate([
            'user_id' => ['required', 'numeric', 'min:0'],
            'task_id' => ['required', 'numeric', 'min:0'],
            'amount_min' => ['required', 'numeric', 'min:0', 'max:720'],
            'time_estimate_min' => ['required', 'numeric', 'min:0'],
            'day' => 'required|date|before_or_equal:today'
        ]);

        $work = new Work();
        $work->fill($data);
        $work->time_estimate_min = floor($work->time_estimate_min * 60);
        $work->amount_min = floor($work->amount_min * 60);
        $this->store_direct($project, $task, $work);

        return redirect()->route('task.work', [$project->id, $task->id]);
    }

    public function store_direct(Project $project, Task $task, Work $work)
    {
        $this->authorize('view', [Project::class, $project]);
        $work_in_database = Work::where('day', $work->day)
            ->where('task_id', $work->task->id)
            ->where('user_id', $work->user->id)
            ->first();

        if ($work_in_database) {
            $combined_time = $work_in_database->amount_min + $work->amount_min;
            $work_in_database->update(array('amount_min' => $combined_time, 'time_estimate_min' => $work->time_estimate_min));
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
        $this->authorize('update', [Work::class, $work]);
        $data = $request->validate([
            'time_estimate_min' => ['required', 'numeric', 'min:0'],
            'amount_min' => ['required', 'numeric', 'min:0', 'max:1440']
        ]);

        $work->amount_min = $data['amount_min'];
        $work->time_estimate_min = $data['time_estimate_min'];

        $work->update();
        return new Response();
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
