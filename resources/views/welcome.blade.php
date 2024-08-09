<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.1/css/bulma.min.css">
    <!-- Styles -->
    <style>
        /* html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            tab-size: 4;
            font-family: Figtree, ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            font-feature-settings: normal;
            font-variation-settings: normal;
            -webkit-tap-highlight-color: transparent
        } */

        /* body {
            margin: 0;
            line-height: inherit
        } */
    </style>
</head>

<body>
    <div class="columns">
        <div class="column is-half" style="background-color: black;">
            <br>
            <h1 style="font-size: 35px; text-align:center; font-family: DM Serif Display; margin-top:10px">PRODAMI</h1>
            <h3 style="font-size: 29px; text-align:center; font-family: DM Serif Display;">Automatizaciones</h3>
            <br><br>
            <img src="images\LogoProdami-SinFondo-Niletras.png" width="370px" style="margin-left:130px">
            <br><br><br>
        </div>
        <div class="column" style="background-color: white;">
            <h1 style="font-size: 35px; text-align:center; font-family: DM Serif Display; margin-top:200px; color:black">¡Bienvenido!</h1>
            @if (Route::has('login'))
            <nav >
                @auth
                <a href="{{ url('/dashboard') }}" class="">
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary " style="font-family: DM Serif Display; color: black; margin-top: 40px; margin-left: 270px">
                    Iniciar Sesión
                </a>

                <!-- @if (Route::has('register'))
                <a href="{{ route('register') }}" class="color: black;">
                    Register
                </a>
                @endif -->
                @endauth
            </nav>
            @endif
        </div>
    </div>
    <footer style="background-color: black; margin-top: -12px">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </footer>

</body>

</html>