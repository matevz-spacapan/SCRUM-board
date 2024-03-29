@extends('layouts.app')

@section('title', __(' - Admin Page'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-baseline">
                    <div>{{ __('Admin Page') }}</div>
                    <div><a class="btn btn-link" href="{{ route('home') }}" {{ Popper::arrow()->position('bottom')->pop('Go back to home page.') }}>{{ __('Go back') }}</a></div>
                </div>
                <div class="card-body">
                    <a href="{{ route('users.index') }}" class="btn btn-success">{{ __('Manage Users') }}</a>
                </div>
				<div class="card-body">
                    <a href="{{ route('project.index') }}" class="btn btn-success">{{ __('Manage Projects') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
