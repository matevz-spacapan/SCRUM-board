@extends('layouts.app')

@section('title', '- Sprints')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <h1 class="mx-auto">
                {{$project->project_name}} -
                @if($user->projects->where('id', $project->id)->pluck('product_owner')->contains(auth()->user()->id))
                    ({{ __('Product owner') }})
                @elseif($user->projects->where('id', $project->id)->pluck('project_master')->contains(auth()->user()->id))
                    ({{ __('Project master') }})
                @else
                    ({{ __('Developer') }})
                @endif
            </h1>
        </div>

        <div class="container">
            @can("create", [\App\Models\Sprint::class, $project])
                <div class="row">
                    <a href="{{ route('sprint.create', $project->id) }}"
                       class="btn btn-success mb-1 mr-auto ml-auto" {{ Popper::arrow()->position('right')->pop("Start a new Sprint, then add some awesome stories to it!") }}>Add
                        new sprint</a>
                </div>
            @endcan
            <div class="row">
                @foreach($sprints as $sprint)
                    @include('sprint.card', ['sprint' => $sprint, 'showFooter' => true])
                @endforeach
            </div>
        </div>
        @if(count($sprints) === 0)
            <p>This project has no sprints.</p>
        @endif
    </div>

@endsection
