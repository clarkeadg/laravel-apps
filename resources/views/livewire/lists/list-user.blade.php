<div class="flex items-center justify-between gap-2">
    <a href="{{ route($app.'.members.show', $profile->name) }}" class="grow bg-white rounded-lg hover:bg-gray-200 hover:cursor-pointer px-4 py-2">
        <div class="flex w-full">
            <!-- Image -->    
            <div class="inline-block image-hover img-container overflow-hidden">    
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $profile->avatar }}" alt="{{ $profile->name }}" />
            </div>
            <!-- Info --> 
            <div class="ml-4 flex flex-col justify-center items-start leading-normal">
                <div class="text-gray-900 font-bold text-lg truncate">
                    {{ $profile->name }}
                </div>
                <p class="text-gray-500">
                    {{ "@".$profile->name }}
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
