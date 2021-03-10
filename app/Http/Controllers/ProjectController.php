<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function show($id)
    {
        $project = Project::findOrFail($id);
        $stories = DB::select("SELECT * from stories WHERE project_id={$id}");
        return view('project.show', ['stories' => $stories, 'id' => $id, 'project' => $project]);
    }

    public function create_story($id)
    {
        Project::findOrFail($id);
        $this->authorize('create_story', [Project::class, $id]);
        return view('story.create', ['id' => $id]);
    }

    public function store_story($id, Request $request)
    {
        Project::findOrFail($id);
        $this->authorize('create_story', [Project::class, $id]);
        $request->request->add(['project_id' => $id]);
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'project_id' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'tests' => ['required', 'string'],
            'priority' => 'required',
            'business_value' => ['required', 'numeric', 'min:0']
        ]);

        Story::create($data);

        return redirect()->route('project.show', $id);
    }
}
