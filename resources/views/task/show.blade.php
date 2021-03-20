@extends('layouts.app')
@section('title', '- Tasks')
@section('content')
    <div class="container">

    @include('story.loop', ['stories_list' => $story_list, 'taskView'=>"1"])

        <div class="card mb-3" >
            <label>

            </label>
            <hr>
            Nekej
        </div>

        <div class="card mb-3">
        </div>


    </div>
@endsection
