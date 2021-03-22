@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                {{ __('Project management') }}
                </div>
                <div class="card-body">
                    <a class="btn btn-success mb-2" href="{{ route('project.create') }}">{{ __('Create New Project') }}</a>
                    
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif
                    
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Project name</th>
                            <th>Project owner</th>
                            <th>Scrum master</th>
							<th>Team size</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($data as $key => $project)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $project->project_name }}</td>
                            <td>{{ $project->project_owner }}</td>
                            <td>{{ $project->scrum_master }}</td>
                            <td>{{ $project->team_size }}</td>
                            <td>
                                {{--<!--<a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>-->--}}
                                <a class="btn btn-primary" href="{{ route('project.edit', $project->id) }}">Edit</a>
                                {!! Form::open(['method' => 'DELETE','route' => ['project.destroy', $project->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    {!! $data->render() !!}
</div>
@endsection