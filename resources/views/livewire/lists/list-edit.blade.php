<div>
    <div class="mb-4">
        <div class="text-large font-bold mb-2">
            Change Title
        </div>
        <form wire:submit="create">
            <div class="flex w-full items-center">
                <div class="grow">
                    {{ $this->form }}
                </div> 
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <x-heroicon-o-arrow-path wire:loading wire:target="create" class="h-6 w-6 mr-2 text-white animate-spin"/>
                    <span wire:loading.class="hidden" wire:target="create">Save</span>
                </button>
            </div>
        </form>
    </div>

    @if(count($items))
        <div class="mb-4">
            <div class="text-large font-bold mb-2">
                Remove from List
            </div>
            <div class="grid grid-cols-1 gap-2">
                @if($type == "users")
                    @foreach ($items as $item)
                        @livewire('lists.list-user', [
                            'app' => $app,
                            'id' => $id,
                            'profile' => $item->object,
                        ], key('list-edit-user-'.$item->object->id))  
                    @endforeach
                @endif
                @if($type == "videos")
                    @foreach ($items as $item)
                        @livewire('lists.list-video', [
                            'app' => $app,
                            'id' => $id,
                            'video' => $item->object,
                        ], key('list-edit-video-'.$item->object->id))  
                    @endforeach
                @endif
            </div>
        </div>
    @endif

    <div class="mb-4">
        <div class="text-large font-bold mb-2">
            Add to List
        </div>
        @livewire('lists.list-search', [
            'app' => $app,
            'type' => $type,
            'id' => $id
        ])
    </div>
</div>
