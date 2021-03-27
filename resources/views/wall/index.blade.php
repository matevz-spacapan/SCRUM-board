@extends('layouts.app')

@section('title', __(' - Project wall'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        {{ __('Project wall') }}
                    </div>
                    <div class="card-body">
                        <a class="btn btn-outline-primary mb-3" href="{{ route('wall.create', $project->id) }}"><i class="fas fa-plus"></i> {{ __('Add new post') }}</a>
                        @foreach ($data as $post)
                            <blockquote class="blockquote">
                                <p>{!! nl2br($post->post) !!}</p>
                                <footer class="blockquote-footer">{{ $post->created_at }} <cite title="Source Title">{{ $post->user->name.' '.$post->user->surname }}</cite></footer>
                            </blockquote>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center">
                            {{ $data->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
