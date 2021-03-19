<h4 class="mt-2">{{ __('Project sprints') }}</h4>

@can("create", [\App\Models\Sprint::class, $project])
    <a href="{{ route('sprint.create', $project->id) }}"
       class="btn btn-success mb-3" {{ Popper::arrow()->position('right')->pop("Start a new Sprint, then add some awesome stories to it!") }}>Add
        new sprint</a>
@endcan
<div class="row row-cols-3">
    @foreach($sprints as $sprint)
        @include('sprint.card', ['sprint' => $sprint])
    @endforeach
</div>
@if(count($sprints) === 0)
    <p>This project has no sprints.</p>
@endif
