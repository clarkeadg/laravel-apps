<div class="hidden sm:flex justify-between bg-gray-800 xmax-w-7xl mx-auto px-4 py-2 sm:px-6 lg:px-8">
    <!-- Navigation Links Left -->
    <div class="flex items-center gap-8">
        <x-nav-link href="{{ route($app.'.home') }}" :active="request()->routeIs($app.'.home')" class="uppercase text-white hover:text-white focus:text-white">
            <x-heroicon-o-home class="h-6 w-6 text-white"/>
        </x-nav-link>
        <x-nav-link href="{{ route($app.'.categories') }}" :active="request()->routeIs($app.'.categories')" class="uppercase text-white hover:text-white focus:text-white">
            {{ __('Categories') }}
        </x-nav-link>
        <x-nav-link href="{{ route($app.'.artists') }}" :active="request()->routeIs($app.'.artists')" class="uppercase text-white hover:text-white focus:text-white">
            {{ __('Artists') }}
        </x-nav-link>
    </div>
    <!-- Navigation Links Right -->
    @auth
        <div class="flex items-center justify-end gap-8">
            <x-nav-link href="{{ route($app.'.lists') }}" :active="request()->routeIs($app.'.lists')" class="uppercase text-white hover:text-white focus:text-white">
                Playlists
            </x-nav-link>
            <x-nav-link href="{{ route($app.'.favorite_videos') }}" :active="request()->routeIs($app.'.favorite_videos')" class="uppercase text-white hover:text-white focus:text-white">
                Favorites
            </x-nav-link>
        </div>
    @endauth
</div>