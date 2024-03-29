@extends('layouts.app')

@section('title', __(' - Edit Task'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-baseline">
                    <div>{{ __('Edit task') }}</div>
                    <div><a class="btn btn-link" href="{{ route('task.show', [$project->id, $story->id]) }}" {{ Popper::arrow()->position('bottom')->pop('Discard the form and return to the story.') }}>{{ __('Go back') }}</a></div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('task.update', [$project->id, $story->id, $task->id]) }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }} <i class="far fa-question-circle" {{ Popper::arrow()->pop('Enter a description for this task.') }}></i></label>

                            <div class="col-md-6">
                                <textarea id="description" placeholder="Task description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" rows="5" required>{{ old('description') ?? $task->description }}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="time_estimate"
                                   class="col-md-4 col-form-label text-md-right">{{ __('Time estimate') }} <i
                                    class="far fa-question-circle" {{ Popper::arrow()->pop('Enter a time estimate value betwen 1 and 100.') }}></i></label>

                            <div class="col-md-6">
                                <input id="time_estimate" placeholder="[h]" type="number"
                                       class="form-control @error('time_estimate') is-invalid @enderror"
                                       name="time_estimate"
                                       value="{{ old('time_estimate') ?? $task->most_recent_time_estimate_min() / 60}}"
                                       min="1" max="100" required>

                                @error('time_estimate')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user" class="col-md-4 col-form-label text-md-right">{{ __('Assigned User') }} <i class="far fa-question-circle" {{ Popper::arrow()->pop('Select the assigned user for this task.') }}></i></label>

                            <div class="col-md-6">
                                <select id="user_id" class="form-control @error('user_id') is-invalid @enderror" name="user_id" {{($task->accepted) != 1 ? '' : 'disabled' }}>
                                    <option value="0">{{__('Not assigned')}}</option>

                                    @foreach($user_list as $user)
                                        <option value="{{$user->id}}" {{($task->user_id) == $user->id ? 'selected' : '' }}>{{$user->username}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
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
