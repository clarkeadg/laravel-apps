<div class="">
    <div class="flex justify-center w-full">
        <form wire:submit="create">
            <div class="flex items-end">
                {{ $this->form }} 
                
                <div wire:loading>
                    <x-heroicon-o-arrow-path class="ml-4 h-8 w-8 text-blue-500 animate-spin"/>
                </div>

                <button type="submit" wire:loading.class="hidden" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Search
                </button>
            </div>
        </form>
    </div>

    @isset($items)
        <div class="py-5 flex flex-col justify-center w-full grid grid-cols-1 gap-2">
            @foreach ($items as $profile) 
                @include('apps.'.$app.'.cards.profile')
            @endforeach
        </div>
    @endisset  

    @if($this->hasMorePages())
        @include('components.load-more')
    @endif
</div>