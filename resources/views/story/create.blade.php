@extends('layouts.app')

@section('title', __(' - New Story'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add story') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('story.store', $id) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" rows="5" required>{{ old('description') }}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tests" class="col-md-4 col-form-label text-md-right">{{ __('Acceptance tests') }}</label>

                            <div class="col-md-6">
                                <textarea id="tests" type="text" class="form-control @error('tests') is-invalid @enderror" name="tests" rows="5" required>{{ old('tests') }}</textarea>

                                @error('tests')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="priority" class="col-md-4 col-form-label text-md-right">{{ __('Priority') }}</label>

                            <div class="col-md-6">
                                <select id="priority" class="form-control @error('title') is-invalid @enderror" name="priority">
                                    <option value="1">{{__('1 - Must have')}}</option>
                                    <option value="2">{{__('2 - Should have')}}</option>
                                    <option value="3">{{__('3 - Could have')}}</option>
                                    <option value="4">{{__('4 - Won\'t have this time')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="business_value" class="col-md-4 col-form-label text-md-right">{{ __('Business value') }}</label>

                            <div class="col-md-6">
                                <input id="business_value" type="number" class="form-control @error('business_value') is-invalid @enderror" name="business_value" value="{{ old('business_value') }}" min="0" required>

                                @error('business_value')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add story') }}
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
