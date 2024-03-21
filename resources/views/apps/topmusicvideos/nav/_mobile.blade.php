<div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden bg-white min-h-screen">        
    <div class="overflow-y-auto">
        <!-- Search -->
        <div class="flex w-full justify-center py-2">
            @livewire('global-search', [
                'app' => $app,
                'categories' => [
                    'Videos' => [],
                    'Artists' => [],
                ]
            ])
        </div>

        @auth 
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">                    
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->avatar_thumb }}" alt="{{ Auth::user()->name }}" />
                    </div>                    

                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Account Management -->
                    <x-responsive-nav-link href="{{ route($app.'.members.show', Auth::user()->name) }}" :active="request()->routeIs($app.'.members.show')">
                        {{ __('My Profile') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route($app.'.settings.profile') }}" :active="request()->routeIs($app.'.settings.profile')">
                        {{ __('Settings') }}
                    </x-responsive-nav-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                            {{ __('API Tokens') }}
                        </x-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-responsive-nav-link href="{{ route('logout') }}"
                                    @click.prevent="$root.submit();">
                            {{ __('Logout') }}
                        </x-responsive-nav-link>
                    </form>

                    <!-- Team Management -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Team') }}
                        </div>

                        <!-- Team Settings -->
                        <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                            {{ __('Team Settings') }}
                        </x-responsive-nav-link>

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                {{ __('Create New Team') }}
                            </x-responsive-nav-link>
                        @endcan

                        <!-- Team Switcher -->
                        @if (Auth::user()->allTeams()->count() > 1)
                            <div class="border-t border-gray-200"></div>

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Teams') }}
                            </div>

                            @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" component="responsive-nav-link" />
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        @else
            <div class="pt-2 pb-3 space-y-1 ">
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
        <!-- Nav Links -->
        <div class="pt-2 pb-3 space-y-1 border-t border-gray-200">
            @auth
                <x-responsive-nav-link href="{{ route($app.'.notifications') }}" :active="request()->routeIs($app.'.notifications')" class="flex w-full justify-between">
                    {{ __('Notifications') }}
                    <div class="relative top-2 right-2">
                        @livewire('notifications.notifications-count')
                    </div>
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route($app.'.lists') }}" :active="request()->routeIs($app.'.lists')">
                    {{ __('Playlists') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link href="{{ route($app.'.favorite_videos') }}" :active="request()->routeIs($app.'.favorite_videos')">
                    {{ __('Favorites') }}
                </x-responsive-nav-link>
            @endauth
            <x-responsive-nav-link href="{{ route($app.'.categories') }}" :active="request()->routeIs($app.'.categories')">
                {{ __('Categories') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route($app.'.artists') }}" :active="request()->routeIs($app.'.artists')">
                {{ __('Artists') }}
            </x-responsive-nav-link>
        </div> 
    </div> 
</div>