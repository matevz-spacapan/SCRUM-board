@extends('layouts.app')

@section('title', __(' - Documentation'))

@section('content')
    <div class="container">
        <div class="d-flex flex-row mr-2 mt-2">
            <h4 class="documentation-header mr-auto">{{ __('Documentation') }}</h4>
            <a href="{{ route('project.edit_docs_view', $project->id) }}"
               class="btn btn-primary mb-2 mr-1" {{ Popper::arrow()->position('left')->pop("Edit documentation") }}>Edit
                documentation</a>
            <a href="{{ route('project.download_docs', $project->id) }}"
               class="btn btn-primary mb-2" {{ Popper::arrow()->position('right')->pop("Download documentation") }}>Download
                documentation</a>
        </div>
        <div class="card p-6">
            @markdown($project->documentation)
        </div>
    </div>
@endsection
