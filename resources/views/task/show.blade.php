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
                    <tr>
                            <td width="40%">{{ $task->description }}</td>
                            <td width="15%" style="text-align: center">{{ $task->time_estimate }}</td>
                            <td width="15%" style="text-align: center">{{ \App\Models\User::where(['id' => $task->user_id])->pluck('username') }}</td>
                            <td width="15%" style="text-align: center">{{ $task->accepted }}</td>
                            <td width="15%" style="text-align: center">
                                <a class="btn btn-primary" href="#">Edit</a>
                                <a class="btn btn-danger" href="#">Delete</a>

                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <h4 class="mt-5">{{ __('Other tasks') }}</h4>
        @can("create", [\App\Models\Task::class])
            <a href="{{ route('task.create', [$project->id, $story->id]) }}" class="btn btn-success mb-3" {{ Popper::arrow()->position('right')->pop("Let's add some tasks! <i class='far fa-smile-beam'></i>") }}>{{ __('Add new task') }}</a>
        @endcan
        <a href="#" class="btn btn-outline-primary mb-3">{{ __('Accepted tasks') }}</a>

    </div>
@endsection
