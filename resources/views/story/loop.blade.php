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
                    @if(count($active_sprint) > 0 && (is_null($story->sprint_id) || $story->sprint_id != $active_sprint[0]->id))
                        @can('update_sprints', [\App\Models\Story::class, $project])
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" {{ $story->time_estimate ? "name=to_sprint[] value={$story->id}" : 'disabled' }}>
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
                    <div>
                        Time estimate
                        @if(!(count($active_sprint) > 0 && $story->sprint_id === $active_sprint[0]->id))
                            @can('update_time', [\App\Models\Story::class, $project])
                                <input type="number" class="form-control text-center estimate" name="time_estimate[{{ $story->id }}]" value="{{ old("time_estimate[{$story->id}]", $story->time_estimate) }}" min="1" max="10"> pts
                            @else
                                {{ $story->time_estimate ? "{$story->time_estimate} pts" : 'not set' }}
                            @endcan
                        @else
                            {{ $story->time_estimate }} pts
                        @endif
                    </div>
                    @if(!is_null($story->sprint_id))
<!--                        <div>Tasks: <b data-toggle="tooltip" title="Complete / All"><i>1 / 7</i></b> | Work: <b data-toggle="tooltip" title="Spent / Remaining"><i>13h / 20h</i></b></div>-->
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
        <div class="card-footer">
            <a href="#" class="btn btn-primary">{{ __('Edit story') }}</a> <a href="#" class="btn btn-outline-danger">{{ __('Delete story') }}</a>
        </div>
    </div>
@endforeach
