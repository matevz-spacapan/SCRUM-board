@extends('layouts.app')

@section('title', __(' - User Settings'))

@section('content')
<div class="container">
    <h1>User Settings</h1>
    <div class="row">
        <div class="col">
            <div class="card">
                {{ Auth::user() }} 
                
            </div>
        </div>
    </div>
</div>
@endsection
