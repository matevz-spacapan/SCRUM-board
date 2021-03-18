@extends('layouts.app')

@section('title', ' - '.$project->project_name)

@section('content')
<div class="container">
    <h1>
        {{$project->project_name}} -
        @if($user->projects->where('id', $project->id)->pluck('product_owner')->contains(auth()->user()->id))
            ({{ __('Product owner') }})
        @elseif($user->projects->where('id', $project->id)->pluck('project_master')->contains(auth()->user()->id))
            ({{ __('Project master') }})
        @else
            ({{ __('Developer') }})
        @endif
    </h1>
    <h4 class="mt-2">{{ __('Project sprints') }}</h4>

    @can("create", [\App\Models\Sprint::class, $project])
        <a href="{{ route('sprint.create', $project->id) }}" class="btn btn-success mb-3" {{ Popper::arrow()->position('right')->pop("Start a new Sprint, then add some awesome stories to it!") }}>Add new sprint</a>
    @endcan
    <div class="row row-cols-3">
        @foreach($sprints as $sprint)
            <div class="col my-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-text mb-2">
                            <b>Speed: {!! nl2br($sprint->speed) !!}</b><br>
                            <b>Start time: {!! nl2br($sprint->start_date) !!} </b><br>
                            <b>End time: {!! nl2br($sprint->end_date) !!}</b>
                        </div>
                    </div>
                    @can("update", [\App\Models\Sprint::class, $sprint])
                        @can("delete",  [\App\Models\Sprint::class, $sprint])
                            <div class="card-footer">
                                <a href="{{ route('sprint.edit', [$project->id, $sprint->id]) }}"
                                   class="btn btn-primary" {{ Popper::arrow()->position('left')->pop("Edit the sprint.") }}>{{__('Edit sprint')}}</a>
                                <a href="{{ route('sprint.delete', [$project->id, $sprint->id]) }}"
                                   class="btn btn-outline-danger" {{ Popper::arrow()->position('right')->pop("Delete the sprint.") }}>{{__('Delete sprint')}}</a>
                                @error('in_progress ' . $sprint->id)
                                <div class="invalid-feedback error-no-bound-field" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                        @endcan
                    @endcan
                </div>
            </div>
        @endforeach
    </div>
    @if(count($sprints) === 0)
        <p>This project has no active sprints.</p>
    @endif
    @include('story.loop', ['stories_list' => $stories_sprint])

    <h4 class="mt-5">{{ __('Project stories') }}</h4>
    @can("create", [\App\Models\Story::class, $project])
        <a href="{{ route('story.create', $project->id) }}" class="btn btn-success mb-3" {{ Popper::arrow()->position('right')->pop("Let's make something awesome! <i class='far fa-smile-beam'></i>") }}>{{ __('Add new story') }}</a>
    @endcan
    <form method="POST" action="{{ route('story.update_stories', $project->id) }}">
        @csrf
        @include('story.loop', ['stories_list' => $stories_project])

        @if(count($stories_project) === 0 && count($stories_sprint) === 0)
            <p>{{ __('This project has no stories.') }}</p>
        @elseif(count($stories_project) === 0 && count($stories_sprint) > 0)
            <p>{{ __('This project has no other stories.') }}</p>
        @else
            <div>
                @can('update_time', [\App\Models\Story::class, $project])
                    <button type="submit" name="time" class="btn btn-outline-secondary" {{ Popper::arrow()->pop('Input/Change time estimates for the stories on the list above.') }}>{{ __('Update time estimates') }} <i class="far fa-question-circle"></i></button>
                @endcan
                @can('update_sprints', [\App\Models\Story::class, $project])
                    @if(count($active_sprint) > 0)
                        <button type="submit" name="sprint" class="btn btn-outline-primary" {{ Popper::arrow()->position('right')->pop('Add check marks next to the story titles you wish to add to the active Sprint.') }}>{{ __('Add selected to sprint') }} <i class="far fa-question-circle"></i></button>
                    @else
                        <p class="mt-2">{{ __('A Sprint needs to be active, if you want to add stories to it.') }}</p>
                    @endif
                @endcan
            </div>
        @endif
    </form>
</div>
@endsection
