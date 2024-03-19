<div class="flex justify-end items-center gap-2 px-5 h-10"> 
    @if($profile->is_my_profile)                    
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">                                
                <button class="flex grow w-full items-center rounded-full border border-gray-500 text-gray-500 hover:text-black focus:text-black">
                    <x-heroicon-o-ellipsis-horizontal class="h-9 w-9"/>   
                </button>                                
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link href="{{ route($app.'.settings.profile') }}" class="flex items-center hover:text-black focus:text-black">
                    <x-heroicon-o-user class="h-6 w-6"/>
                    <span class="ml-4">{{ __('Edit Profile') }}</span>
                </x-dropdown-link>
                <x-dropdown-link href="{{ route($app.'.settings') }}" class="flex items-center hover:text-black focus:text-black">
                    <x-heroicon-o-cog-6-tooth class="h-6 w-6"/>
                    <span class="ml-4">{{ __('Preferences') }}</span>
                </x-dropdown-link>
                <div class="border-t border-gray-200"></div>
                <x-dropdown-link href="{{ route($app.'.mutes') }}" class="flex items-center hover:text-black focus:text-black">
                    <x-heroicon-o-speaker-x-mark class="h-6 w-6"/>
                    <span class="ml-4">{{ __('Mutes') }}</span>
                </x-dropdown-link>
                <x-dropdown-link href="{{ route($app.'.blocks') }}" class="flex items-center hover:text-black focus:text-black">
                    <x-heroicon-o-no-symbol class="h-6 w-6"/>
                    <span class="ml-4">{{ __('Blocks') }}</span>
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
        <x-nav-link href="{{ route($app.'.settings.profile') }}" :active="request()->routeIs($app.'.settings.profile')" class="py-2 px-4 flex items-center rounded-full border border-gray-500 font-medium text-gray-500 hover:text-black focus:text-black">
            {{ __('Edit Profile') }}</span>
        </x-nav-link>
    @else
        @auth
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">                                
                    <button class="flex grow w-full items-center rounded-full border border-gray-500 text-gray-500 hover:text-black focus:text-black">
                        <x-heroicon-o-ellipsis-horizontal class="h-9 w-9"/>   
                    </button>                                
                </x-slot>
                <x-slot name="content">
                    <button @click="Livewire.dispatch('openModal', { component: 'modals.modal-tweet-compose', arguments: { app: '{{ $app }}', view: '.modals._tweet-compose', content: '{{ '@'.$profile->name }}' }})" class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-black focus:text-black">
                        <x-heroicon-o-at-symbol class="h-6 w-6"/>
                        <span class="ml-2 truncate">Mention {{ "@".$profile->name }}</span>
                    </button>
                    @unless($profile->blocked_me)
                        <x-dropdown-link href="{{ route($app.'.messages.create', $profile->name) }}" class="flex items-center hover:text-black focus:text-black">
                            <x-heroicon-o-envelope class="h-6 w-6"/>
                            <span class="ml-2 truncate">Chat with {{ "@".$profile->name }}</span>
                        </x-dropdown-link>
                    @endunless
                    @livewire('reactions.reactions-button', [
                        'name' => 'hide_reposts',
                        'icon' => 'arrow-path',
                        'class' => 'flex w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-black focus:text-black',
                        'title' => 'Hide reposts from @'.$profile->name,
                        'activeTitle' => 'Show reposts from @'.$profile->name,
                        'object_type' => 'App\Models\User',
                        'object_id' => $profile->id
                    ])
                    <button @click="Livewire.dispatch('openModal', { component: 'modals.modal-list-add', arguments: { app: '{{ $app }}', view: '.modals._lists-add', id: {{ $profile->id }} }})" class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-black focus:text-black">
                        <x-heroicon-o-list-bullet class="h-6 w-6"/>
                        <span class="ml-2 truncate">Add or remove from list</span>
                    </button>
                    <div class="border-t border-gray-200"></div>
                    <x-dropdown-link href="{{ route($app.'.search.tweets', ['username' => $profile->name]) }}" class="flex items-center hover:text-black focus:text-black">
                        <x-heroicon-o-magnifying-glass class="h-6 w-6"/>
                        <span class="ml-2 truncate">Search from {{ "@".$profile->name }}</span>
                    </x-dropdown-link>
                    @if($profile->muted)
                        @livewire('reactions.reactions-button', [
                            'name' => 'mute',
                            'icon' => 'speaker-x-mark',
                            'class' => 'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-black focus:text-black',
                            'title' => 'Mute @'.$profile->name,
                            'activeTitle' => 'Unmute @'.$profile->name,
                            'object_type' => 'App\Models\User',
                            'object_id' => $profile->id
                        ])
                    @else
                        <button @click="Livewire.dispatch('openModal', { component: 'modals.modal-mute-user', arguments: { app: '{{ $app }}', view: '.modals._user-mute', id: {{ $profile->id }} }})" class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-black focus:text-black">
                            <x-heroicon-o-speaker-x-mark class="h-6 w-6"/>
                            <span class="ml-2 truncate">Mute {{ "@".$profile->name }}</span>
                        </button>
                    @endif
                    @if($profile->blocked)
                        @livewire('reactions.reactions-button', [
                            'name' => 'block',
                            'icon' => 'no-symbol',
                            'class' => 'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-black focus:text-black',
                            'title' => 'Block @'.$profile->name,
                            'activeTitle' => 'Unblock @'.$profile->name,
                            'object_type' => 'App\Models\User',
                            'object_id' => $profile->id
                        ])
                    @else
                        <button @click="Livewire.dispatch('openModal', { component: 'modals.modal-block-user', arguments: { app: '{{ $app }}', view: '.modals._user-block', id: {{ $profile->id }} }})" class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-black focus:text-black">
                            <x-heroicon-o-no-symbol class="h-6 w-6"/>
                            <span class="ml-2 truncate">Block {{ "@".$profile->name }}</span>
                        </button>
                    @endif
                    <button @click="Livewire.dispatch('openModal', { component: 'modals.modal-report', arguments: { app: '{{ $app }}', view: '.modals._report', id: {{ $profile->id }} }})" class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-black focus:text-black">
                        <x-heroicon-o-flag class="h-6 w-6"/>
                        <span class="ml-2 truncate">Report {{ "@".$profile->name }}</span>
                    </button>
                    <div class="border-t border-gray-200"></div>
                </x-slot>
            </x-dropdown>
            @livewire('reactions.reactions-button', [
                'name' => 'follow',
                'icon' => 'heart',
                'title' => 'Follow',
                'activeTitle' => 'Following',
                'object_type' => 'App\Models\User',
                'object_id' => $profile->id
            ])
        @endauth
    @endif
</div>