<div class="">
    <div class="mb-4">
        <form wire:submit="create">
            <div class="flex w-full items-center">
                <div class="grow">
                    {{ $this->form }}
                </div> 
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <x-heroicon-o-arrow-path wire:loading wire:target="create" class="h-6 w-6 mr-2 text-white animate-spin"/>
                    <span wire:loading.class="hidden" wire:target="create">Search</span>
                </button>
            </div>
        </form>
    </div>

    @isset($items)
        <div class="py-5 flex flex-col justify-center w-full grid grid-cols-1 gap-2">
            @foreach ($items as $profile) 
                @include('apps.'.$app.'.cards.profile-search')
            @endforeach
        </div> 
    @endisset   

    @if($this->hasMorePages())
        @include('components.load-more')
    @endif
</div>