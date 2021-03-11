<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SprintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Project $project)
    {
        $sprints = DB::select("SELECT * from sprints WHERE project_id={$project->id}");
        return view('sprint.index', ['sprints'=>$sprints]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(Project $project)
    {
        Project::findOrFail($project->id);
        $this->authorize('create', [Sprint::class, $project]);
        return view('sprint.create', ['id' => $project->id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request, Project $project)
    {
        Project::findOrFail($project->id);
        $this->authorize('create', [Sprint::class, $project]);
        $request->request->add(['project_id' => $project->id]);
        $data = $request->validate([
            'project_id' => ['required', 'numeric', 'min:0'],
            'speed' => 'required|numeric|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:today'
        ]);

        Sprint::create($data);

        return redirect()->route('sprint.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Sprint $sprint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, Sprint $sprint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Sprint $sprint)
    {
        //
    }
}
