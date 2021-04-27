@extends('layouts.app')

@section('title', __(' - Project tasks'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-baseline">
                        <div>{{ __('Project tasks') }}</div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Story</th>
                                <th>Task description</th>
                                <th>Manage work</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($story_task_dict as $task_list)
                                <tr>
                                    <th rowspan="{{count($task_list)}}">{{$task_list[0]->story->title}}</th>
                                    <td class="@if(!$task_list[0]->user || $task_list[0]->user->id !== Auth::user()->id || $task_list[0]->accepted === 3) grayed @endif">{{$task_list[0]->description}}</td>
                                    <td class="@if(!$task_list[0]->user || $task_list[0]->user->id !== Auth::user()->id || $task_list[0]->accepted === 3) grayed @endif">
                                        <a href="{{ route('task.work', [$project->id, $task_list[0]->id]) }}"
                                           class="btn btn-primary" type="button">See my work</a>
                                    </td>
                                </tr>

                                @for ($i = 1; $i < count($task_list); $i++)
                                    <tr class="@if(!$task_list[$i]->user || $task_list[$i]->user->id !== Auth::user()->id || $task_list[$i]->accepted === 3) grayed @endif">
                                        <td>{{$task_list[$i]->description}}</td>
                                        <td>
                                            <a href="{{ route('task.work', [$project->id, $task_list[$i]->id]) }}"
                                               class="btn btn-primary" type="button">See my work</a>
                                        </td>
                                    </tr>
                                @endfor
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
