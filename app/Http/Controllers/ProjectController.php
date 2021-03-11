<?php

namespace App\Http\Controllers;

use App\Models\Project;
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

}
