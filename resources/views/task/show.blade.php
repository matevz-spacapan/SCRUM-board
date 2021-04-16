@extends('layouts.app')
@section('title', '- Tasks')
@section('content')
    <div class="container">

    @include('story.loop', ['stories_list' => $story_list, 'taskView'=>"1"])

        <div class="card mb-3 align-middle">
            <div class="card-header d-flex">
                <div class="align-self-center"><h5 class="mb-0">Tasks</h5></div>
                @if($active_sprint)
                    @can("create", [\App\Models\Task::class, $project])
                        <a href="{{ route('task.create', [$project->id, $story->id]) }}" class="btn btn-success ml-3" {{ Popper::arrow()->position('right')->pop("Let's add some tasks! <i class='far fa-smile-beam'></i>") }}>{{ __('Add new task') }}</a>
                    @endcan
                @endif
            </div>
            <div class="card-body px-0 py-0">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="37%">Description</th>
                        <th width="13%" style="text-align: center">Time estimate</th>
                        <th width="15%" style="text-align: center">Asigned user</th>
                        <th width="20%" style="text-align: center">Status</th>
                        <th width="15%" style="text-align: center">Actions</th>
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
                                @if($task->work === 1)
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
                            <td width="37%" class="align-middle">{{ $task->description }}
                            </td>
                            <td width="13%" style="text-align: center" class="align-middle">{{ $task->time_estimate }} h</td>
                            <td width="15%" style="text-align: center" class="align-middle">
                                @if(is_null($task->user_id))
                                    <i class="fas fa-minus"></i>
                                @else
                                    {{ \App\Models\User::withTrashed()->where(['id' => $task->user_id])->pluck('username')->first() }}
                                @endif
                            </td>
                            <td width="20%" style="text-align:center; justify-content:center; align-items: center" class="{{ $color }} align-middle">
                                @if($task->accepted === 0 && Auth::User()->id === $task->user_id)
                                    <a href="{{ route('task.accept', [$project->id, $story->id, $task->id]) }}" class="btn btn-success"><i class="fas fa-check"></i></a>
                                    <a href="{{ route('task.reject', [$project->id, $story->id, $task->id]) }}" class="btn btn-danger"><i class="fas fa-times"></i></a>
                                @elseif($task->accepted === 0 && $task->user_id === null)
                                    <b><i>{{ $text }}</b></i>
                                    &nbsp;
                                    <a href="{{ route('task.accept', [$project->id, $story->id, $task->id]) }}" class="btn btn-success"><i class="fas fa-check"></i></a>
                                @elseif($task->accepted === 3)
                                    <b><i>{{ $text }}</b></i>
                                    &nbsp;
                                    <a href="{{ route('task.reopen', [$project->id, $story->id, $task->id]) }}" class="btn btn-danger"><i class="fas fa-undo"></i></a>
                                @else
                                    <b><i>{{ $text }}</b></i>
                                @endif
                                @if($task->accepted === 1 && Auth::user()->id === $task->user_id)
                                    &nbsp;
                                    <a href="{{ route('task.complete', [$project->id, $story->id, $task->id]) }}" class="btn btn-success"><i class="fas fa-clipboard-check"></i></a>
                                    <a href="{{ route('task.reject', [$project->id, $story->id, $task->id]) }}" class="btn btn-danger"><i class="fas fa-times"></i></a>
                                @endif
                            </td>
                            <td width="15%" style="text-align: center" class="align-middle">
                                @if($task->accepted != 3)
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary   dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if(Auth::User()->id === $task->user_id && $task->accepted === 1)
                                                <a href="{{ route('task.startwork', [$project->id, $story->id, $task->id]) }}" class="dropdown-item">Start work</a>
                                                <a href="{{ route('task.stopwork', [$project->id, $story->id, $task->id]) }}" class="dropdown-item">Stop work</a>
                                            @endif
                                                <a class="dropdown-item" href="{{route('task.edit', [$project->id, $story->id, $task->id]) }}">Edit</a>
                                                <button href="#" class="dropdown-item text-danger" data-toggle="modal" data-target="#deleteModal{{$task->id}}" {{ Popper::arrow()->position('right')->pop("Is this task all wrong? Delete it here") }}>{{ __('Delete') }}</button>
                                        </div>
                                     </div>
                                @endif

                            </td>
                        </tr>

                            <!-- Modal -->
                                <div class="modal fade" id="deleteModal{{$task->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{$task->id}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{$task->id}}">Are you sure you want to delete this Task?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal" {{ Popper::arrow()->position('right')->pop("Close this window, I changed my mind") }}>{{ __('Close') }}</button>
                                                <a href="{{ route('task.destroy', [$project->id, $story->id, $task->id]) }}" class="btn btn-danger" {{ Popper::arrow()->position('right')->pop("Yes, im sure. Now delete it!") }}>{{ __('Delete') }}</a>
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
