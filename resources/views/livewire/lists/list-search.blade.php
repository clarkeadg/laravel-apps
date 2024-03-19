<div>
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

    <div class="grid grid-cols-1 gap-2">
        @isset($items)
            @if($type == "users")
                @foreach ($items as $item)
                    @livewire('lists.list-user', [
                        'app' => $app,
                        'id' => $id,
                        'profile' => $item,
                    ], key('list-search-user-'.$item->id))
                @endforeach
            @endif
            @if($type == "videos")
                @foreach ($items as $item)
                    @livewire('lists.list-video', [
                        'app' => $app,
                        'id' => $id,
                        'video' => $item,
                    ], key('list-search-video-'.$item->id))
                @endforeach
            @endif
        @endisset
    </div>
</div>
