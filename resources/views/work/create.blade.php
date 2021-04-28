@extends('layouts.app')

@section('title', __(' - New Work log'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-baseline">
                        <div>{{ __('Update sprint') }}</div>
                        <a class="btn btn-link"
                           href="{{ route('task.work', [$project->id, $task->id]) }}" {{ Popper::arrow()->position('right')->pop('Discard the form and return to the work view.') }}>{{ __('Go back') }}</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('work.store', [$project->id, $task->id]) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="day" class="col-md-4 col-form-label text-md-right">{{ __('Work day') }}
                                    <i class="far fa-question-circle"></i></label>

                                <div class="col-md-6">
                                    <input id="day" type="text" class="form-control @error('day') is-invalid @enderror"
                                           name="day" required autocomplete="off">

                                    @error('day')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amount_min"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Amount worked in minutes.') }}</label>

                                <div class="col-md-6">
                                    <input id="amount_min" type="number"
                                           class="form-control @error('amount_min') is-invalid @enderror"
                                           name="amount_min" required min="1" max="720">

                                    @error('amount_min')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add new work log') }}
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
            window.datepicker('#day', formatting);
        };
    </script>
@endsection
