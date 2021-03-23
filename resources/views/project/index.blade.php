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
                    <a class="btn btn-success mb-2" href="{{ route('project.create') }}"><i class="fas fa-plus"></i> {{ __('Create New Project') }}</a>

                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Project name</th>
                            <th>Project owner</th>
                            <th>Scrum master</th>
							<th>Team size <i class="far fa-question-circle" {{ Popper::arrow()->pop('This includes only developers.') }}></i></th>
                            <th>Actions</th>
                        </tr>
                        @foreach ($data as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td><a href="{{ route('project.show', $project->id) }}" style="text-decoration: underline;">{{ $project->project_name }}</a></td>
                            <td>{{ \App\Models\User::where(['id' => $project->product_owner])->pluck('username')->first() }}</td>
                            <td>{{ \App\Models\User::where(['id' => $project->project_master])->pluck('username')->first() }}</td>
                            <td>{{ count($project->users) }}</td>
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
                    <div class="d-flex justify-content-center">
                        {{ $data->onEachSide(5)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
