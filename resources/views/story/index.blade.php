@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Stories</h1>
    <a href="/story/create">Add new</a>
    <div class="row">
        @foreach($stories as $story)
            <div class="col">
                <div class="card">
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
                        <p class="card-text">
                            {{ __('Description') . ': ' . $story->description }}<br>
                            {{ __('Acceptance tests') . ': ' . $story->tests }}
                        </p>
                        <a href="#" class="btn btn-primary">{{__('Edit story')}}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
