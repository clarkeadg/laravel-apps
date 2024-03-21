<div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white min-h-screen">         
    @auth 
        <div class="py-4 border-t border-gray-200">
            <div class="flex items-center px-4">                    
                <div class="shrink-0 mr-3">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->avatar_thumb }}" alt="{{ Auth::user()->name }}" />
                </div>                    

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ "@".(Auth::user()->name) }}</div>
                </div>                
            </div>
            <div class="px-4 pt-2 flex gap-4 items-center">
                <a href="{{ route($app.'.members.followers', Auth::user()->name) }}" class="text-gray-500 hover:text-black hover:underline font-medium">
                    {{ number_format(Auth::user()->followers_count) }} Followers
                </a>
                <a href="{{ route($app.'.members.following', Auth::user()->name) }}" class="text-gray-500 hover:text-black hover:underline font-medium">
                    {{ number_format(Auth::user()->following_count) }} Following
                </a>
            </div>
        </div>
    @else
        <div class="pt-2 pb-3 space-y-1 border-t border-gray-200">
            <x-responsive-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                {{ __('Login') }}
            </x-responsive-nav-link>
            @if (Route::has('register'))
                <x-responsive-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                    {{ __('Signup') }}
                </x-responsive-nav-link>
            @endif
        </div>
    @endauth

    @auth   
        <div class="pt-2 pb-3 space-y-1 border-t border-gray-200">
            <x-responsive-nav-link href="{{ route($app.'.members.show', Auth::user()->name) }}" :active="request()->routeIs($app.'.members.show')" class="flex w-full">
                <x-heroicon-o-user class="h-6 w-6"/>
                <span class="ml-2">{{ __('Profile') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route($app.'.notifications') }}" :active="request()->routeIs($app.'.notifications')" class="flex w-full">                
                <div class="relative">
                    <x-heroicon-o-bell class="h-6 w-6"/>
                    <div class="absolute -top-0 -right-0">
                        @livewire('notifications.notifications-count')
                    </div>
                </div>
                <span class="ml-2">{{ __('Notifications') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route($app.'.messages') }}" :active="request()->routeIs($app.'.messages')" class="flex w-full">
                <div class="relative">
                    <x-heroicon-o-envelope class="h-6 w-6"/>
                    <div class="absolute -top-0 -right-0">
                        @livewire('messenger.messages-count')
                    </div>
                </div>
                <span class="ml-2">{{ __('Messages') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route($app.'.bookmarks') }}" :active="request()->routeIs($app.'.bookmarks')" class="flex w-full">
                <x-heroicon-o-bookmark class="h-6 w-6"/>
                <span class="ml-2">{{ __('Bookmarks') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route($app.'.lists') }}" :active="request()->routeIs($app.'.lists')" class="flex w-full">
                <x-heroicon-o-list-bullet class="h-6 w-6"/>
                <span class="ml-2">{{ __('Lists') }}</span>
            </x-responsive-nav-link>
        </div>          
        <div class="pt-2 pb-3 space-y-1 border-t border-gray-200">
            <x-responsive-nav-link href="{{ route($app.'.blocks') }}" :active="request()->routeIs($app.'.blocks')" class="flex w-full">
                <x-heroicon-o-no-symbol class="h-6 w-6"/>
                <span class="ml-2">{{ __('Blocks') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route($app.'.mutes') }}" :active="request()->routeIs($app.'.mutes')" class="flex w-full">
                <x-heroicon-o-speaker-x-mark class="h-6 w-6"/>
                <span class="ml-2">{{ __('Mutes') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route($app.'.settings') }}" :active="request()->routeIs($app.'.settings')" class="flex w-full">
                <x-heroicon-o-cog-6-tooth class="h-6 w-6"/>
                <span class="ml-2">{{ __('Settings') }}</span>
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="flex w-full">
                    <x-heroicon-o-arrow-left-on-rectangle class="h-6 w-6"/>
                    <span class="ml-2">{{ __('Logout') }}</span>
                </x-responsive-nav-link>
            </form>
        </div>
    @endauth
</div>