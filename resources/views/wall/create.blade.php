@extends('layouts.app')

@section('title', __(' - New wall post'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-baseline">
                    <div>{{ __('Add wall post') }}</div>
                    <div><a class="btn btn-link" href="{{ route('wall.index', $project->id) }}" {{ Popper::arrow()->position('bottom')->pop('Discard the form and return to the wall.') }}>{{ __('Go back') }}</a></div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('wall.store', $project->id) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="post" class="col-md-4 col-form-label text-md-right">{{ __('Your post') }} <i class="far fa-question-circle" {{ Popper::arrow()->pop('Enter the text that will represent your post to the wall.') }}></i></label>

                            <div class="col-md-6">
                                <textarea id="post" class="form-control @error('post') is-invalid @enderror" name="post" rows="5" required>{{ old('post') }}</textarea>

                                @error('post')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add post') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
