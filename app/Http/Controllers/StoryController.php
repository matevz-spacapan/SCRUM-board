<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        Project::findOrFail($project->id);
        $this->authorize('create', [Story::class, $project]);
        return view('story.create', ['project' => $project]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        Project::findOrFail($project->id);
        $this->authorize('create', [Story::class, $project]);
        $request->request->add(['project_id' => $project->id]);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255',
                Rule::unique('stories')->where(function ($query) use ($project) {
                return $query->where('project_id', $project->id); })],
            'project_id' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'tests' => ['required', 'string'],
            'priority' => 'required',
            'business_value' => ['required', 'numeric', 'between:1,10'],
            'hash' => ['nullable', 'numeric',
                Rule::unique('stories')->where(function ($query) use ($project) {
                    return $query->where('project_id', $project->id); })],
        ]);

        Story::create($data);

        return redirect()->route('project.show', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, Story $story)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, Story $story)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, Story $story)
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
        Project::findOrFail($project->id);

        // update time estimates for stories
        if($request->has('time')){
            $this->authorize('update_time', [Story::class, $project]);
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
        elseif ($request->has('sprint')){
            $this->authorize('update_sprints', [Story::class, $project]);
            $active_sprint = DB::select("SELECT * from sprints WHERE project_id={$project->id} AND start_date <= DATE(NOW()) AND end_date >= DATE(NOW())");
            if(count($active_sprint) === 0){
                abort(403, 'No active sprint.');
            }
            $validator = Validator::make($request->all(), [
                'to_sprint.*' => ['numeric']
            ])->validate();
            foreach ($validator['to_sprint'] as $id => $value){
                $story = Story::find($value);
                $story->sprint_id = $active_sprint[0]->id;
                $story->save();
            }
        }
        return redirect()->route('project.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Story $story)
    {
        //
    }
}
