<div x-data="{ isOpen: @entangle('showDropdown') }">
    <form wire:submit="create">
        <div class="bg-gray-200 rounded-full pl-4 pr-8 w-64 relative">
            <input 
                type="text"
                wire:model.live="q"
                placeholder="Search"
                class="fi-input block w-full border-none bg-transparent py-1.5 text-base text-gray-950 outline-none transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 ps-0 pe-3"
            > 
            <div class="absolute top-2 right-3">
                <x-heroicon-o-arrow-path wire:loading class="h-4 w-4 -mt-2 mr-1 text-gray-500 animate-spin"/>
                <x-heroicon-o-magnifying-glass wire:loading.class="hidden" class="h-5 w-5 text-gray-500"/>
            </div>
        </div>
    </form>
    @if($totalCount)
        <div class="relative">
            <div            
                x-show="isOpen"
                x-cloak
                @click.away="isOpen = false"
                class="absolute top-0 left-0 z-20 w-full font-normal bg-white shadow overflow-hidden rounded w-48 border mt-2"
            >
                <div class="max-h-60 overflow-auto">
                    <div class="">
                        @foreach($categories as $key => $values)
                            @if(isset($values['count']) && $values['count'])
                                <div class="font-bold text-sm bg-gray-200 p-2">
                                    {{ $key }}
                                </div>                        
                                <div class="">
                                    @foreach ($values['items'] as $item)
                                        @if($key == "Artists")
                                            <a href="{{ route($app.'.artists.show', $item->slug) }}" class="playlist-item block image-hover" data-ytid="{{ $item->ytid }}" data-slug="{{ $item->slug }}">
                                                <div class="w-full lg:flex">
                                                    <!-- Image -->    
                                                    <div class="aspect-video w-full lg:w-20 flex-none bg-cover rounded-t lg:rounded-t-none text-center overflow-hidden img-container">
                                                        <img class="w-full" src="{{ $item->thumbnail }}" alt="" />
                                                    </div>
                                                    <!-- Info --> 
                                                    <div class="w-full border-r border-b border-l border-gray-200 lg:border-l-0 lg:border-t bg-white rounded-b lg:rounded-b-none p-4 lg:p-0 lg:pl-4 flex flex-col items-center justify-center lg:items-start leading-normal truncate">
                                                        <div class="text-sm text-gray-900 font-bold md:truncate">
                                                            {{ $item->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                        @if($key == "Tags")
                                            <a href="{{ route($app.'.tag', $item->name) }}" class="text-sm block p-2 hover:bg-gray-100 truncate">
                                                {{ "#".$item->name }}
                                            </a>
                                        @endif
                                        @if($key == "Tweets")
                                            <a href="{{ route($app.'.tweet', $item->id) }}" class="text-sm block p-2 hover:bg-gray-100 truncate">
                                                {{ $item->content }}
                                            </a>
                                        @endif
                                        @if($key == "Users")
                                            <a href="{{ route($app.'.members.show', $item->name) }}" class="block bg-white hover:bg-gray-100 hover:cursor-pointer px-4 py-2">
                                                <div class="flex w-full"> 
                                                    <div class="inline-block image-hover img-container overflow-hidden">    
                                                        <img class="w-10 h-10 rounded-full object-cover" src="{{ $item->avatar }}" alt="{{ $item->name }}" />
                                                    </div>
                                                    <div class="ml-2 flex flex-col justify-center items-start leading-normal">
                                                        <div class="text-sm text-gray-900 font-bold text-lg truncate">
                                                            {{ $item->name }}
                                                        </div>
                                                        <p class="text-sm text-gray-500">
                                                            {{ "@".$item->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                        @if($key == "Videos")
                                            <a href="{{ route($app.'.video.show', $item->slug) }}" class="playlist-item block image-hover" data-ytid="{{ $item->ytid }}" data-slug="{{ $item->slug }}">
                                                <div class="w-full lg:flex">
                                                    <!-- Image -->    
                                                    <div class="aspect-video w-full lg:w-20 flex-none bg-cover rounded-t lg:rounded-t-none text-center overflow-hidden img-container">
                                                        <img class="w-full" src="{{ $item->thumbnail }}" alt="" />
                                                    </div>
                                                    <!-- Info --> 
                                                    <div class="w-full border-r border-b border-l border-gray-200 lg:border-l-0 lg:border-t bg-white rounded-b lg:rounded-b-none p-4 lg:p-0 lg:pl-4 flex flex-col items-center justify-center lg:items-start leading-normal md:truncate">
                                                        <div class="text-sm text-gray-900 font-bold md:truncate">
                                                            {{ $item->name }}
                                                        </div>
                                                        <p class="text-sm text-gray-700 md:truncate">
                                                            {{ $item->artist->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
