<div class="">
    @isset($tweet)
        <div class="@if($tweet->muted || $reposter && $reposter->hide_reposts) hidden @endif bg-white border border-gray-300 rounded-lg p-4 relative">
            <!--<a href="{{ route($app.'.tweet', $tweet->id, 'twitter') }}" class="absolute top-0 left-0 w-full h-full">&nbsp;</a>-->
            <div class="mb-4">  
                <a href="{{ route($app.'.members.show', $tweet->user->name) }}" class="">
                    <div class="w-full flex">
                        <!-- Image -->    
                        <div class="flex-none text-center overflow-hidden img-container">
                            <img class="w-14 h-14 rounded-full object-cover" src="{{ $tweet->user->avatar_thumb }}" alt="" />
                        </div>
                        <!-- Info --> 
                        <div class="w-full pl-4 flex flex-col justify-center leading-normal">
                            <div class="font-bold text-black">
                                {{ $tweet->user->twitter_display_name }}
                            </div>
                            <div class="text-gray-500">
                                <span>&#64;{{ $tweet->user->name }}</span>
                                <span class="">•</span>
                                <span>{{ $tweet->created_time }}</span>
                            </div>
                        </div>
                    </div>
                </a>     
            </div>
            @isset($reposter)
                <a href="{{ route($app.'.members.show', $reposter->name) }}" class="absolute top-3 right-4 flex items-center hover:underline text-sm">
                    <x-heroicon-o-arrow-path class="h-4 w-4"/>
                    <span class="ml-1">
                        <span class="font-bold">{{ $reposter->name }}</span> reposted
                    </span>
                </a> 
            @endisset
            @isset($tweet->parent)
                <a href="{{ route($app.'.tweet', $tweet->parent->id) }}" class="absolute top-3 right-4 flex items-center hover:underline text-sm">
                    <x-heroicon-o-arrow-path class="h-4 w-4"/>
                    <span class="ml-1">
                        <span class="font-bold">Replied to {{ "@".$tweet->parent->user->name }}</span>
                    </span>
                </a> 
            @endisset
            <div class="tweet-content mb-6">
                {!! $tweet->parsed_content !!}
            </div>
            @if(count($tweet->photos))
                <div class="grid grid-cols-{{ count($tweet->photos) > 1 ? 2 : 1 }} gap-2 mb-4" x-data="{ hide: {{ $tweet->sensitive ? "true" : "false" }} }">
                    @foreach ($tweet->photos as $photo)
                        <div class="">
                            <button x-cloak x-show="hide" x-on:click="hide = false" class="relative w-full image-hover img-container overflow-hidden border border-gray-200 rounded-lg">
                                <div class="blur-lg">                                    
                                    <img class="w-full" src="{{ $photo->getAvailableUrl(['thumb']) }}" alt="" />                                    
                                </div>
                                <div class="flex w-full h-full justify-center items-center absolute top-0 left-0">
                                    <div class="bg-red-500 px-4 py-2 rounded-full text-white text-sm">
                                        Image has sensitive content. Click to show.
                                    </div>
                                </div>
                            </button>

                            <button x-cloak x-show="!hide" @click="Livewire.dispatch('openModal', { component: 'modals.modal-tweet-photos', arguments: { app: '{{ $app }}', view: '.modals._tweet-photos', id: {{ $tweet->id }} }})" class="w-full image-hover img-container overflow-hidden border border-gray-200 rounded-lg">
                                @switch(getMediaType($photo))
                                    @case('video')
                                        <video controls autoplay loop muted>
                                            <source src="{{ $photo->getUrl() }}" type="{{ $photo->mime_type }}">
                                        </video>
                                    @break
                                    @default
                                        <img class="w-full" src="{{ $photo->getAvailableUrl(['thumb']) }}" alt="" /> 
                                    @break
                                @endswitch
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
            @unless($hideFooter)
                <!-- Tweet Footer -->
                @auth
                    <div class="text-center flex items-center gap-2">     
                        <button type="button" @click="Livewire.dispatch('openModal', { component: 'modals.modal-live', arguments: { app: '{{ $app }}', view: '.modals._tweet-reply', id: {{ $tweet->id }} }})" class="flex items-center p-2 rounded-lg text-gray-700 hover:bg-gray-100">
                            <x-heroicon-o-chat-bubble-bottom-center class="h-6 w-6"/>
                            @if($tweet->comments_count > 0)
                                <div class="ml-2"> 
                                    <span>{{ number_format($tweet->comments_count) }}</span>
                                </div>
                            @endif
                        </button>
                        <button type="button" wire:click="repost({{ $tweet->id }})" class="flex items-center p-2 rounded-lg text-gray-700 hover:bg-gray-100">
                            <x-heroicon-o-arrow-path wire:loading wire:target="repost({{ $tweet->id }})" class="h-6 w-6 animate-spin"/>
                            <x-heroicon-o-arrow-path class="h-6 w-6" wire:loading.class="hidden" wire:target="repost({{ $tweet->id }})"/> 
                            @if($tweet->reposts_count > 0)
                                <div class="ml-2"> 
                                    <span>{{ number_format($tweet->reposts_count) }}</span>
                                </div>
                            @endif
                        </button>
                        @livewire('reactions.reactions-button', [
                            'showCount' => true,
                            'name' => 'like',
                            'class' => 'flex text-gray-500 font-bold p-2 hover:text-black',
                            'icon' => 'hand-thumb-up',
                            'title' => '',
                            'activeClass' => 'flex border border-gray-500 text-gray-500 bg-gray-100 rounded-full font-bold p-2',
                            'activeTitle' => '',
                            'object_type' => 'App\Models\Tweet',
                            'object_id' => $tweet->id
                        ], key('like-'.$tweet->id))
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">                                
                                <button class="flex grow w-full items-center rounded-full border border-gray-500 text-gray-500 hover:text-black focus:text-black">
                                    <x-heroicon-o-ellipsis-horizontal class="h-9 w-9"/>   
                                </button>                                
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link href="{{ route($app.'.tweet', $tweet->id, 'twitter') }}" class="flex items-center hover:text-black focus:text-black">
                                    <x-heroicon-o-arrows-pointing-out class="h-6 w-6"/>
                                    <span class="ml-2 truncate">Expand this post</span>
                                </x-dropdown-link>
                                <a href="{{ route($app.'.tweet', $tweet->id, 'twitter') }}" onClick="event.preventDefault(); copyToClipboard(event.currentTarget.href);" class="px-4 py-2 text-sm flex items-center hover:text-black focus:text-black">
                                    <x-heroicon-o-link class="h-6 w-6"/>
                                    <span class="ml-2 truncate">Copy Link to post</span>
                                </a>
                                @livewire('reactions.reactions-button', [
                                    'name' => 'bookmark',
                                    'class' => 'flex w-full px-4 py-2 text-sm text-gray-700 items-center hover:text-black focus:text-black',
                                    'icon' => 'bookmark',
                                    'activeIcon' => 'bookmark-square',
                                    'title' => 'Bookmark',
                                    'activeTitle' => 'Bookmarked',
                                    'object_type' => 'App\Models\Tweet',
                                    'object_id' => $tweet->id
                                ], key('bookmark-'.$tweet->id))
                                <div class="border-t border-gray-200"></div>
                                @if($tweet->user->is_my_profile)
                                    @livewire('reactions.reactions-button', [     
                                        'name' => 'pin',
                                        'class' => 'flex w-full px-4 py-2 text-sm text-gray-700 items-center hover:text-black focus:text-black',
                                        'icon' => 'star',
                                        'title' => 'Pin on profile',
                                        'activeTitle' => 'Unpin from profile',
                                        'object_type' => 'App\Models\Tweet',
                                        'object_id' => $tweet->id
                                    ], key('pin-'.$tweet->id))
                                    <button type="button" @click="Livewire.dispatch('openModal', { component: 'modals.modal-delete', arguments: { app: '{{ $app }}', view: '.modals._tweet-delete', name: 'delete-tweet', id: {{ $tweet->id }} }})" class="block w-full px-4 py-2 text-left text-sm leading-5 text-red-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-red-500 focus:text-red-500">
                                        <x-heroicon-o-trash class="h-6 w-6"/>
                                        <span class="ml-2 truncate">Delete</span>
                                    </button>
                                    <button type="button" @click="Livewire.dispatch('openModal', { component: 'modals.modal-live', arguments: { app: '{{ $app }}', view: '.modals._tweet-edit', id: {{ $tweet->id }} }})" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-gray-500 focus:text-gray-500">
                                        <x-heroicon-o-pencil-square class="h-6 w-6"/>
                                        <span class="ml-2 truncate">Edit</span>
                                    </button>
                                @else
                                    <button @click="Livewire.dispatch('openModal', { component: 'modals.modal-tweet-compose', arguments: { app: '{{ $app }}', view: '.modals._tweet-compose', content: '{{ '@'.$tweet->user->name }}' }})" class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-black focus:text-black">
                                        <x-heroicon-o-at-symbol class="h-6 w-6"/>
                                        <span class="ml-2 truncate">Mention {{ "@".$tweet->user->name }}</span>
                                    </button>
                                    @unless($tweet->user->blocked_me)
                                        <x-dropdown-link href="{{ route($app.'.messages.create', $tweet->user->name) }}" class="flex items-center hover:text-black focus:text-black">
                                            <x-heroicon-o-envelope class="h-6 w-6"/>
                                            <span class="ml-2 truncate">Chat with {{ "@".$tweet->user->name }}</span>
                                        </x-dropdown-link>
                                    @endunless
                                    <div class="border-t border-gray-200"></div>
                                    <button type="button" @click="Livewire.dispatch('openModal', { component: 'modals.modal-mute-user', arguments: { app: '{{ $app }}', view: '.modals._user-mute', id: {{ $tweet->user->id }} }})" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-gray-500 focus:text-gray-500">
                                        <x-heroicon-o-speaker-x-mark class="h-6 w-6"/>
                                        <span class="ml-2 truncate">Mute {{ "@".$tweet->user->name }}</span>
                                    </button>
                                    <button type="button" @click="Livewire.dispatch('openModal', { component: 'modals.modal-block-user', arguments: { app: '{{ $app }}', view: '.modals._user-block', id: {{ $tweet->user->id }} }})" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-gray-500 focus:text-gray-500">
                                        <x-heroicon-o-no-symbol class="h-6 w-6"/>
                                        <span class="ml-2 truncate">Block {{ "@".$tweet->user->name }}</span>
                                    </button>
                                    <button type="button" @click="Livewire.dispatch('openModal', { component: 'modals.modal-report', arguments: { app: '{{ $app }}', view: '.modals._report', id: {{ $tweet->user->id }}, object_type: 'App\\Models\\Tweet', object_id: {{ $tweet->id }} }})" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out flex items-center hover:text-gray-500 focus:text-gray-500">
                                        <x-heroicon-o-flag class="h-6 w-6"/>
                                        <span class="ml-2 truncate">Report {{ "@".$tweet->user->name }}</span>
                                    </button>
                                @endif                 
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endauth
            @endunless    
        </div>
    @endisset
</div>