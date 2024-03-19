<button type="button" wire:click="onClick" class="flex p-2 rounded hover:bg-gray-200">
    <x-heroicon-o-arrow-path wire:loading class="h-4 w-4 animate-spin"/>
    @isset($item)
        <x-heroicon-o-minus class="h-4 w-4" wire:loading.class="hidden"/>
    @else
        <x-heroicon-o-plus class="h-4 w-4" wire:loading.class="hidden"/>
    @endisset
</button> 
