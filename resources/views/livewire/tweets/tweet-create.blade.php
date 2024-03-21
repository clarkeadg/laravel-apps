<div class="tweet-create">        
    <div class="mb-4">
        <a href="{{ route($app.'.members.show', Auth::user()->name) }}" class="">
            <div class="w-full flex">
                <!-- Image -->    
                <div class="flex-none text-center overflow-hidden img-container">
                    <img class="w-14 h-14 rounded-full object-cover" src="{{ Auth::user()->avatar_thumb }}" alt="" />
                </div>
                <!-- Info --> 
                <div class="w-full p-4 p-0 pl-4 flex flex-col items-start leading-normal">
                    <div class="text-gray-500">
                        What's on your mind?
                    </div>
                </div>
            </div>
        </a>
    </div>

    <form wire:submit="create" class="tweet-create-form @unless($showPhotoUpload) hide-photo-upload @endunless">
        {{ $this->form }}        
        
        <div class="flex w-full justify-between items-center pt-4 relative">
            <div class="">
                <button id="photoUpload" type="button" wire:click="togglePhotoUpload" class="p-2 bg-white rounded hover:bg-gray-200" title="Upload Photos">
                    <x-heroicon-o-arrow-path wire:loading wire:target="togglePhotoUpload" class="h-6 w-6 text-black animate-spin"/>
                    <x-heroicon-o-photo wire:loading.class="hidden" wire:target="togglePhotoUpload" class="h-6 w-6"/>
                </button>
            </div>
            <div class="">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <x-heroicon-o-arrow-path wire:loading wire:target="create" class="h-6 w-6 mr-2 text-white animate-spin"/>
                    <span wire:loading.class="hidden" wire:target="create">
                        @isset($id)
                            Update Tweet
                        @else
                            Tweet
                        @endisset
                    </span>
                </button>
            </div>
        </div>
    </form>

    @isset($tweet)
        @if(count($tweet->photos))
            <div class="grid grid-cols-{{ count($tweet->photos) > 1 ? 2 : 1 }} gap-2 py-4">
                @foreach ($tweet->photos as $photo)
                    <div class="relative">
                        <button @click="Livewire.dispatch('openModal', { component: 'modals.modal-delete', arguments: { app: '{{ $app }}', view: '.modals._photo-delete', name: 'delete-tweet-photo', id: {{ $tweet->id }}, id2: {{ $photo->id }} }})" class="absolute top-2 right-2 z-50 p-2 bg-white border border-gray-200 rounded-lg hover:bg-gray-200">
                            <x-heroicon-o-x-mark class="h-4 w-4"/>
                        </button>
                        @switch(getMediaType($photo))
                            @case('video')
                                <video controls autoplay loop muted>
                                    <source src="{{ $photo->getUrl() }}" type="{{ $photo->mime_type }}">
                                </video>
                            @break
                            @default
                                <img class="w-full" src="{{ $photo->getAvailableUrl(['thumb']) }}" alt="" />
                            @break
                        @endswitch                          
                    </div>
                @endforeach
            </div>
        @endif
    @endisset
</div>
