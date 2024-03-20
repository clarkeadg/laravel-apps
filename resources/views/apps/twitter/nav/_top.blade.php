<nav x-data="{ open: false }" class="border-b border-gray-200">
    <div class="bg-white w-full">
        <div class="flex justify-between h-16 max-w-7xl mx-auto pl-4 pr-6 md:px-6">            

            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route($app.'.home') }}">
                        <img src="/images/twitter/logo.png" alt="{{ config('app.name') }}" class="h-6 w-auto"/>
                    </a>
                </div> 
                
                <!-- Search -->
                <div class="pl-5 pr-4 md:px-6">
                    @livewire('global-search', [
                        'app' => $app,
                        'categories' => [
                            'Users' => [],
                            'Tweets' => [],
                            'Tags' => [],      
                        ]
                    ])
                </div>
                
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center mr-5"> 
                    @auth

                    @else
                        <x-nav-link id="LoginButton" href="{{ route('login') }}" :active="request()->routeIs('login')" class="font-medium text-gray-500 hover:text-black focus:text-black">
                            {{ __('Login') }}
                        </x-nav-link>
                        @if (Route::has('register'))
                            <x-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')" class="font-medium text-gray-500 hover:text-black focus:text-black">
                                {{ __('Signup') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            
                @auth
                    <!-- Teams Dropdown -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="ml-3 relative">
                            <x-dropdown align="right" width="60">
                                <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->currentTeam->name }}

                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="w-60">
                                        <!-- Team Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Team') }}
                                        </div>

                                        <!-- Team Settings -->
                                        <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                            {{ __('Team Settings') }}
                                        </x-dropdown-link>

                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-dropdown-link href="{{ route('teams.create') }}">
                                                {{ __('Create New Team') }}
                                            </x-dropdown-link>
                                        @endcan

                                        <!-- Team Switcher -->
                                        @if (Auth::user()->allTeams()->count() > 1)
                                            <div class="border-t border-gray-200"></div>

                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Switch Teams') }}
                                            </div>

                                            @foreach (Auth::user()->allTeams() as $team)
                                                <x-switchable-team :team="$team" />
                                            @endforeach
                                        @endif
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif

                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">                                
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    @livewire('profile.profile-avatar', ['app' => $app])
                                </button>                                
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-dropdown-link href="{{ route($app.'.members.show', Auth::user()->name) }}">
                                    {{ __('My Profile') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route($app.'.settings') }}">
                                    {{ __('Settings') }}
                                </x-dropdown-link>

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-200"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}"
                                            @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endauth
            </div>

            @relativeInclude('_hamburger')
        </div>
    </div>
    @relativeInclude('_mobile')
</nav>
