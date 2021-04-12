@extends('layouts.app')

@section('title', ' - '.$project->project_name)

@section('page_specific_scripts')
    @if($active_sprint)
        <script>
            counter = {{ $sprint_sum }};
            sprint_max = {{ $active_sprint->speed }};

            function calculate(elt, val) {
                if (elt.checked) {
                    counter = counter + val;
                } else {
                    counter = counter - val;
                }
                ctr_div = document.getElementById("new_sprint_count");
                if (counter > sprint_max) {
                    document.getElementById("sprint_btn").disabled = true;
                ctr_div.classList.add("text-danger");
                }
                else{
                    document.getElementById("sprint_btn").disabled=false;
                    ctr_div.classList.remove("text-danger");
                }
                ctr_div.innerHTML = counter;
                if(document.querySelectorAll('input[type="checkbox"]:checked').length === 0){
                    document.getElementById("sprint_btn").disabled = true;
                }
            }
        </script>
@endif
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <div class="mx-auto">
                    <h4 class="text-center">{{ __('Currently active sprint') }}</h4>
                    @if($active_sprint)
                        @include('sprint.card', ['sprint' => $active_sprint])
                    @else
                        <p class="text-center">{{ __('No currently active sprint') }}</p>
                    @endif
                </div>
            </div>
            <div class="col-lg-8">
                @if(count($stories_sprint) > 0)
                    <h5>Stories in active sprint (<b>{{ $sprint_sum }}</b> <i
                            class="far fa-question-circle" {{ Popper::arrow()->pop('This includes already accepted stories.') }}></i>
                        pts / <b>{{ $active_sprint->speed }}</b> pts)</h5>
                    @include('story.loop', ['stories_list' => $stories_sprint, 'taskView'=>"0"])
                    <div class="mb-4"></div>
                @endif
                @if(count($stories_old) > 0)
                    <h5>Unapproved stories from previous sprint</h5>
                    @include('story.loop', ['stories_list' => $stories_old, 'taskView'=>"0"])
                    <div class="mb-4"></div>
                @endif

                <div class="d-flex flex-row align-items-center mb-3">
                    <h4 class="mr-2 mt-2">{{ __('Other project stories') }}</h4>
                    @can("create", [\App\Models\Story::class, $project])
                        <a href="{{ route('story.create', $project->id) }}"
                           class="btn btn-success" {{ Popper::arrow()->position('right')->pop("Let's make something awesome! <i class='far fa-smile-beam'></i>") }}><i class="fas fa-plus"></i> {{ __('Add new') }}</a>
                    @endcan
                </div>

                    <form method="POST" action="{{ route('story.update_stories', $project->id) }}">
                    @csrf
                    @include('story.loop', ['stories_list' => $stories_project, 'taskView'=>"0"])

                    @if(count($stories_project) === 0 && count($stories_sprint) === 0)
                        <p>{{ __('This project has no stories.') }}</p>
                    @elseif(count($stories_project) === 0 && count($stories_sprint) > 0)
                        <p>{{ __('This project has no other stories.') }}</p>
                    @else
                            <div class="d-flex flex-row align-items-center">
                                @can('update_sprints', [\App\Models\Story::class, $project])
                                    @if($active_sprint)
                                        <button type="submit" name="sprint" id="sprint_btn"
                                                class="btn btn-outline-primary" {{ Popper::arrow()->position('right')->pop('Add check marks next to the story titles you wish to add to the active Sprint.') }} disabled>{{ __('Add selected to sprint') }}
                                            <i class="far fa-question-circle"></i></button>
                                    @else
                                        <div class="mt-2">{{ __('A Sprint needs to be active, if you want to add stories to it.') }}</div>
                                    @endif
                                    <button type="submit" name="time"
                                            class="btn btn-outline-secondary ml-1" {{ Popper::arrow()->pop('Input/Change time estimates for the stories on the list above.') }}>{{ __('Update time estimates') }}
                                        <i class="far fa-question-circle"></i></button>
                                @endcan
                            </div>
                            @if($active_sprint)
                                <div class="mt-2">The sum of stories in the sprint and the selected stories is <b
                                        id="new_sprint_count">{{ $sprint_sum }}</b>. The sprint speed is
                                    <b>{{ $active_sprint->speed }}</b>.
                                </div>
                            @endif
                        @endif
                    </form>
            </div>
        </div>
    </div>
@endsection
