@extends('layouts.app')
@section('title', '- Tasks')
@section('content')
    <div class="container">

    @include('story.loop', ['stories_list' => $story_list, 'taskView'=>"1"])

        <div class="card mb-3">
            <div class="card-header">
                <h5>Existing tasks</h5>
            </div>
            <div class="card-body px-0 py-0">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="40%">Description</th>
                        <th width="15%" style="text-align: center">Time estimate</th>
                        <th width="15%" style="text-align: center">Asigned user</th>
                        <th width="15%" style="text-align: center">Status</th>
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
                            @php
                                $text = __('Accepted');
                                $color='text-success';
                            @endphp
                            @break
                            @case(2)
                            @php
                                $text = __('Declined');
                                $color='text-danger';
                            @endphp
                            @break
                            @default
                        @endswitch
                    <tr>
                            <td width="40%">{{ $task->description }}</td>
                            <td width="15%" style="text-align: center">{{ $task->time_estimate }}</td>
                            <td width="15%" style="text-align: center">
                                @if(is_null($task->user_id))
                                    <i class="fas fa-minus"></i>
                                    @else
                                    {{ \App\Models\User::where(['id' => $task->user_id])->pluck('username')->first() }}
                                @endif
                            </td>
                            <td width="15%" style="text-align: center " class="{{ $color }}">
                                @if($task->user_id && $task->accepted != 0)<b><i>{{ $text }}</b></i>
                                @endif
                                @if(Auth::User()->id == $task->user_id && $task->accepted == 0)
                                    <button type="button" class="btn btn-success"><i class="fas fa-check"></i></button>
                                    <button type="button" class="btn btn-danger"><i class="fas fa-times"></i></button>
                                @endif
                                @if(is_null($task->user_id))
                                    <i class="fas fa-minus"></i>
                                @endif
                            </td>
                            <td width="15%" style="text-align: center">
                                <a class="btn btn-outline-primary" href="#">Edit</a>
                                <a href="#" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal{{$task->id}}" {{ Popper::arrow()->position('right')->pop("Is this task all wrong? Delete it here") }}>{{ __('Delete') }}</a>
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

        <h4 class="mt-5">{{ __('Other tasks') }}</h4>
        @if(count($active_sprint)>0)
            @can("create", [\App\Models\Task::class, $project])
                <a href="{{ route('task.create', [$project->id, $story->id]) }}" class="btn btn-success mb-3" {{ Popper::arrow()->position('right')->pop("Let's add some tasks! <i class='far fa-smile-beam'></i>") }}>{{ __('Add new task') }}</a>
            @endcan
        @endif
    </div>

@endsection
