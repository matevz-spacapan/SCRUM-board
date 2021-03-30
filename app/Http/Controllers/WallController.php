<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Wall;
use Illuminate\Http\Request;

class WallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        Project::findOrFail($project->id);
        $this->authorize('view', [Project::class, $project]);
        $data = Wall::query()->orderBy('id', 'desc')->paginate(5);
        return view('wall.index', ['data' => $data, 'project' => $project]);
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
        $this->authorize('view', [Project::class, $project]);
        return view('wall.create', ['project' => $project]);
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
        $this->authorize('view', [Project::class, $project]);
        $request->request->add(['project_id' => $project->id]);
        $request->request->add(['user_id' => auth()->user()->id]);
        //dd($request);
        $data = $request->validate([
            'post' => ['required', 'string'],
            'project_id' => ['required', 'numeric'],
            'user_id' => ['required', 'numeric']
        ]);
        Wall::create($data);

        return redirect()->route('wall.index', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Wall  $wall
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, Wall $wall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Wall  $wall
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, Wall $wall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Wall  $wall
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, Wall $wall)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Wall  $wall
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Wall $wall)
    {
        //
    }
}
