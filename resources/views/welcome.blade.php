<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Canban - Ekipa SMRPO 3</title>

        
        <!-- Styles -->
        <link href="css/app.css" rel="stylesheet">
        
        <!-- Scripts -->
        <script src="js/app.js" defer=""></script>
    </head>
    <body class="antialiased">
        
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                
                <div>
                    <h1 id="naslovVhodnaStran" class="text-center text-white">Canban Software</h1>
                    <h2 class="text-center text-white">SMRPO 3<h2>
                </div>
                
                @if (Route::has('login'))
                    <div class="hidden text-center px-6 py-4 sm:block">
                        @auth
                            <a href="{{ url('/home') }}" class="text-lg text-white underline btn btn-primary">Home</a>
                        @else
                            <a href="{{ route('login') }}" class="text-lg text-white underline btn btn-primary">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-lg text-white underline btn btn-primary">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>
