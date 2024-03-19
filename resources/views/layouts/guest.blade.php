<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">         

        <!-- Styles -->
        <link href="/slick/slick.css" rel="stylesheet" type="text/css"/>
        <link href="/slick/slick-theme.css" rel="stylesheet" type="text/css"/>     
        @livewireStyles
        @vite(['resources/css/app.css'])  

        <!-- Fonts -->
        <link href="https://fonts.bunny.net" rel="preconnect">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="/js/jquery/jquery-3.7.1.min.js" type="text/javascript"></script>
        <script src="/slick/slick.min.js" type="text/javascript"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-100 relative">
            <main class="min-h-screen flex flex-col bg-black">
                <div class="flex grow flex-col font-sans text-gray-900 antialiased">
                    {{ $slot }}
                </div>            
                @include('footer')
            </main>
        </div>

        @livewireScripts
    </body>
</html>
