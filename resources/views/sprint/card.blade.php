<div class="card @if($sprint->in_progress) card-current-sprint @endif @if($sprint->has_ended) card-disabled @endif">
    <div class="card-body">
        <div class="card-text mb-2">
            <h5 class="mx-auto text-center">{{ __('Sprint ' . $sprint->id) }}</h5>
            <b>Speed: {!! nl2br($sprint->speed) !!}</b><br>
            <b>Start time: {!! nl2br($sprint->start_date) !!} </b><br>
            <b>End time: {!! nl2br($sprint->end_date) !!}</b>
        </div>
    </div>

    @if(isset($showFooter))
        @can("update", [\App\Models\Sprint::class, $sprint])
            @can("delete",  [\App\Models\Sprint::class, $sprint])
                <div class="card-footer text-center">
                    <input type=button onClick="location.href='{{ route('sprint.edit', [$project->id, $sprint->id]) }}'"
                           class="btn btn-primary" @if($sprint->has_ended)  disabled
                           @endif
                           {{ Popper::arrow()->position('left')->pop("Edit the sprint.") }} value="{{__('Edit sprint')}}"/>
                    <input type=button data-toggle="modal" data-target="#deleteModal{{$sprint->id}}"
                           class="btn btn-outline-danger" @if($sprint->in_progress || $sprint->has_ended)  disabled
                           @endif {{ Popper::arrow()->position('right')->pop("Delete the sprint.") }} value="{{__('Delete sprint')}}"/>

                </div>
            @endcan
        @endcan
    @endif
</div>

@if(isset($showFooter))
    @can("delete", [\App\Models\Sprint::class, $sprint])
        <!-- Modal -->
        <div class="modal fade" id="deleteModal{{$sprint->id}}" tabindex="-1" role="dialog"
             aria-labelledby="deleteModalLabel{{$sprint->id}}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{$sprint->id}}">Are you sure you want to delete
                            this sprint?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary"
                                data-dismiss="modal" {{ Popper::arrow()->position('left')->pop("Close this window, I changed my mind") }}>{{ __('Close') }}</button>
                        <a href="{{ route('sprint.delete', [$project->id, $sprint->id]) }}"
                           class="btn btn-danger" {{ Popper::arrow()->position('right')->pop("Yes, im sure. Now delete it!") }}>{{ __('Delete') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endif
