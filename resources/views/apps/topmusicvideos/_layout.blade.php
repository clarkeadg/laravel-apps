<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head> 
        <title>Top Music Videos</title>
        <link rel="icon" type="image/x-icon" href="/images/topmusicvideos/favicon.ico">

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
    <body class="font-sans antialiased topmusicvideos">
        <x-banner />

        <div x-data="{ open: false }" class="min-h-screen bg-gray-100 relative">
            <div :class="{'fixed': open, 'sticky': !open}" class="sticky top-0 left-0 w-full z-10">
                <nav class="border-b border-gray-600">
                    @relativeInclude('nav._top')
                    @relativeInclude('nav._primary')                    
                </nav>
            </div>

            <!-- Page Heading -->
            @hasSection('header')
                <header class="bg-white shadow px-3">
                    <div class="xmax-w-7xl mx-auto py-6 px-3 sm:px-3 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main :class="{'block': !open, 'hidden': open}" class="md:block">
                @yield('content')
            </main>

            <div :class="{'block': !open, 'hidden': open}" class="md:block">
                @include('footer')
            </div>
        </div>

        @stack('modals')

        <!-- Scripts -->
        @livewire('wire-elements-modal') 
        @livewireScripts        
        @vite(['resources/js/app.js']) 
    </body>
</html>
