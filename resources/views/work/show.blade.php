@extends('layouts.app')

@section('title', __(' - Project tasks'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-baseline">
                        <div>{{ __('Project tasks') }}</div>
                        <div><a class="btn btn-link"
                                href="{{ route('task.task_view', $project->id) }}" {{ Popper::arrow()->position('right')->pop('Return to the task view') }}>{{ __('Go back') }}</a>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
