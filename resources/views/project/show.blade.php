@extends('layouts.app')

@section('title', ' - '.$project->project_name)

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
        <div class="row">
            <div class="col-sm-2">
                <h4 class="mx-auto text-center">{{ __('Currently active sprint') }}</h4>
                @include('sprint.card', ['sprint' => $active_sprint])
            </div>
            <div class="col-sm-8">
                @include('story.loop', ['stories_list' => $stories_sprint])

                <h4 class="mt-5">{{ __('Project stories') }}</h4>
                @can("create", [\App\Models\Story::class, $project])
                    <a href="{{ route('story.create', $project->id) }}"
                       class="btn btn-success mb-3" {{ Popper::arrow()->position('right')->pop("Let's make something awesome! <i class='far fa-smile-beam'></i>") }}>{{ __('Add new story') }}</a>
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
                                <button type="submit" name="time"
                                        class="btn btn-outline-secondary" {{ Popper::arrow()->pop('Input/Change time estimates for the stories on the list above.') }}>{{ __('Update time estimates') }}
                                    <i class="far fa-question-circle"></i></button>
                            @endcan
                            @can('update_sprints', [\App\Models\Story::class, $project])
                                @if(count($active_sprint) > 0)
                                    <button type="submit" name="sprint"
                                            class="btn btn-outline-primary" {{ Popper::arrow()->position('right')->pop('Add check marks next to the story titles you wish to add to the active Sprint.') }}>{{ __('Add selected to sprint') }}
                                        <i class="far fa-question-circle"></i></button>
                                @else
                                    <p class="mt-2">{{ __('A Sprint needs to be active, if you want to add stories to it.') }}</p>
                                @endif
                            @endcan
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
