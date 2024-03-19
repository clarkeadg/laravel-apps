<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head> 
        <title>Boosh</title>
        <link rel="icon" type="image/x-icon" href="/images/boosh/favicon.ico">

        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">         

        <!-- Styles -->
        <link href="/slick/slick.css" rel="stylesheet" type="text/css"/>
        <link href="/slick/slick-theme.css" rel="stylesheet" type="text/css"/>
        <link href="/css/filament/forms/forms.css?v=3.2.7.0" rel="stylesheet" type="text/css"/>    
        @livewireStyles
        @vite(['resources/css/app.css'])  
        
        <!-- Fonts -->
        <link href="https://fonts.bunny.net" rel="preconnect">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="/js/jquery/jquery-3.7.1.min.js" type="text/javascript"></script>
        <script src="/slick/slick.min.js" type="text/javascript"></script>
        <script src="/js/filament/support/async-alpine.js?v=3.2.7.0" type="text/javascript"></script>
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 relative">
            
            <!-- Nav -->
            <nav class="border-b border-gray-600">
                <div class="bg-black xmax-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">   
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('boosh.home') }}">
                                    <img src="/images/boosh/logo.jpg" alt="{{ config('app.name') }}" class="h-12 w-auto"/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow px-3">
                    <div class="xmax-w-7xl mx-auto py-6 px-3 sm:px-3 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>

            @include('footer')
        </div>

        @stack('modals')

        <!-- Scripts -->
        @livewireScripts        
        @vite(['resources/js/app.js']) 
    </body>
</html>
