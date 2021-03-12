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
    @if(count($sprints) === 0)
        <p>This project has no sprints.</p>
    @endif

    <h4 class="mt-5">{{ __('Project stories') }}</h4>
    @can("create", [\App\Models\Story::class, $project])
        <a href="{{ route('story.create', $project->id) }}" class="btn btn-success mb-3">Add new story</a>
    @endcan
    <div class="row row-cols-3">
        @foreach($stories as $story)
            <div class="col my-3">
                <div class="card h-100">
                    @switch($story->priority)
                        @case(1)
                        @php
                            $text = __('1 - Must have');
                            $color='priority-1 text-light';
                        @endphp
                        @break
                        @case(2)
                        @php
                            $text = __('2 - Should have');
                            $color='priority-2 text-light';
                        @endphp
                        @break
                        @case(3)
                        @php
                            $text = __('3 - Could have');
                            $color='priority-3';
                        @endphp
                        @break
                        @default
                        @php
                            $text = __('4 - Won\'t have this time');
                            $color='priority-4';
                        @endphp
                    @endswitch
                    <div class="card-header {{ $color }}">
                        <b>{{ $story->title }}</b> ({{ $text }})
                    </div>
                    <div class="card-body">
                        <div class="card-text mb-2">
                            <p><b>{{ __('Description') }}:</b> <br> {!! nl2br($story->description) !!}</p>
                            <b>{{ __('Acceptance tests') }}:</b><br> {!! nl2br($story->tests) !!}<br><br>
                            <p><b>{{ __('Business value') }}:</b> {{ $story->business_value }}</p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary">{{__('Edit story')}}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if(count($stories) === 0)
        <p>This project has no stories.</p>
    @endif
</div>
@endsection
