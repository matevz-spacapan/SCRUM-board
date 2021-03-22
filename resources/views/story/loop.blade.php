@foreach($stories_list as $story)
    @switch($story->priority)
        @case(1)
        @php
            $text = __('Must have');
            $color='text-danger';
        @endphp
        @break
        @case(2)
        @php
            $text = __('Should have');
            $color='priority-2';
        @endphp
        @break
        @case(3)
        @php
            $text = __('Could have');
            $color='text-info';
        @endphp
        @break
        @default
        @php
            $text = __('Won\'t have this time');
            $color='text-muted';
        @endphp
    @endswitch
    @if($list = explode("\n", $story->tests)) @endif
    <div class="card mb-3">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    @if(is_null($story->sprint_id))
                        @can('update_sprints', [\App\Models\Story::class, $project])
                            <div class="form-check form-check-inline"  {{ ($taskView) == "1" ? 'style=display:none' : '' }}>
                                <input class="form-check-input" type="checkbox" {{ is_numeric($story->time_estimate) && count($active_sprint) > 0 ? "name=to_sprint[] value={$story->id} onclick=calculate(this,{$story->time_estimate})" : 'disabled' }} {{ Popper::arrow()->pop('Select to add to the active Sprint.') }}>
                            </div>
                        @endcan
                    @endif
                    @if(is_numeric($story->hash))
                        <div class="d-inline-block lead {{ $color }}">#{{ $story->hash }} - {{ $story->title }}</div>
                    @else
                        <div class="d-inline-block lead {{ $color }}">{{ $story->title }}</div>
                    @endif
                    <div>Priority: <b><i>{{ $text }}</i></b> | Business value: <b><i>{{ $story->business_value }}</i></b></div>
                </div>
                <div class="text-right">
                    <div {{ ($taskView) == "1" ? 'style=display:none' : '' }}>
                        Time estimate
                        @if(is_null($story->sprint_id))
                            @can('update_sprints', [\App\Models\Story::class, $project])
                                <input type="number" class="form-control text-center estimate" name="time_estimate[{{ $story->id }}]" value="{{ old("time_estimate[{$story->id}]", $story->time_estimate) }}" min="1" max="10" {{ Popper::arrow()->pop('Between 1 and 10.') }}> pts
                            @else
                                {{ $story->time_estimate ? "{$story->time_estimate} pts" : 'not set' }}
                            @endcan
                        @else
                            {{ $story->time_estimate }} pts
                        @endif
                    </div>
                    <div {{ ($taskView) == "0" ? 'style=display:none' : '' }}>
                        <a href="{{ route('project.show', $project->id) }}" class="btn btn-link" {{ Popper::arrow()->position('right')->pop("Back on project view") }}>{{ __('Go back') }}</a>
                    </div>
                    @if(is_numeric($story->sprint_id))
{{--                        <div>Tasks: <b data-toggle="tooltip" title="Complete / All"><i>1 / 7</i></b> | Work: <b data-toggle="tooltip" title="Spent / Remaining"><i>13h / 20h</i></b></div>--}}
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div>{!! nl2br($story->description) !!}</div>
            <div class="text-primary">
                <ul style="padding-left: 0; list-style: inside;">
                    @foreach($list as $num => $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="card-footer"  {{ ($taskView) == "1" ? 'style=display:none' : '' }}>
            @if(count($active_sprint) > 0 && $story->sprint_id === $active_sprint[0]->id)
                @can('acceptReject', [\App\Models\Story::class, $story, $project])
                    <button type="button" class="btn btn-success" disabled>Accept</button>
                    <button type="button" class="btn btn-warning">Reject</button>
                    <i class="text-muted">(DEBUG: Active sprint)</i>
                @endcan
            @elseif(is_null($story->sprint_id))
                @can("update", [\App\Models\Story::class, $project])
                    <a href="{{ route('story.edit' , [$project->id, $story->id]) }}" class="btn btn-primary" {{ Popper::arrow()->position('right')->pop("Something wrong with this story? Edit it here") }}>{{ __('Edit story') }}</a>
                @endcan
                @can("delete", [\App\Models\Story::class, $project])
                    <a href="#" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal{{$story->id}}" {{ Popper::arrow()->position('right')->pop("Is this story all wrong? Delete it here") }}>{{ __('Delete story') }}</a>
                @endcan
            @else
                @can('acceptReject', [\App\Models\Story::class, $story, $project])
                    <button type="button" class="btn btn-success" disabled>Accept</button>
                    <button type="button" class="btn btn-warning">Reject</button>
                    <i class="text-muted">(DEBUG: Old sprint)</i>
                @endcan
            @endif
                @can("viewAny", [\App\Models\Task::class])
                    <a href="{{ route('task.show', [$project->id, $story->id]) }}" class="btn btn-primary float-right">{{ __('View tasks') }}</a>
                @endcan
        </div>
    </div>
    @can("delete", [\App\Models\Story::class, $project])
        @if(is_null($story->sprint_id))
            <!-- Modal -->
            <div class="modal fade" id="deleteModal{{$story->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{$story->id}}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{$story->id}}">Are you sure you want to delete this story?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" {{ Popper::arrow()->position('right')->pop("Close this window, I changed my mind") }}>{{ __('Close') }}</button>
                            <a href="{{ route('story.destroy', [$project->id, $story->id]) }}" class="btn btn-danger" {{ Popper::arrow()->position('right')->pop("Yes, im sure. Now delete it!") }}>{{ __('Delete') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endcan

@endforeach
