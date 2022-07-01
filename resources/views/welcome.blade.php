<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href='{{ asset('css/app.css') }}'>
        {{-- <script src="https://js.stripe.com/v3/"></script> --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Gepetto</title>


    </head>
    <body>
    <div id="app" class="layout">
        <div >
            <navbar-component></navbar-component>
        </div>
        <div>
            <router-view></router-view>
        </div>
        <div>
            <footer-component></footer-component>
        </div>

    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
