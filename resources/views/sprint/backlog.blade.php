@extends('layouts.app')
@section('title', '- Sprint backlog')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-2">
                <div class="mx-auto">
                    <h4 class="text-center">{{ __('Currently active sprint') }}</h4>
                    @if($active_sprint)
                        @include('sprint.card', ['sprint' => $active_sprint])
                    @else
                        <p class="text-center">{{ __('No currently active sprint') }}</p>
                    @endif
                </div>
            </div>
            <div class="col-lg-8">
              @include('story.loop', ['stories_list' => $story_list, 'taskView'=>"1"])
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card mb-3 align-middle">
            <div class="card-header d-flex">
                <div class="align-self-center"><h5 class="mb-0">Unasigned tasks</h5></div>
            </div>
            <div class="card-body px-0 py-0">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="37%">Description</th>
                        <th width="13%" style="text-align: center">Time estimate</th>
                        <th width="15%" style="text-align: center">Asigned user</th>
                        <th width="20%" style="text-align: center">Status</th>
                        <th width="15%" style="text-align: center">Story</th>
                    </tr>
                    @foreach($tasksUnAs as $task)
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
                                $color='text-primary';
                            @endphp
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
                                <b><i>{{ $text }}</b></i>
                            </td>
                            <td width="15%" style="text-align: center" class="align-middle">
                                {{ \App\Models\Story::withTrashed()->where(['id' => $task->story_id])->pluck('Title')->first() }}
                           </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="card mb-3 align-middle">
            <div class="card-header d-flex">
                <div class="align-self-center"><h5 class="mb-0">Asigned tasks</h5></div>
            </div>
            <div class="card-body px-0 py-0">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="37%">Description</th>
                        <th width="13%" style="text-align: center">Time estimate</th>
                        <th width="15%" style="text-align: center">Asigned user</th>
                        <th width="20%" style="text-align: center">Status</th>
                        <th width="15%" style="text-align: center">Story</th>
                    </tr>
                    @foreach($tasksAs as $task)
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
                                $color='text-primary';
                            @endphp
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
                                <b><i>{{ $text }}</b></i>
                            </td>
                            <td width="15%" style="text-align: center" class="align-middle">
                                {{ \App\Models\Story::withTrashed()->where(['id' => $task->story_id])->pluck('Title')->first() }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="card mb-3 align-middle">
            <div class="card-header d-flex">
                <div class="align-self-center"><h5 class="mb-0">Active tasks</h5></div>
            </div>
            <div class="card-body px-0 py-0">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="37%">Description</th>
                        <th width="13%" style="text-align: center">Time estimate</th>
                        <th width="15%" style="text-align: center">Asigned user</th>
                        <th width="20%" style="text-align: center">Status</th>
                        <th width="15%" style="text-align: center">Story</th>
                    </tr>
                    @foreach($tasksAct as $task)
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
                                $color='text-primary';
                            @endphp
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
                                <b><i>{{ $text }}</b></i>
                            </td>
                            <td width="15%" style="text-align: center" class="align-middle">
                                {{ \App\Models\Story::withTrashed()->where(['id' => $task->story_id])->pluck('Title')->first() }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="card mb-3 align-middle">
            <div class="card-header d-flex">
                <div class="align-self-center"><h5 class="mb-0">Completed tasks</h5></div>
            </div>
            <div class="card-body px-0 py-0">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="37%">Description</th>
                        <th width="13%" style="text-align: center">Time estimate</th>
                        <th width="15%" style="text-align: center">Asigned user</th>
                        <th width="20%" style="text-align: center">Status</th>
                        <th width="15%" style="text-align: center">Story</th>
                    </tr>
                    @foreach($tasksCom as $task)
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
                                $color='text-primary';
                            @endphp
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
                                <b><i>{{ $text }}</b></i>
                            </td>
                            <td width="15%" style="text-align: center" class="align-middle">
                                {{ \App\Models\Story::withTrashed()->where(['id' => $task->story_id])->pluck('Title')->first() }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </div>

    </div>
@endsection
