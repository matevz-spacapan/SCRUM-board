@extends('layouts.app')

@section('title', __(' - Edit Project'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-baseline">
                    <div>{{ __('Update project') }}
                    </div>
                    <div><a class="btn btn-link" href="{{ route('project.index') }}" {{ Popper::arrow()->position('bottom')->pop('Discard the form and return to the project list.') }}>{{ __('Go back') }}</a></div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('project.update', $project->id) }}">
                        @csrf
                        <div class="form-group row">
                            <label for="project_name" class="col-md-4 col-form-label text-md-right">{{ __('Project name') }} <i class="far fa-question-circle" {{ Popper::arrow()->pop('Enter a name for this project.') }}></i></label>

                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="project_name" type="text" class="form-control @error('project_name') is-invalid @enderror" name="project_name" value="{{ $project->project_name }}" required autofocus>

                                    @error('project_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s2n1" class="col-md-4 col-form-label text-md-right">{{ __('Product owner') }} <i class="far fa-question-circle" {{ Popper::arrow()->pop('Select the product owner.') }}></i></label>

                            <div class="col-md-6 mt-2">
                                <div class="input-group">
                                    <select id="s2n1" class="s2 form-control @error('product_owner') is-invalid @enderror" name="product_owner">
                                        <option disabled {{ is_null($project->product_owner) ? 'selected':'' }}>-- Select user --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $project->product_owner == $user->id ? 'selected':'' }}>{{ $user->username }}</option>
                                        @endforeach
                                    </select>

                                    @error('product_owner')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="s2n2" class="col-md-4 col-form-label text-md-right">{{ __('Scrum master') }} <i class="far fa-question-circle" {{ Popper::arrow()->pop('Select the scrum master.') }}></i></label>

                            <div class="col-md-6 mt-2">
                                <div class="input-group">
                                    <select id="s2n2" class="s2 form-control @error('project_master') is-invalid @enderror" name="project_master">
                                        <option disabled {{ is_null($project->project_master) ? 'selected':'' }}>-- Select user --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $project->project_master == $user->id ? 'selected':'' }}>{{ $user->username }}</option>
                                        @endforeach
                                    </select>

                                    @error('project_master')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="w-100">

                        <div class="form-group row">
                            <label for="s2n3" class="col-md-4 col-form-label text-md-right">{{ __('Select developers') }} <i class="far fa-question-circle" {{ Popper::arrow()->pop('Select developers for this project.') }}></i></label>
                            <div class="col-md-6 mt-2">
                                <div class="input-group">
                                    <select id="s2n3" class="s2 form-control @error('developers') is-invalid @enderror" name="developers[]" multiple>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                @foreach($developers as $dev) {{ $dev->id == $user->id ? 'selected':'' }} @endforeach
                                            >{{ $user->username }}</option>
                                        @endforeach
                                    </select>
                                    @error('developers')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update project') }}
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

