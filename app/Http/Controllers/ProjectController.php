<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;
use App\Models\Story;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Project::query()->orderBy('id')->paginate(5);
        return view('project.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Project::class);
        $users = User::orderby('username','asc')->select('id','username')->get();
        return view('project.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Project::class);

        if(!isset($request->developers)){
            return redirect()->back()->withErrors(['developers' => 'Select at least one developer.'])->withInput();
        }

        $data = $request->validate([
            'project_name' => ['required', 'string', 'max:255', 'unique:projects,project_name'],
            'product_owner' => ['required', 'numeric', 'exists:users,id', Rule::notIn([$request->project_master])],
            'project_master' => ['required', 'numeric', 'exists:users,id', Rule::notIn([$request->product_owner])],
            'developers.*' => ['required', 'numeric', 'max:255', 'exists:users,id'],
        ]);

        if(in_array($request->product_owner, $request->developers, true)){
            return redirect()->back()->withErrors(['developers' => 'Product owner must not be a developer.'])->withInput();
        }

        $lowTitle = array_map("strtolower", [$request->project_name]);
        $stevilo = DB::select( DB::raw("SELECT COUNT(*) as stevilka FROM projects WHERE LOWER(project_name) LIKE '".$lowTitle[0]."'") );
        if($stevilo[0]->stevilka > 0){
            return redirect()->back()->withErrors(['project_name' => 'A project with same name already exists.'])->withInput();
        }

        //insert data that we can do straight away (into the projects table)
        $project = new Project;
        $project->project_name = $data['project_name'];
        $project->product_owner = $data['product_owner'];
        $project->project_master = $data['project_master'];
        $project->documentation = '';

        //save the project and developer IDs
        $project->save();
        $project->users()->attach($data['developers']);

        return redirect()->route('project.show', $project->id);
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
        $accepted_stories = Story::query()->where('project_id', $project->id)
            ->where('accepted', 1)->get();

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
            if (!$sprint_sum) {
                $sprint_sum = 0;
            }
        } else {
            $sprint_sum = 0;
        }

        return view('project.show', ['stories_project' => $stories_project, 'accepted_stories' => $accepted_stories, 'stories_sprint' => $stories_sprint, 'stories_old' => $stories_old, 'project' => $project, 'sprints' => $sprints, 'user' => auth()->user(), 'active_sprint' => $active_sprint, 'sprint_sum' => $sprint_sum]);
    }

    /**
     * View the project's documentation
     */
    public function view_docs(Project $project)
    {
        Project::findOrFail($project->id);
        $this->authorize('view', [Project::class, $project]);

        return view('project.docs', ['project' => $project]);
    }

    /**
     * Download the project's documentation
     */
    public function download_docs(Project $project)
    {
        Project::findOrFail($project->id);
        $this->authorize('view', [Project::class, $project]);

        header("Content-type: text/markdown");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="docs.m"');
        $file = fopen('php://output', 'w');
        fwrite($file, $project->documentation);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Project $project
     * @param \App\Models\Story $story
     * @return \Illuminate\Http\Response
     */
    public function accepted_stories(Project $project)
    {
        Project::findOrFail($project->id);
        $this->authorize('view', [Project::class, $project]);
        $stories = Story::query()->where('project_id', $project->id)
            ->where('accepted', 1)->orderByDesc('sprint_id')->get();
        if(count($stories) === 0){
            abort(403, 'No accepted stories to show');
        }
        return view('story.accepted', ['project' => $project, 'stories' => $stories, 'user' => auth()->user()]);
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
