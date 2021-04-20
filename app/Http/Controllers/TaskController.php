<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;
use App\Models\Story;
use App\Models\Task;
use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

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
            $this->authorize('create', [Task::class, $project]);

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
        $this->authorize('create', [Task::class, $project]);

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

        $this->authorize('viewAny', [Task::class, $project]);

        $active_sprint = Sprint::query()
            ->where('project_id', $project->id)
            ->where('start_date', '<=', Carbon::now()->toDateString())
            ->where('end_date', '>=', Carbon::now()->toDateString())->first();

        if($active_sprint && $active_sprint->id != $story->sprint_id)
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
    public function edit(Project $project, Story $story, Task $task)
    {
        Project::findOrFail($project->id);
        Story::findOrFail($story->id);
        Task::findOrFail($task->id);

        if ($story->id != $task->story_id) {
            abort(404);
        }

        $errorId = 'errorTask'.$task->id;
        $izBaze = Task::query()->where('id', $task->id);

        $this->authorize('create', [Task::class, $project]);

        if(Task::query()->where('id', $task->id)->pluck('accepted')[0] == 3)
            return redirect()->route('task.show', [$project->id, $story->id])->withErrors([$errorId => 'Task was already completed!']);
            //abort(403, 'Task was already completed');
        elseif($izBaze->pluck('user_id')[0] != null && Auth::user()->id !== $izBaze->pluck('user_id')[0] && $izBaze->pluck('accepted')[0] != 0)
            return redirect()->route('task.show', [$project->id, $story->id])->withErrors([$errorId => 'You are not the assigned developer!']);

        $a = Project::query()->where('id', $project->id)->pluck('product_owner');
        $user_list = User::query()->join("project_user", 'user_id', '=', 'users.id')->where('project_id', $project->id)
            ->where('user_id', '<>', $a[0])->get();

        return view('task.edit', ['story' => $story, 'project' => $project, 'user_list'=> $user_list, 'task'=>$task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Story  $story
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, Story $story, Task $task)
    {
        Project::findOrFail($project->id);
        Story::findOrFail($story->id);
        Task::findOrFail($task->id);

        if ($story->id != $task->story_id) {
            abort(404);
        }

        $this->authorize('create', [Task::class, $project]);

        $data = $request->validate([
            'description' => ['required', 'string'],
            'user_id' => ['numeric', 'nullable'],
            'time_estimate' => ['required', 'numeric', 'between:1,100'],
        ]);

        if(Task::query()->where('id', $task->id)->pluck('accepted')[0] === 1)
            if(Arr::get($data, 'user_id') != null)
                abort(403, 'You cannot change user on accepted or completed task');


        if(Arr::get($data, 'user_id') == 0 && Task::query()->where('id', $task->id)->pluck('accepted')[0] != 1)
            $data['user_id']=null;

        $task->update($data);

        return redirect()->route('task.show', [$project->id, $story->id]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Story  $story
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */

    public function accept(Project $project, Story $story, Task $task)
    {
        Project::findOrFail($project->id);
        Task::findOrFail($task->id);
        Story::findOrFail($story->id);

        $errorId = 'errorTask'.$task->id;

        $izBaze = Task::query()->where('id', $task->id);

        if(Auth::user()->id !== $izBaze->pluck('user_id')[0] && $izBaze->pluck('accepted')[0] != 0)
            return redirect()->route('task.show', [$project->id, $story->id])->withErrors([$errorId => 'You are not the assigned developer!']);
            //abort(403, 'You are not the assigned user');
        elseif($story->id !== $izBaze->pluck('story_id')[0])
            abort(403, 'You are not located on correct story');
        elseif($izBaze->pluck('user_id')[0] === 0)
            return redirect()->route('task.show', [$project->id, $story->id])->withErrors([$errorId => 'This task has no asigned developer!']);
        elseif($izBaze->pluck('user_id')[0] != null && $izBaze->pluck('user_id')[0] != Auth::user()->id && $izBaze->pluck('accepted')[0] === 0)
            return redirect()->route('task.show', [$project->id, $story->id])->withErrors([$errorId => 'Developer is already assigned on this task!']);
        else
            Task::where('id', $task->id)->update(array('accepted' => 1, 'user_id' => Auth::user()->id));

        return redirect()->route('task.show', [$project->id, $story->id]);

    }

    public function complete(Project $project, Story $story, Task $task)
    {
        Project::findOrFail($project->id);
        Task::findOrFail($task->id);
        Story::findOrFail($story->id);

        $izBaze = Task::query()->where('id', $task->id);

        $errorId = 'errorTask'.$task->id;

        if(Auth::user()->id !== $izBaze->pluck('user_id')[0])
            return redirect()->route('task.show', [$project->id, $story->id])->withErrors([$errorId => 'You are not the assigned developer!']);
        //abort(403, 'You are not the assigned user');
        elseif ($story->id !== $izBaze->pluck('story_id')[0])
            abort(403, 'You are not located on correct story');
        elseif ($izBaze->pluck('accepted')[0] === 3)
            return redirect()->route('task.show', [$project->id, $story->id])->withErrors([$errorId => 'This task was already completed!']);
        //abort(403, 'This task was already completed');
        elseif ($izBaze->pluck('accepted')[0] != 1)
            return redirect()->route('task.show', [$project->id, $story->id])->withErrors([$errorId => 'This task is not accepted yet!']);
        //abort(403, 'This task is not accepted yet');
        else {
            $this->stopwork($project, $story, $task);
            Task::where('id', $task->id)->update(array('accepted' => 3));
        }

        return redirect()->route('task.show', [$project->id, $story->id]);

    }

    public function reject(Project $project, Story $story, Task $task){
        Project::findOrFail($project->id);
        Task::findOrFail($task->id);
        Story::findOrFail($story->id);
        $izBaze = Task::query()->where('id', $task->id);

        $errorId = 'errorTask'.$task->id;

        if (Auth::user()->id !== $izBaze->pluck('user_id')[0] && $izBaze->pluck('accepted')[0] != 0)
            return redirect()->route('task.show', [$project->id, $story->id])->withErrors([$errorId => 'You are not the assigned developer!']);
        //abort(403, 'You are not the assigned user');
        elseif ($story->id !== $izBaze->pluck('story_id')[0])
            abort(403, 'You are not located on correct story');
        elseif ($izBaze->pluck('user_id')[0] === 0)
            return redirect()->route('task.show', [$project->id, $story->id])->withErrors([$errorId => 'This task has no asigned developer!']);
        //abort(403, 'This task has no asigned user');
        else {
            $this->stopwork($project, $story, $task);
            Task::where('id', $task->id)->update(array('accepted' => 0, 'user_id' => null));
        }

        return redirect()->route('task.show', [$project->id, $story->id]);

    }

    public function reopen(Project $project, Story $story, Task $task){
        Project::findOrFail($project->id);
        Task::findOrFail($task->id);
        Story::findOrFail($story->id);
        $izBaze = Task::query()->where('id', $task->id);

        $errorId = 'errorTask'.$task->id;

        if($story->id !== $izBaze->pluck('story_id')[0])
            abort(403, 'You are not located on correct story');
        elseif($izBaze->pluck('user_id')[0] === 0)
            return redirect()->route('task.show', [$project->id, $story->id])->withErrors([$errorId => 'This task has no asigned developer!']);
            //abort(403, 'This task has no asigned user');
        else {
            Task::where('id', $task->id)->update(array('accepted' => 0, 'user_id' => null));
        }

        return redirect()->route('task.show', [$project->id, $story->id]);

    }

    public function startwork(Project $project, Story $story, Task $task)
    {
        Project::findOrFail($project->id);
        Task::findOrFail($task->id);
        Story::findOrFail($story->id);
        $this->authorize('startWork', [Work::class, $task]);

        User::where('id', Auth::user()->id)->update(array('working_on' => $task->id, 'started_working_at' => Carbon::now()));

        return redirect()->route('task.show', [$project->id, $story->id]);

    }

    public function stopwork(Project $project, Story $story, Task $task)
    {
        Project::findOrFail($project->id);
        Task::findOrFail($task->id);
        Story::findOrFail($story->id);
        $this->authorize('startWork', [Work::class, $task]);

        User::where('id', Auth::user()->id)->update(array('working_on' => null, 'started_working_at' => null));

        return redirect()->route('task.show', [$project->id, $story->id]);

    }


    public function destroy(Project $project, Story $story, Task $task)
    {
        Project::findOrFail($project->id);
        Task::findOrFail($task->id);
        Story::findOrFail($story->id);

        $errorId = 'errorTask'.$task->id;

       // dd(Task::query()->where('id', $task->id)->pluck('accepted')[0]);
        $this->authorize('create', [Task::class, $project]);

        if(Task::query()->where('id', $task->id)->pluck('accepted')[0] === 3)
            return redirect()->route('task.show', [$project->id, $story->id])->withErrors([$errorId => 'Task was already completed!']);
            //abort(403, 'Task was already completed');
        else
            $task->delete();

/*        return view('task.show', ['story' => $story, 'project' => $project, 'story_list' => [$story], 'active_sprint' =>  $active_sprint, 'tasks'=>$tasks]);*/
        return redirect()->route('task.show', [$project->id, $story->id]);

    }
}
