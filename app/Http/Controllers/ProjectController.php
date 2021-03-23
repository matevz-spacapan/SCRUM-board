<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;
use App\Models\Story;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Project::orderBy('id','ASC')->paginate(5);
        return view('project.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::pluck( 'username', 'id' )->all();


        return view('project.create', compact('users'));
    }


    /**
     * Show the application dataAjax.
     *
     * 
     */
    public function userdataAjax(Request $request)
    {
        $search = $request->search;

        if($search == ''){
            $users = User::orderby('username','asc')->select('id','username')->limit(5)->get();
        }else{
            $users = User::orderby('username','asc')->select('id','username')->where('username', 'like', '%' .$search . '%')->limit(7)->get();
        }

        $response = array();
        foreach($users as $user){
            $response[] = array(
                "id"=>$user->username,  //->id
                "text"=>$user->username
            );
        }

        return json_encode($response);
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

            $project_owner= User::where('username', Input::get('project_owner'))->first();
            $project->product_owner= $project_owner;

            $project_master= User::where('username', Input::get('project_master'))->first();
            $project->project_master= $project_master;

            $developers = $request->name_pud;

            foreach($developers as $username) {
                $temp_user= User::where('username', Input::get($username))->first();
                project->users()->attach($temp_user->id);
            }


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
        $active_sprint = Sprint::query()
                            ->where('project_id', $project->id)
                            ->where('start_date', '<=', Carbon::now()->toDateString())
                            ->where('end_date', '>=', Carbon::now()->toDateString())->first();

        $a = Story::query()->where('project_id', $project->id)
            ->where('accepted', 0)
            ->where('priority', 4)
            ->whereNull('sprint_id');
        $stories_project = Story::query()->where('project_id', $project->id)
            ->where('accepted', 0)
            ->where('priority', '<>', 4)
            ->whereNull('sprint_id')
            ->union($a)->get();

        if ($active_sprint) {
            $stories_sprint = Story::query()->where('project_id', $project->id)
                ->where('accepted', 0)
                ->where('sprint_id', $active_sprint->id)->get();
            $stories_old = Story::query()->where('project_id', $project->id)
                ->where('accepted', 0)
                ->whereNotNull('sprint_id')
                ->where('sprint_id', '<>', $active_sprint->id)->get();
        } else {
            $stories_sprint = [];
            $stories_old = Story::query()->where('project_id', $project->id)
                ->where('accepted', 0)
                ->whereNotNull('sprint_id')->get();
        }

        $sprints = Sprint::query()
            ->where('project_id', $project->id)
            ->where('deleted_at')
            ->where('end_date', '>=', Carbon::now())
            ->get();

        if ($active_sprint){
            $sprint_sum = DB::select("SELECT sum(stories.time_estimate) AS time_estimate from stories WHERE sprint_id = {$active_sprint->id}")[0]->time_estimate;
        }
        else{
            $sprint_sum = 0;
        }

        return view('project.show', ['stories_project' => $stories_project, 'stories_sprint' => $stories_sprint, 'stories_old' => $stories_old, 'project' => $project, 'sprints' => $sprints, 'user' => auth()->user(), 'active_sprint' => $active_sprint, 'sprint_sum' => $sprint_sum]);
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

        $developers= $project->users();

        return view('project.edit', ['project' => $project, 'developers' => $developers]);
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
