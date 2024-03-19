<div class="flex items-center justify-between gap-2">
    <a href="{{ route($app.'.video.show', $video->slug) }}" class="playlist-item flex grow image-hover">
        <div class="flex w-full">
            <!-- Image -->    
            <div class="aspect-video w-full lg:w-32 flex-none bg-cover rounded-t lg:rounded-t-none text-center overflow-hidden img-container">
                <img class="w-full" src="{{ $video->thumbnail }}" alt="" />
            </div>
            <!-- Info --> 
            <div class="w-full border-r border-b border-l border-gray-200 lg:border-l-0 lg:border-t bg-white rounded-b lg:rounded-b-none p-4 lg:p-0 lg:pl-4 flex flex-col grow items-center justify-center lg:items-start leading-normal truncate">
                <div class="text-gray-900 font-bold text-lg truncate">
                    {{ $video->name }}
                </div>
                <p class="text-gray-700 text-base truncate">
                    {{ $video->artist->name }}
                </p>
            </div>
        </div>
    </a>
    <div class="flex gap-2">  
        <button type="button" wire:click="onClick" class="flex p-2 rounded hover:bg-gray-200">
            <x-heroicon-o-arrow-path wire:loading wire:target="onClick" class="h-4 w-4 animate-spin"/>
            @isset($item)
                <x-heroicon-o-minus class="h-4 w-4" wire:loading.class="hidden" wire:target="onClick"/>
            @else
                <x-heroicon-o-plus class="h-4 w-4" wire:loading.class="hidden" wire:target="onClick"/>
            @endisset
        </button>                   
    </div>
</div>
