@extends('layouts.app')
@section('title', '- Tasks')
@section('content')
    <div class="container">

        @include('story.loop', ['stories_list' => $story_list, 'taskView'=>"1"])

        <div class="card mb-3 align-middle">
            <div class="card-header d-flex">
                <div class="align-self-center"><h5 class="mb-0">Tasks</h5></div>
                @if($active_sprint && !$story_list[0]->accepted)
                    @can("create", [\App\Models\Task::class, $project])
                        <a href="{{ route('task.create', [$project->id, $story->id]) }}"
                           class="btn btn-success ml-3" {{ Popper::arrow()->position('right')->pop("Let's add some tasks! <i class='far fa-smile-beam'></i>") }}>{{ __('Add new task') }}</a>
                    @endcan
                @endif
            </div>
            <div class="card-body px-0 py-0">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th>Description</th>
                        <th>Time estimate</th>
                        <th>Actual amount worked</th>
                        <th>Assigned user</th>
                        <th>Status</th>
                        @if(!$story_list[0]->accepted)
                            <th>Actions</th>
                        @endif
                    </tr>
                    @foreach($tasks as $task)
                        @switch($task->accepted)
                            @case(0)
                            @php
                                $text = __('Pending');
                                $color='';
                            @endphp
                            @break
                            @case(1)
                            @if($task->is_worked_on())
                                @php
                                    $text = __('In progress');
                                    $color='text-primary';
                                @endphp
                            @else
                                @php
                                    $text = __('Accepted');
                                    $color='text-primary';
                                @endphp
                            @endif
                            @break
                            @case(2)
                            @php
                                $text = __('Declined');
                                $color='text-danger';
                            @endphp
                            @break
                            @case(3)
                            @php
                                $text = __('Completed');
                                $color='text-success';
                            @endphp
                            @break
                            @default
                        @endswitch
                        <tr>
                            <td>{{ $task->description }}
                            </td>
                            <td class="align-middle">{{ $task->time_estimate }} h
                            </td>
                            <td class="align-middle">{{ $task->works_sum_amount_min }} h
                            </td>
                            <td class="align-middle">
                                @if(is_null($task->user_id))
                                    <i class="fas fa-minus"></i>
                                @else
                                    {{ \App\Models\User::withTrashed()->where(['id' => $task->user_id])->pluck('username')->first() }}
                                @endif
                            </td>
                            <td class="{{ $color }} align-middle">
                                <b><i>{{ $text }}</i></b>
                            </td>

                            @if(!$story_list[0]->accepted)
                                <td class="align-middle">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary   dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                @if($task->is_worked_on() && $task->user->id !== Auth::User()->id) disabled
                                                @endif
                                                aria-expanded="false">Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if(Auth::User()->id === $task->user_id && $task->accepted === 1 && Auth::User()->working_on !== $task->id)
                                                <a href="{{ route('task.startwork', [$project->id, $story->id, $task->id]) }}"
                                                   class="dropdown-item">Start work</a>
                                            @elseif(Auth::User()->id === $task->user_id && $task->accepted === 1 && Auth::User()->working_on === $task->id)
                                                <a href="{{ route('task.stopwork', [$project->id, $story->id, $task->id]) }}"
                                                   class="dropdown-item">Stop work</a>
                                            @endif

                                            @if($task->accepted === 0 && Auth::User()->id === $task->user_id)
                                                <a href="{{ route('task.accept', [$project->id, $story->id, $task->id]) }}"
                                                   class="dropdown-item">Accept</a>
                                                <a href="{{ route('task.reject', [$project->id, $story->id, $task->id]) }}"
                                                   class="dropdown-item">Reject</a>
                                            @elseif($task->accepted === 0 && $task->user_id === null)
                                                <a href="{{ route('task.accept', [$project->id, $story->id, $task->id]) }}"
                                                   class="dropdown-item">Accept</a>
                                            @elseif($task->accepted === 3)
                                                <a href="{{ route('task.reopen', [$project->id, $story->id, $task->id]) }}"
                                                   class="dropdown-item">Reopen</a>
                                            @endif
                                            @if($task->accepted === 1 && Auth::user()->id === $task->user_id)
                                                <a href="{{ route('task.complete', [$project->id, $story->id, $task->id]) }}"
                                                   class="dropdown-item">Complete</a>
                                                    <a href="{{ route('task.reject', [$project->id, $story->id, $task->id]) }}"
                                                       class="dropdown-item">Reject</a>
                                                @endif

                                                @if( $task->user_id === null || Auth::User()->id === $task->user_id && $task->accepted === 1 )
                                                    <a class="dropdown-item"
                                                       href="{{route('task.edit', [$project->id, $story->id, $task->id]) }}">Edit</a>
                                                @endif

                                                @if(!$task->is_worked_on())
                                                    <a class="dropdown-item text-danger" data-toggle="modal" href="#"
                                                       data-target="#deleteModal{{$task->id}}">Delete</a>
                                                @endif

                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="deleteModal{{$task->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="deleteModalLabel{{$task->id}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{$task->id}}">Are you sure you want
                                            to delete this Task?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary"
                                                data-dismiss="modal" {{ Popper::arrow()->position('right')->pop("Close this window, I changed my mind") }}>{{ __('Close') }}</button>
                                        <a href="{{ route('task.destroy', [$project->id, $story->id, $task->id]) }}"
                                           class="btn btn-danger" {{ Popper::arrow()->position('right')->pop("Yes, im sure. Now delete it!") }}>{{ __('Delete') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
