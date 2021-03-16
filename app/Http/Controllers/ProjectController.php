<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects= Project:all();

        return view('project.index')->with('projects', $projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::pluck('id', 'name');


        return view('project.create', compact('id', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Form validation
        $this->validate($request, [
            'project_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            
         ]);


        // validate
        $rules = array(
            'project_name'  => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('project/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $project = new Project;
            $project->name= Input::get('project_name');
            $project->product_owner= Input::get('product_owner');
            $project->srum_master= Input::get('scrum_master');


            $project->save();

            // redirect
            Session::flash('message', 'Successfully created project!');

            return redirect()->route('project.show', $project->id);
        }    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        Project::findOrFail($project->id);
        $this->authorize('view', [Project::class, $project]);
        $active_sprint = DB::select("SELECT * from sprints WHERE project_id={$project->id} AND start_date <= DATE(NOW()) AND end_date >= DATE(NOW())");
        if (count($active_sprint) > 0){
            $stories_project = DB::select("(SELECT * from stories WHERE project_id={$project->id} AND priority != 4 AND (sprint_id IS NULL OR sprint_id != {$active_sprint[0]->id})) UNION (SELECT * from stories WHERE project_id={$project->id} AND priority = 4 AND (sprint_id IS NULL OR sprint_id != {$active_sprint[0]->id}))");
            $stories_sprint = DB::select("(SELECT * from stories WHERE project_id={$project->id} AND sprint_id = {$active_sprint[0]->id})");
        }
        else{
            $stories_project = DB::select("(SELECT * from stories WHERE project_id={$project->id} AND priority != 4) UNION (SELECT * from stories WHERE project_id={$project->id} AND priority = 4)");
            $stories_sprint = [];
        }
        $sprints = DB::select("SELECT * from sprints
                WHERE project_id={$project->id}
                and sprints.end_date >= CURDATE()");
        return view('project.show', ['stories_project' => $stories_project, 'stories_sprint' => $stories_sprint, 'project' => $project, 'sprints' => $sprints, 'user' => auth()->user(), 'active_sprint' => $active_sprint]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $project = Project::findOrFail($project->id);
        return view('project.edit', ['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return index();
    }
}
