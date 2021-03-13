@extends('layouts.app')

@section('title', ' - '.$project->project_name)

@section('content')
<div class="container">
    <h1>{{$project->project_name}}</h1>

    <h4 class="mt-2">{{ __('Project sprints') }}</h4>

    @can("create", [\App\Models\Sprint::class, $project])
        <a href="{{ route('sprint.create', $project->id) }}" class="btn btn-success mb-3">Add new sprint</a>
    @endcan
    <div class="row row-cols-3">
        @foreach($sprints as $sprint)
            <div class="col my-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-text mb-2">
                            <b>Speed: {!! nl2br($sprint->speed) !!}</b><br>
                            <b>Start time: {!! nl2br($sprint->start_date) !!} </b><br>
                            <b>End time: {!! nl2br($sprint->end_date) !!}</b>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary">{{__('Edit sprint')}}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <h4 class="mt-5">{{ __('Project stories') }}</h4>
    @can("create", [\App\Models\Story::class, $project])
        <a href="{{ route('story.create', $project->id) }}" class="btn btn-success mb-3">Add new story</a>
    @endcan
    @foreach($stories as $story)
        @switch($story->priority)
            @case(1)
            @php
                $text = __('Must have');
                $color='priority-1 text-light';
            @endphp
            @break
            @case(2)
            @php
                $text = __('Should have');
                $color='priority-2 text-light';
            @endphp
            @break
            @default
            @php
                $text = __('Could have');
                $color='priority-3';
            @endphp
        @endswitch
        @if($list = explode("\n", $story->tests)) @endif
        <div class="card mb-3">
            <div class="card-header {{ $color }}">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3>#{{ $story->id }} - {{ $story->title }}</h3>
                        <div>Priority: <b><i>{{ $text }}</i></b> | Business value: <b><i>{{ $story->business_value }}</i></b></div>
                    </div>
                    <div>
                        <div>Sprint estimate <input type="text" class="form-control text-center estimate" disabled> pts</div>
<!--                        <div>Tasks: <b data-toggle="tooltip" title="Complete / All"><i>1 / 7</i></b> | Work: <b data-toggle="tooltip" title="Spent / Remaining"><i>13h / 20h</i></b></div>-->
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
                <a href="{{ route('story.edit' , [$project->id, $story->id])  }}" class="btn btn-primary">{{ __('Edit story') }}</a> <a href="#" class="btn btn-outline-danger">{{ __('Delete story') }}</a>
            </div>
        </div>
    @endforeach

    @foreach($stories_wont_have as $story)
        @if($list = explode("\n", $story->tests)) @endif
        <div class="card mb-3">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div>
                        <h3>#{{ $story->id }} - {{ $story->title }}</h3>
                        <div>Priority: <b><i>{{ __('Won\'t have this time') }}</i></b> | Business value: <b><i>{{ $story->business_value }}</i></b></div>
                    </div>
                    <div>
                        <div>Sprint estimate <input type="text" class="form-control text-center estimate" disabled> pts</div>
                        <!-- <div>Tasks: <b data-toggle="tooltip" title="Complete / All"><i>1 / 7</i></b> | Work: <b data-toggle="tooltip" title="Spent / Remaining"><i>13h / 20h</i></b></div>-->
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
                <a href="{{ route('story.edit' , [$project->id, $story->id]) }}" class="btn btn-primary">{{ __('Edit story') }}</a> <a href="#" class="btn btn-outline-danger">{{ __('Delete story') }}</a>
            </div>
        </div>
    @endforeach

    @if(count($stories) === 0)
        <p>This project has no stories.</p>
    @endif
</div>
@endsection
