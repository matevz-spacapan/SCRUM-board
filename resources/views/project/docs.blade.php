@extends('layouts.app')

@section('title', __(' - Documentation'))

@section('content')
    <div class="container">
        <div class="d-flex flex-row mr-2 mt-2 justify-content-between">
            <h4 class="documentation-header">{{ __('Documentation') }}</h4>
            <a href="{{ route('project.edit_docs_view', $project->id) }}"
               class="btn btn-primary mb-2" {{ Popper::arrow()->position('right')->pop("Edit documentation") }}>Edit
                documentation</a>
        </div>
        <div class="card p-6">
            @markdown($project->documentation)
        </div>
    </div>
@endsection
