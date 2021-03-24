@extends('layouts.app')

@section('title', ' - '.$project->project_name)

@section('content')
    <div class="container">
        <div class="row">
            <h1 class="mx-auto">
                {{$project->project_name}} -
                @if($user->projects->where('id', $project->id)->pluck('product_owner')->contains(auth()->user()->id))
                    {{ __('Product owner') }}
                @elseif($user->projects->where('id', $project->id)->pluck('project_master')->contains(auth()->user()->id))
                    {{ __('Project master') }}
                @else
                    {{ __('Developer') }}
                @endif
            </h1>
        </div>
            <div class="d-flex align-items-center justify-content-between">
                <h5>Accepted stories</h5>
                <a class="btn btn-link"
                   href="{{ route('project.show', $project->id) }}" {{ Popper::arrow()->position('bottom')->pop('Return to the Project.') }}>{{ __('Go back') }}</a>
            </div>
            @include('story.loop', ['stories_list' => $stories, 'taskView'=>"0", 'active_sprint' => null])
    </div>
@endsection
