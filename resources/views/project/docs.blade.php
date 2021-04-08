@extends('layouts.app')

@section('title', __(' - Documentation'))

@section('content')
    @markdown($project->documentation)
@endsection
