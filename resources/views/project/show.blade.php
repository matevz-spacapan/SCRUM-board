@extends('layouts.app')

@section('title', ' - '.$project->project_name)

@section('content')
<div class="container">
    <h1>{{$project->project_name}}</h1>

    @can("create", [\App\Models\Story::class, $project])
        <a href="{{ route('story.create', $project->id) }}" class="btn btn-success mb-3">Add new</a>
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
                            <p><b>Description:</b> <br> {!! nl2br($story->description) !!}</p>
                            <b>Acceptance tests:</b><br> {!! nl2br($story->tests) !!}
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary">{{__('Edit story')}}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
