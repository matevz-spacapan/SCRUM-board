<div class="col my-3">
    <div class="card h-100">
        <div class="card-body">
            <div class="card-text mb-2">
                <h5 class="mx-auto text-center">{{ __('Sprint ' . $sprint->id) }}</h5>
                <b>Speed: {!! nl2br($sprint->speed) !!}</b><br>
                <b>Start time: {!! nl2br($sprint->start_date) !!} </b><br>
                <b>End time: {!! nl2br($sprint->end_date) !!}</b>
            </div>
        </div>

        @if(isset($showFooter))
            @can('isNotInProgress', [\App\Models\Sprint::class, $sprint])
                @can("update", [\App\Models\Sprint::class, $sprint])
                    @can("delete",  [\App\Models\Sprint::class, $sprint])
                        <div class="card-footer">
                            <a href="{{ route('sprint.edit', [$project->id, $sprint->id]) }}"
                               class="btn btn-primary" {{ Popper::arrow()->position('left')->pop("Edit the sprint.") }}>{{__('Edit sprint')}}</a>
                            <a href="{{ route('sprint.delete', [$project->id, $sprint->id]) }}"
                               class="btn btn-outline-danger" {{ Popper::arrow()->position('right')->pop("Delete the sprint.") }}>{{__('Delete sprint')}}</a>
                        </div>
                    @endcan
                @endcan
            @endcan
        @endif
    </div>
</div>
