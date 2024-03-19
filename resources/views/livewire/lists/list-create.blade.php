<div>
    <div class="mb-4">
        <form wire:submit="create">
            <div class="flex w-full items-center">
                <div class="grow">
                    {{ $this->form }}
                </div> 
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <x-heroicon-o-arrow-path wire:loading wire:target="create" class="h-6 w-6 mr-2 text-white animate-spin"/>
                    <span wire:loading.class="hidden" wire:target="create">Create New List</span>
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 gap-4">
        @foreach ($items as $list)
            <div class="flex items-center justify-between gap-2">
                <a href="{{ route($app.'.list', $list->id) }}" class="grow bg-white rounded-lg hover:bg-gray-200 hover:cursor-pointer px-4 py-2">
                    <div class="flex items-center">
                        <x-heroicon-o-list-bullet class="h-4 w-4"/> 
                        <span class="ml-2">{{ $list->name }}</span>
                    </div>
                </a>
                <div class="flex gap-2">
                    <button type="button" @click="Livewire.dispatch('openModal', { component: 'modals.modal-list-edit', arguments: { app: '{{ $app }}', view: '.modals._lists-edit', id: {{ $list->id }} }})" class="p-2 rounded hover:bg-gray-200">
                        <x-heroicon-o-pencil class="h-4 w-4"/> 
                    </button>    
                    <button type="button" @click="Livewire.dispatch('openModal', { component: 'modals.modal-delete', arguments: { app: '{{ $app }}', view: '.modals._lists-delete', name: 'delete-list', id: {{ $list->id }} }})" class="p-2 rounded hover:bg-gray-200">
                        <x-heroicon-o-trash class="h-4 w-4"/> 
                    </button>                    
                </div>                
            </div>
        @endforeach
    </div>
</div>
