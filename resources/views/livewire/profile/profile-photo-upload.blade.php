<div>    

    <form wire:submit="create" class="">
        {{ $this->form }}   

        <div class="text-center py-4 relative">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <x-heroicon-o-arrow-path wire:loading wire:target="create" class="h-6 w-6 text-white animate-spin"/>
                <span wire:loading.class="hidden" wire:target="create">
                    Upload
                </span>
            </button>
        </div>
    </form> 

    <div class="mb-4">
        <div class="font-bold">
            Cover Photo
        </div>
    </div>

    @if(count($items))
        <div class="grid grid-cols-4 gap-2 mb-4">
            @foreach ($items as $photo)
                <div class="relative">
                    <button wire:click="setCoverPhoto({{ $photo->id }})" class="w-full image-hover img-container overflow-hidden border border-gray-200 rounded-lg @if($photo->id == Auth::user()->cover_photo_id) border-4 border-red-200 @endif">
                        <img class="w-full" src="{{ $photo->getUrl('thumb') }}" alt="" />                            
                    </button>
                    <button @click="Livewire.dispatch('openModal', { component: 'modals.modal-delete', arguments: { app: '{{ $app }}', view: '.modals._photo-delete', name: 'delete-profile-photo', id: {{ $photo->id }} }})" class="absolute top-1 right-1 p-1 bg-white border border-gray-200 rounded-lg hover:bg-gray-200">
                        <x-heroicon-o-x-mark class="h-3 w-3"/>
                    </button>
                </div>
            @endforeach
            <button wire:click="setCoverPhoto()" class="flex items-center justify-center w-full image-hover img-container overflow-hidden border border-gray-200 rounded-lg">
                <x-heroicon-o-no-symbol  class="h-6 w-6"/>
            </button>
        </div>
    @endif

    <div class="mb-4">
        <div class="font-bold">
            Avatar
        </div>
    </div>    

    @if(count($items))
        <div class="grid grid-cols-4 gap-2 mb-4">
            @foreach ($items as $photo)
                <div class="relative">
                    <button wire:click="setMainPhoto({{ $photo->id }})" class="w-full image-hover img-container overflow-hidden border border-gray-200 rounded-lg @if($photo->id == Auth::user()->photo_id) border-4 border-red-200 @endif">
                        <img class="w-full" src="{{ $photo->getUrl('thumb') }}" alt="" />                            
                    </button>
                    <button @click="Livewire.dispatch('openModal', { component: 'modals.modal-delete', arguments: { app: '{{ $app }}', view: '.modals._photo-delete', name: 'delete-profile-photo', id: {{ $photo->id }} }})" class="absolute top-1 right-1 p-1 bg-white border border-gray-200 rounded-lg hover:bg-gray-200">
                        <x-heroicon-o-x-mark class="h-3 w-3"/>
                    </button>
                </div>
            @endforeach
            <button wire:click="setMainPhoto()" class="flex items-center justify-center w-full image-hover img-container overflow-hidden border border-gray-200 rounded-lg">
                <x-heroicon-o-no-symbol  class="h-6 w-6"/>
            </button>
        </div>
    @endif

</div>
