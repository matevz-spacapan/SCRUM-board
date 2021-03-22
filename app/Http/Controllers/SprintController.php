<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Sprint;
use App\Models\Story;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SprintController extends Controller
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
        $this->authorize('viewAny', [Sprint::class, $project]);

        $sprints = Sprint::query()
            ->where('project_id', $project->id)
            ->orderByRaw('end_date < CURDATE(), end_date ASC') // expired at the end
            ->get();

        foreach ($sprints as $sprint) {
            if (Carbon::parse($sprint->end_date) < Carbon::now()) {
                // sprint has ended
                $sprint->has_ended = true;
            } else {
                $sprint->has_ended = false;
            }

            if (Carbon::create($sprint->start_date) <= Carbon::now() && Carbon::parse($sprint->end_date) >= Carbon::now()) {
                $sprint->in_progress = true;
            } else {
                $sprint->in_progress = false;
            }
        }

        return view('sprint.show', ['project' => $project, 'sprints' => $sprints, 'user' => auth()->user()]);
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
        $this->authorize('create', [Sprint::class, $project]);
        return view('sprint.create', ['id' => $project->id, 'project' => $project]);
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
        $this->authorize('create', [Sprint::class, $project]);
        $request->request->add(['project_id' => $project->id]);

        $data = $request->validate([
            'project_id' => ['required', 'numeric', 'min:0'],
            'speed' => 'required|numeric|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => ['required', 'date', 'after:start_date']
        ]);

        $start_date = $request->request->get('start_date');
        $end_date = $request->request->get('end_date');

        $overlaps = Sprint::query()
            ->where(function ($query) use ($end_date, $start_date) {
                $query->whereBetween('start_date', [$start_date, $end_date])
                    ->orWhereBetween('end_date', [$start_date, $end_date])
                    ->orWhereRaw('? BETWEEN start_date and end_date', [$start_date])
                    ->orWhereRaw('? BETWEEN start_date and end_date', [$end_date]);
            })
            ->where('project_id', $project->id)
            ->where('deleted_at')
            ->first();

        if ($overlaps) {
            return redirect()->back()->withErrors(['overlaps' => 'Sprint overlaps an existing sprint'])->withInput();
        }

        Sprint::create($data);

        return redirect()->route('sprint.index', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, Sprint $sprint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, Sprint $sprint)
    {
        Project::findOrFail($project->id);
        if ($sprint->project_id != $project->id) {
            abort(404);
        }
        if (Carbon::create($sprint->start_date) <= Carbon::now() && Carbon::parse($sprint->end_date) >= Carbon::now()) {
            $sprint->in_progress = true;
        } else {
            $sprint->in_progress = false;
        }
        $this->authorize('update', [Sprint::class, $sprint]);
        return view('sprint.create', ['id' => $project->id, 'sprint' => $sprint, 'project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project, Sprint $sprint)
    {
        Project::findOrFail($project->id);
        Sprint::findOrFail($sprint->id);
        $this->authorize('update', [Sprint::class, $sprint]);
        $request->request->add(['project_id' => $project->id]);

        if (($request->request->get('start_date') || $request->request->get('end_date'))) {
            // changing dates
            if (Carbon::create($sprint->start_date) <= Carbon::now() && Carbon::parse($sprint->end_date) >= Carbon::now()) {
                // sprint is in progress
                return redirect()->back()->withErrors(['in_progress' => 'Sprint is in progress'])->withInput();
            }

            $request->validate([
                'project_id' => ['required', 'numeric', 'min:0'],
                'speed' => 'required|numeric|min:1',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => ['required', 'date', 'after:start_date']
            ]);


            $start_date = $request->request->get('start_date');
            $end_date = $request->request->get('end_date');
            $overlaps = Sprint::query()
                ->where(function ($query) use ($end_date, $start_date) {
                    $query->whereBetween('start_date', [$start_date, $end_date])
                        ->orWhereBetween('end_date', [$start_date, $end_date])
                        ->orWhereRaw('? BETWEEN start_date and end_date', [$start_date])
                        ->orWhereRaw('? BETWEEN start_date and end_date', [$end_date]);
                })
                ->where('id', '!=', $sprint->id)
                ->where('project_id', $project->id)
                ->where('deleted_at')
                ->first();

            if ($overlaps) {
                return redirect()->back()->withErrors(['overlaps' => 'Sprint overlaps an existing sprint'])->withInput();
            }
        } else {
            $request->validate([
                'project_id' => ['required', 'numeric', 'min:0'],
                'speed' => 'required|numeric|min:1'
            ]);
        }

        $new_speed = $request->request->get('speed');
        $sprint_stories_points = Story::query()
            ->where('sprint_id', $sprint->id)
            ->sum('time_estimate');

        if ($new_speed < $sprint_stories_points) {
            return redirect()->back()->withErrors(['speed' => 'Speed can not be less than the combined time estimate for all stories in this sprint'])->withInput();
        }

        $sprint->update($request->all());

        return redirect()->route('sprint.index', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Sprint  $sprint
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Sprint $sprint)
    {
        Project::findOrFail($project->id);
        Sprint::findOrFail($sprint->id);
        $this->authorize('delete', [Sprint::class, $sprint]);
        if ($sprint->project_id != $project->id) {
            abort(404);
        }

        if (Carbon::create($sprint->start_date) <= Carbon::now() && Carbon::parse($sprint->end_date) >= Carbon::now()) {
            // sprint is in progress
            return redirect()->back()->withErrors(['in_progress ' . $sprint->id => 'Sprint is in progress'])->withInput();
        }

        $sprint->delete();

        return redirect()->back();
    }
}
