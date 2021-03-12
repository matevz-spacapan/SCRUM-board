@extends('layouts.app')

@section('title', __(' - New Sprint'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Add sprint') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('sprint.store', $id) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="speed" class="col-md-4 col-form-label text-md-right">{{ __('Speed') }}</label>

                                <div class="col-md-6">
                                    <input id="speed" type="number" class="form-control @error('speed') is-invalid @enderror"
                                           name="speed" value="{{ old('speed') }}" required autofocus min="1">

                                    @error('speed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="start_date" class="col-md-4 col-form-label text-md-right">{{ __('Start date') }}</label>

                                <div class="col-md-6">
                                    <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date"
                                           value="{{ old('start_date') }}" required autofocus>

                                    @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="end_date" class="col-md-4 col-form-label text-md-right">{{ __('End date') }}</label>

                                <div class="col-md-6">
                                    <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date"
                                           value="{{ old('end_date') }}" required autofocus>

                                    @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add sprint') }}
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
