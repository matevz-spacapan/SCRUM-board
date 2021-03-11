@extends('layouts.app')

@section('title', ' - '.$project->project_name)

@section('content')
<div class="container">
    <h1>{{$project->project_name}}</h1>

    @can("create", [\App\Models\Story::class, $project])
        <a href="{{ route('story.create', $id) }}" class="btn btn-success mb-3">Add new</a>
    @endcan
    <div class="row">
        @foreach($stories as $story)
            <div class="col">
                <div class="card" style="max-width:23rem;">
                    @switch($story->priority)
                        @case(1)
                        @php
                            $text = __('1 - Must have');
                            $color='bg-danger text-light';
                        @endphp
                        @break
                        @case(2)
                        @php
                            $text = __('2 - Should have');
                            $color='bg-warning';
                        @endphp
                        @break
                        @case(3)
                        @php
                            $text = __('3 - Could have');
                            $color='bg-info';
                        @endphp
                        @break
                        @default
                        @php
                            $text = __('4 - Won\'t have this time');
                            $color='bg-secondary text-light';
                        @endphp
                    @endswitch
                    <div class="card-header {{ $color }}">
                        <b>{{ $story->title }}</b> ({{ $text }})
                    </div>
                    <div class="card-body">
                        <div class="card-text mb-2">
                            <b>Description: </b>{{$story->description }}<br><br>
                            <b>Acceptance tests: </b><br>
                            {!! nl2br($story->tests) !!}
                        </div>
                        <a href="#" class="btn btn-primary">{{__('Edit story')}}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
