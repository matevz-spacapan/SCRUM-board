<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
	<script src="{{ asset('js/select2.min.js') }}" ></script>
    @yield('page_specific_scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

	<!-- select2 -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <div class="navbar-brand">
                    {{ config('app.name') }}
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <ul class="navbar-nav mr-auto">
                        @auth
                            <li class="nav-item"><a class="nav-link" href="{{ route('project.index') }}">{{ __('All projects') }}</a></li>

                            @can('users-list') {{--<!--IS ADMIN-->--}}
                                <li class="nav-item"> <a class="nav-link" href="/admin/dashboard">{{ __('Admin Dashboard') }}</a></li>
                            @endcan
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }}

                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                
                                    <a class="dropdown-item" href="/user/settings" > {{ __('User Settings') }} </a>
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                    <div class="dropdown-item disabled"> {{Auth::user()->getLastLogin()}}  </div>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @if(Request::segment(1) === 'project' && is_numeric(Request::segment(2)))
            @auth
                <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
                    <div class="container">
                        <div class="navbar-brand">
                            {{ $project->project_name }} |
                            <small>
                                @if($project->product_owner === auth()->user()->id)
                                    {{ __('Product owner') }}
                                @elseif($project->project_master === auth()->user()->id)
                                    {{ __('Scrum master') }}
                                @else
                                    {{ __('Developer') }}
                                @endif
                            </small>
                        </div>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <ul class="navbar-nav">
                                    <li class="nav-item dropdown">
                                        <a id="productBacklog" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ __('Product backlog') }}</a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="productBacklog">
                                            <a class="dropdown-item" href="{{ route('project.show', Request::segment(2)) }}">{{ __('Unfinished stories') }}</a>
                                            @if(count(\App\Models\Story::query()->where('project_id', Request::segment(2))->where('accepted', 1)->get()) > 0)
                                                <a class="dropdown-item"
                                                   href="{{ route('story.accepted', Request::segment(2)) }}">{{ __('Finished stories') }}</a>
                                            @else
                                                <div class="dropdown-item disabled">{{__('Finished stories')}}</div>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                                <li class="nav-item"><a href="{{ route('sprint.index', $project->id) }}"
                                                        class="nav-link">{{ __('Sprint list') }}</a></li>
                                <li class="nav-item"><a href="{{ route('wall.index', $project->id) }}"
                                                        class="nav-link">{{ __('Project wall') }}</a></li>
                                <li class="nav-item"><a href="{{ route('project.docs', $project->id) }}"
                                                        class="nav-link">{{ __('Project documentation') }}</a></li>
                                @if($project->project_master === auth()->user()->id || auth()->user()->isAdmin()) <!-- Only Scrum master & admin can edit project -->
                                <li class="nav-item"><a href="{{ route('project.edit', $project->id) }}"
                                                        class="nav-link">{{ __('Edit project') }}</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </nav>
            @endauth
        @endif
        <div id="footerDown">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
        <footer id="footer" class="bg-white">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col text-center">
                        Copyright © 2021<br/>
                        {{ __('Ekipa SMRPO 3') }}

                    </div>
                </div>
            </div>
        </footer>
    </div>
    @include('popper::assets')
  	<script src="{{ asset('js/project_select2.js') }}" defer></script>
</body>
</html>
