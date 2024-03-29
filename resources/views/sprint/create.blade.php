@extends('layouts.app')

@if(isset($sprint))
    @section('title', __(' - Update Sprint'))
@else
    @section('title', __(' - New Sprint'))
@endif

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if(isset($sprint))
                        <div class="card-header d-flex justify-content-between align-items-baseline">
                            <div>{{ __('Update sprint') }}</div>
                            <a class="btn btn-link"
                               href="{{ route('sprint.index', $project->id) }}" {{ Popper::arrow()->position('bottom')->pop('Discard the form and return to the sprint view.') }}>{{ __('Go back') }}</a>
                        </div>
                    @else
                        <div class="card-header d-flex justify-content-between align-items-baseline">
                            <div>{{ __('Add sprint') }}</div>
                            <a class="btn btn-link"
                               href="{{ route('sprint.index', $project->id) }}" {{ Popper::arrow()->position('bottom')->pop('Discard the form and return to the sprint view.') }}>{{ __('Go back') }}</a>
                        </div>
                    @endif

                    <div class="card-body">
                        <form method="POST" @if(isset($sprint))
                        action="{{ route('sprint.update', [$id, $sprint->id]) }}"
                              @else
                              action="{{ route('sprint.store', $id) }}"
                            @endif>

                            @if(isset($sprint))
                                @method("PUT")
                            @endif
                            @csrf

                            <div class="form-group row">
                                <label for="speed"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Speed') }} <i
                                        class="far fa-question-circle" {{ Popper::arrow()->pop('The sprint speed.') }}></i></label>

                                <div class="col-md-6">
                                    @if(isset($sprint))
                                        <input id="speed" type="number"
                                               class="form-control @error('speed') is-invalid @enderror"
                                               name="speed" value="{{ old('speed') ?? $sprint->speed }}"
                                               required autofocus min="1">
                                    @else
                                        <input id="speed" type="number"
                                               class="form-control @error('speed') is-invalid @enderror"
                                               name="speed" value="{{ old('speed') }}" required autofocus
                                               min="1">
                                    @endif

                                    @error('speed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                                <div class="form-group row">
                                    <label for="start_date"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Start date') }}
                                        <i class="far fa-question-circle" {{ Popper::arrow()->pop('The sprint start date.') }}></i></label>

                                    <div class="col-md-6">
                                        @if(isset($sprint))
                                            <input id="start_date" type="text" @if($sprint->in_progress) disabled
                                                   @endcan
                                                   class="form-control @error('in_progress') is-invalid @enderror @error('start_date') is-invalid @enderror @error('overlaps') is-invalid @enderror"
                                                   name="start_date"
                                                   value="{{ old('start_date') ?? $sprint->start_date }}"
                                                   required>
                                        @else
                                            <input id="start_date" type="text"
                                                   class="form-control @error('in_progress') is-invalid @enderror @error('start_date') is-invalid @enderror @error('overlaps') is-invalid @enderror"
                                                   name="start_date" value="{{ old('start_date') }}" required>
                                        @endif

                                        @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="end_date"
                                           class="col-md-4 col-form-label text-md-right">{{ __('End date') }} <i
                                            class="far fa-question-circle" {{ Popper::arrow()->pop('The sprint end date.') }}></i></label>

                                    <div class="col-md-6">
                                        @if(isset($sprint))
                                            <input id="end_date" type="text" @if($sprint->in_progress) disabled @endcan
                                            class="form-control @error('in_progress') is-invalid @enderror @error('end_date') is-invalid @enderror @error('overlaps') is-invalid @enderror"
                                                   name="end_date"
                                                   value="{{ old('end_date') ?? $sprint->end_date }}" required>
                                        @else
                                            <input id="end_date" type="text"
                                                   class="form-control @error('in_progress') is-invalid @enderror @error('end_date') is-invalid @enderror @error('overlaps') is-invalid @enderror"
                                                   name="end_date" value="{{ old('end_date') }}" required>
                                        @endif

                                        @error('end_date')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                        @error('in_progress')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    @error('overlaps')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        @if(isset($sprint))
                                            {{ __('Update sprint') }}
                                        @else
                                            {{ __('Add sprint') }}
                                        @endif
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

@section('page_specific_scripts')
    <script type="text/javascript">
        const formatting = {
            startDay: 1, formatter: (input, date, instance) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                input.value = `${year}-${month}-${day}`;
            }
        }

        window.onload = function () {
            window.datepicker('#start_date', formatting);
            window.datepicker('#end_date', formatting);
        };
    </script>
@endsection
