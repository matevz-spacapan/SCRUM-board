<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Story;
use Illuminate\Http\Request;
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
        return view('story.create', ['id' => $project->id]);
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
            'hash' => ['numeric', 'unique:stories']
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
        Project::findOrFail($project->id);
        Story::findOrFail($story->id);

        return view('story.edit', ['story' => $story, 'project' => $project]);

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
        $this->authorize('update', [Story::class, $project]);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            #'project_id' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'tests' => ['required', 'string'],
            'priority' => 'required',
            'business_value' => ['required', 'numeric', 'between:1,10'],
            'hash' => ['numeric', 'unique:stories']
        ]);

        $story->update($data);

        return redirect()->route('project.show', $project->id);
    }

    /**
     * Update the time estimate in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Story  $story
     * @return \Illuminate\Http\Response
     */
    public function update_time(Request $request, Project $project, Story $story)
    {
        $data = $request->validate([
            'time_estimate' => ['required', 'numeric', 'min:1']
        ]);
        $story->update($data);
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
        $this->authorize('delete', [Story::class, $project]);

        $story->delete();
        return redirect()->route('project.show', $project->id);
    }
}
