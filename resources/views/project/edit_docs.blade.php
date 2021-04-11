@extends('layouts.app')

@section('title', __(' - Edit Documentation'))

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('project.edit_docs', $project->id) }}">
            @csrf
            <div class="d-flex flex-column justify-content-center">
                <div class="d-flex flex-row m-auto">
                    <label for="documentation" class="m-0 text-center mr-4">{{ __('Documentation') }}</label>
                    <a class="btn btn-link p-0"
                       href="{{ route('project.docs', [$project->id]) }}" {{ Popper::arrow()->position('right')->pop('Discard the form and return to the documentation.') }}>{{ __('Go back') }}</a>
                </div>
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
