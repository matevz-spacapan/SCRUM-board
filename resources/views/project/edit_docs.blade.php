@extends('layouts.app')

@section('title', __(' - Edit Documentation'))

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('project.edit_docs', $project->id) }}">
            @csrf
            <div class="d-flex flex-column justify-content-center">
                <label for="documentation" class="mr-auto ml-auto">{{ __('Documentation') }}</label>
                <textarea id="documentation" type="text" class="form-control documentation-textarea"
                          name="documentation" autofocus>
                    {{$project->documentation}}
                </textarea>

                <div class="d-flex mt-2 justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Edit documentation') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
