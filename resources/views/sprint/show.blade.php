@extends('layouts.app')

@section('title', '- Sprints')

@section('content')

    <div class="container-fluid">
        <div class="container">
            <div class="d-flex flex-row align-items-center mb-3">
                <h4 class="mr-2 mt-2">{{ __('Sprint list') }}</h4>
                @can("create", [\App\Models\Sprint::class, $project])
                    <a href="{{ route('sprint.create', $project->id) }}"
                       class="btn btn-success" {{ Popper::arrow()->position('right')->pop("Start a new Sprint, then add some awesome stories to it!") }}>Add
                        new sprint</a>
                @endcan
            </div>
            <div class="row">
                @foreach($sprints as $sprint)
                    <div class="mx-1">
                        @include('sprint.card', ['sprint' => $sprint, 'showFooter' => true])
                    </div>
                @endforeach
            </div>
            @if(count($sprints) === 0)
                <p>This project has no sprints.</p>
            @endif
        </div>
    </div>

@endsection
