<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Styles -->
        <link href="css/app.css" rel="stylesheet">

        <!-- Scripts -->
        <script src="js/app.js" defer=""></script>
    </head>
    <body class="antialiased">

        <div class="relative flex items-top justify-center min-h-screen sm:items-center sm:pt-0">

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

                <div class="text-center">
                    <h1 style="font-size:5rem;">Scrum Software</h1>
                    <h2>SMRPO 3</h2>
                </div>

                @if (Route::has('login'))
                    <div class="hidden text-center px-6 py-4 sm:block">
                        @auth
                            <a href="{{ route('project.index') }}" class="text-lg btn btn-primary">Home</a>
                        @else
                            <a href="{{ route('login') }}" class="text-lg btn btn-primary">Log in</a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>
