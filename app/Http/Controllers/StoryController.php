<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Story;
use Illuminate\Http\Request;

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
            'title' => ['required', 'string', 'max:255'],
            'project_id' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'tests' => ['required', 'string'],
            'priority' => 'required',
            'business_value' => ['required', 'numeric', 'min:0']
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
