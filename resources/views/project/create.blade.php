@extends('layouts.app')

@section('title', __(' - New Project'))

@section('content')

<h1>Create new Project</h1>

<form method="post" action="{{ route('project.store')}}">

	@csrf
	
	<div class="form-group">
		<label>Project name</label>
		<input type="text" class="form-control" name="project_name" id="project_name">
		
	</div>

	<div class="from-controll" name=""
	
	
	<input type="submit" name="create" value="Create project" class="btn btn-primary">
</form>
    
@endsection