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
                                <input class="form-check-input" type="checkbox" {{ is_numeric($story->time_estimate) && $active_sprint ? "name=to_sprint[] value={$story->id} onclick=calculate(this,{$story->time_estimate})" : 'disabled' }} {{ Popper::arrow()->pop('Select to add to the active Sprint.') }}>
                            </div>
                        @endcan
                    @endif
                    @if(is_numeric($story->hash))
                        <div class="d-inline-block lead {{ $color }}">#{{ $story->hash }} - {{ $story->title }}</div>
                    @else
                        <div class="d-inline-block lead {{ $color }}">{{ $story->title }}</div>
                    @endif
                    <div>Priority: <b><i>{{ $text }}</i></b> | Business value: <b><i>{{ $story->business_value }}</i></b>
                        @if($story->accepted)
                             | Finished in: <b><i>Sprint {{ $story->sprint_id }}</i></b>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <div {{ ($taskView) == "1" ? 'style=display:none' : '' }}>
                        Time estimate
                        @if(is_null($story->sprint_id))
                            @can('update_sprints', [\App\Models\Story::class, $project])
                                <input type="number" class="form-control text-center estimate"
                                       name="time_estimate[{{ $story->id }}]"
                                       value="{{ old("time_estimate[{$story->id}]", $story->time_estimate) }}" min="1"
                                       max="10" {{ Popper::arrow()->pop('Between 1 and 10.') }}> pts
                            @else
                                {{ $story->time_estimate ? "{$story->time_estimate} pts" : 'not set' }}
                            @endcan
                        @else
                            {{ $story->time_estimate }} pts
                        @endif
                    </div>
                    @if(is_numeric($story->sprint_id))
                        <div>Tasks:
                            <b {{ Popper::arrow()->pop('Completed / All') }}><i>{{ \App\Models\Task::query()->where('story_id', $story->id)->where('accepted', 3)->count() }}
                                    / {{ \App\Models\Task::query()->where('story_id', $story->id)->count() }}</i> <i
                                    class="far fa-question-circle"></i></b> | Work:
                            <b {{ Popper::arrow()->pop('Actual / Estimated') }}><i>{{ $story->amount_worked() }}h
                                    / {{ \App\Models\Task::query()->where('story_id', $story->id)->sum('time_estimate') }}
                                    h</i> <i class="far fa-question-circle"></i></b></div>
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
            @if($story->comment)
                <div class="text-muted">
                    {{ __('Rejection comment: ') }} <i>{{ $story->comment }}</i>
                </div>
            @endif
        </div>
        <div class="card-footer"  {{ ($taskView) == "1" ? 'style=display:none' : '' }}>
            @if($active_sprint && $story->sprint_id === $active_sprint->id)
                @can('acceptReject', [\App\Models\Story::class, $project])
                    @if($story->accepted === 0)
                        @if(\App\Models\Task::query()->where('story_id', $story->id)->count() > 0 && \App\Models\Task::query()->where('story_id', $story->id)->where('accepted', 3)->count() === \App\Models\Task::query()->where('story_id', $story->id)->count())
                            <form method="POST" action="{{ route('story.accept', [$project->id, $story->id]) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success" >Accept</button>
                            </form>
                        @else
                            <button type="submit" class="btn btn-success" disabled>Accept</button>
                        @endif
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#rejectModal{{ $story->id }}">Reject</button>
                        @include('story.reject', ['story' => $story])
                    @endif
                @endcan
            @elseif(is_null($story->sprint_id))
                @can("update", [\App\Models\Story::class, $project])
                    <a href="{{ route('story.edit' , [$project->id, $story->id]) }}" class="btn btn-primary" {{ Popper::arrow()->position('right')->pop("Something wrong with this story? Edit it here") }}>{{ __('Edit story') }}</a>
                @endcan
                @can("delete", [\App\Models\Story::class, $project])
                    <a href="#" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal{{$story->id}}" {{ Popper::arrow()->position('right')->pop("Is this story all wrong? Delete it here") }}>{{ __('Delete story') }}</a>
                @endcan
                @can("addTasks", [\App\Models\Story::class, $project])
                    <a href="#" class="btn btn-success float-right">{{ __('Add tasks') }}</a>
                @endcan
            @else
                @can('acceptReject', [\App\Models\Story::class, $project])
                    @if($story->accepted === 0)
                        @if(\App\Models\Task::query()->where('story_id', $story->id)->count() > 0 && \App\Models\Task::query()->where('story_id', $story->id)->where('accepted', 3)->count() === \App\Models\Task::query()->where('story_id', $story->id)->count())
                            <form method="POST" action="{{ route('story.accept', [$project->id, $story->id]) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success" >Accept</button>
                            </form>
                        @else
                            <button type="submit" class="btn btn-success" disabled>Accept</button>
                        @endif
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#rejectModal{{ $story->id }}">Reject</button>
                        @include('story.reject', ['story' => $story])
                    @endif
                @endcan
            @endif
            @can("viewAny", [\App\Models\Task::class, $project])
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
