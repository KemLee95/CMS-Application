<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        @include('layout.head')
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        @yield('head_style')
    </head>
    <body class="antialiased">
        <div class="header-container">
            @include('layout.header')
        </div>
        <div class="content-container pt-4">
            @yield('content')
        </div>
        
        @include('layout.footer')
        @yield('foot_script')
    </body>
</html>
