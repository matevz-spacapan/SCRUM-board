<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;
use App\Models\Story;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

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
    public function create(Project $project, Story $story)
    {
        Project::findOrFail($project->id);
        Story::findOrFail($story->id);
        //$this->authorize('create', [Story::class, $project]);

        $a = Project::query()->where('id', $project->id)->pluck('product_owner');
        $user_list = User::query()->join("project_user", 'user_id', '=', 'users.id')->where('project_id', $project->id)
            ->where('user_id', '<>', $a[0])->get();

        return view('task.create', ['story' => $story, 'project' => $project, 'user_list'=> $user_list]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project, Story $story)
    {
        Story::findOrFail($story->id);
        Project::findOrFail($project->id);
        $this->authorize('create', [Task::class]);

        $request->request->add(['story_id' => $story->id]);
        $data = $request->validate([
            'description' => ['required', 'string'],
            'user_id' => ['numeric', 'nullable'],
            'story_id' => ['required', 'numeric', 'exists:stories,id'],
            'time_estimate' => ['required', 'numeric', 'between:1,100'],
        ]);

        if(Arr::get($data, 'user_id') == 0)
            Arr::pull($data, 'user_id');

        Task::create($data);

/*        return view('task.show', ['story' => $story, 'project' => $project, 'story_list' => [$story], 'active_sprint' => $active_sprint, 'tasks'=>$tasks, 'user_list'=>$user_list]);*/
        return redirect()->route('task.show', [$project->id, $story->id]);
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
        $tasks = Task::all()->where('story_id', $story->id);

        $active_sprint = Sprint::query()
            ->where('project_id', $project->id)
            ->where('start_date', '<=', Carbon::now()->toDateString())
            ->where('end_date', '>=', Carbon::now()->toDateString())->first();

        if($active_sprint->id != $story->sprint_id)
            $active_sprint = [];

        /*    ->join('sprint','id', '=', 'stories.sprint_id')->where('id', $story->id)*/

        return view('task.show', ['story' => $story, 'project' => $project, 'story_list' => [$story], 'active_sprint' => $active_sprint, 'tasks'=>$tasks]);
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
    public function destroy(Project $project, Story $story, Task $task)
    {
        Project::findOrFail($project->id);
        Task::findOrFail($task->id);
        Story::findOrFail($story->id);

        $task->delete();

/*        return view('task.show', ['story' => $story, 'project' => $project, 'story_list' => [$story], 'active_sprint' =>  $active_sprint, 'tasks'=>$tasks]);*/
        return redirect()->route('task.show', [$project->id, $story->id]);

    }
}
