<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head> 
        <title>Twitter</title>
        <link rel="icon" type="image/x-icon" href="/images/twitter/favicon.ico">

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
    <body class="font-sans antialiased bg-gray-100">
        <x-banner />
        
        <div class="min-h-screen relative">
            <div class="fixed top-0 left-0 w-full z-10 pointer-events-none">
                <div class="pointer-events-auto">
                    @relativeInclude('nav._top')
                </div>
                <div class="flex justify-between w-full max-w-7xl mx-auto pointer-events-none">
                    <div class="w-1/4 px-4 hidden md:block pointer-events-auto">   
                        @relativeInclude('nav._side')
                        @relativeInclude('nav._compose-button')
                    </div>
                    <div class="w-1/4 px-4 hidden md:block pointer-events-auto">
                        @relativeInclude('nav._right')                       
                    </div>
                </div>
            </div> 
            <main class="flex justify-center w-full max-w-7xl mx-auto pt-20 min-h-screen">
                <div class="w-full md:w-1/2 px-2 md:px-0">
                    @yield('content')
                </div>
            </main>            
        </div>        

        @stack('modals')               

        <!-- Scripts -->
        @livewire('wire-elements-modal') 
        @livewireScripts        
        @vite(['resources/js/app.js']) 
    </body>
</html>
