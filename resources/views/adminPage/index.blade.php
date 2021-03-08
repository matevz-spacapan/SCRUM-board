@extends('layouts.app')

@section('title', __(' - Admin Page'))

@section('content')
<div class="container">
    <h1>Admin Page</h1>
    <div class="row">
        <div class="col">
            <div class="card">
                
                <a href="{{ route('users.index') }}" class="btn btn-success">Manage Users</a>
                <a href="{{ route('roles.index') }}" class="btn btn-success">Manage Role</a>
                
            </div>
        </div>
    </div>
</div>
@endsection
