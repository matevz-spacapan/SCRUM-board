@extends('layouts.app')

@section('title', __(' - Documentation'))

@section('content')
    <div class="container card p-6">
        @markdown($project->documentation)
    </div>
@endsection
