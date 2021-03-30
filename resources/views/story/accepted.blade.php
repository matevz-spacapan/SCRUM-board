@extends('layouts.app')

@section('title', ' - '.$project->project_name)

@section('content')
    <div class="container">
        <h3>{{ __('Finished stories') }}</h3>
        @include('story.loop', ['stories_list' => $stories, 'taskView'=>"0", 'active_sprint' => null])
    </div>
@endsection
