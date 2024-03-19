<nav class="nav-side flex flex-col py-2">
    <x-nav-link href="{{ route($app.'.home') }}" :active="request()->routeIs($app.'.home')" class="py-4 px-2 flex grow items-center font-medium text-gray-500 hover:text-black focus:text-black">
        <x-heroicon-o-home class="h-6 w-6"/>
        <span class="ml-4">{{ __('Home') }}</span>
    </x-nav-link>
    <x-nav-link href="{{ route($app.'.search') }}" :active="request()->routeIs($app.'.search')" class="py-4 px-2 flex grow items-center font-medium text-gray-500 hover:text-black focus:text-black">
        <x-heroicon-o-magnifying-glass class="h-6 w-6"/>
        <span class="ml-4">{{ __('Search') }}</span>
    </x-nav-link>
    @auth
        <x-nav-link href="{{ route($app.'.notifications') }}" :active="request()->routeIs($app.'.notifications')" class="py-4 px-2 flex grow items-center font-medium text-gray-500 hover:text-black focus:text-black">
            <div class="flex items-center">
                <x-heroicon-o-bell class="h-6 w-6"/>
                <div class="relative -top-3 left-0">
                    @livewire('notifications.notifications-count')
                </div>            
            </div>
            <span class="ml-4">{{ __('Notifications') }}</span>                
        </x-nav-link>
        <x-nav-link href="{{ route($app.'.messages') }}" :active="request()->routeIs($app.'.messages')" class="py-4 px-2 flex grow items-center font-medium text-gray-500 hover:text-black focus:text-black">
            <div class="flex items-center">
                <x-heroicon-o-envelope class="h-6 w-6"/>
                <div class="relative -top-3 left-0">
                    @livewire('messenger.messages-count')
                </div>            
            </div>
            <span class="ml-4">{{ __('Messages') }}</span>
        </x-nav-link>
        <x-nav-link href="{{ route($app.'.members.show', Auth::user()->name) }}" :active="request()->routeIs($app.'.members.show')" class="py-4 px-2 flex grow items-center font-medium text-gray-500 hover:text-black focus:text-black">
            <x-heroicon-o-user class="h-6 w-6"/>
            <span class="ml-4">{{ __('Profile') }}</span>
        </x-nav-link>
        <x-nav-link href="{{ route($app.'.settings') }}" :active="request()->routeIs($app.'.settings')" class="py-4 px-2 flex grow items-center font-medium text-gray-500 hover:text-black focus:text-black">
            <x-heroicon-o-cog-6-tooth class="h-6 w-6"/>
            <span class="ml-4">{{ __('Settings') }}</span>
        </x-nav-link> 
        <x-dropdown align="left" width="48">
            <x-slot name="trigger">                                
                <button class="py-4 px-2 flex grow w-full items-center font-medium text-gray-500 hover:text-black focus:text-black">
                    <x-heroicon-o-ellipsis-horizontal-circle class="h-6 w-6"/>
                    <span class="ml-4">{{ __('More') }}</span>
                </button>                                
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link href="{{ route($app.'.bookmarks') }}" class="flex items-center hover:text-black focus:text-black">
                    <x-heroicon-o-bookmark class="h-6 w-6"/>
                    <span class="ml-4">{{ __('Bookmarks') }}</span>
                </x-dropdown-link>
                <x-dropdown-link href="{{ route($app.'.lists') }}" class="flex items-center hover:text-black focus:text-black">
                    <x-heroicon-o-list-bullet class="h-6 w-6"/>
                    <span class="ml-4">{{ __('Lists') }}</span>
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
    @endauth
</nav>
