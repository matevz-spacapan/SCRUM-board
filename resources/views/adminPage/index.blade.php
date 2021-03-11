@extends('layouts.app')

@section('title', __(' - Admin Page'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                {{ __('Admin Page') }}
                </div>
                <div class="card-body">
                    <a href="{{ route('users.index') }}" class="btn btn-success">{{ __('Manage Users') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
