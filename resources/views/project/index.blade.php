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
                    @can("create", \App\Models\Project::class)
                        <a class="btn btn-success mb-2" href="{{ route('project.create') }}"><i class="fas fa-plus"></i> {{ __('Create New Project') }}</a>
                    @endcan


                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Project name</th>
                            <th>Product owner</th>
                            <th>Scrum master</th>
							<th>Team size <i class="far fa-question-circle" {{ Popper::arrow()->pop('This includes only developers.') }}></i></th>
                            <th>Actions</th>
                        </tr>
                        @foreach ($data as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td>
                                @can("view", [\App\Models\Project::class, $project])
                                    <a href="{{ route('project.show', $project->id) }}" style="text-decoration: underline;">{{ $project->project_name }}</a>
                                @else
                                    {{ $project->project_name }}
                                @endcan
                            </td>
                            <td>{{ \App\Models\User::withTrashed()->where(['id' => $project->product_owner])->pluck('username')->first() }}</td>
                            <td>{{ \App\Models\User::withTrashed()->where(['id' => $project->project_master])->pluck('username')->first() }}</td>
                            <td>{{ count($project->users) }}</td>
                            <td>
                                @if($project->project_master === auth()->user()->id || auth()->user()->isAdmin()) <!-- Only Scrum master & admin can edit project -->
                                    <a href="{{ route('project.edit', $project->id) }}" class="btn btn-primary mb-2">{{ __('Edit project') }}</a>
                                @endif
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
