@extends('layouts.app')

@section('title', '- Sprints')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <h1 class="mx-auto">
                {{$project->project_name}} -
                @if($project->product_owner === auth()->user()->id)
                    {{ __('Product owner') }}
                @elseif($project->project_master === auth()->user()->id)
                    {{ __('Scrum master') }}
                @else
                    {{ __('Developer') }}
                @endif
            </h1>
        </div>

        <div class="container">
            <div class="row justify-content-center mb-1">
                @can("create", [\App\Models\Sprint::class, $project])
                    <a href="{{ route('sprint.create', $project->id) }}"
                       class="btn btn-success" {{ Popper::arrow()->position('right')->pop("Start a new Sprint, then add some awesome stories to it!") }}>Add
                        new sprint</a>
                @endcan
                <a class="btn btn-link"
                   href="{{ route('project.show', $project->id) }}" {{ Popper::arrow()->position('bottom')->pop('Return to the Project.') }}>{{ __('Go back') }}</a>
            </div>
            <div class="row">
                @foreach($sprints as $sprint)
                    <div class="mx-1">
                        @include('sprint.card', ['sprint' => $sprint, 'showFooter' => true])
                    </div>
                @endforeach
            </div>
        </div>
        @if(count($sprints) === 0)
            <p>This project has no sprints.</p>
        @endif
    </div>

@endsection
