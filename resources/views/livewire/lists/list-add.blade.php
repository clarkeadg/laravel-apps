<div>
    <div class="mb-4">
        @if($type == "users")
            <a href="{{ route($app.'.members.show', $profile->name) }}" class="image-hover">
                <div class="flex w-full">
                    <!-- Image -->    
                    <div class="inline-block image-hover img-container overflow-hidden">    
                        <img class="w-16 h-16 rounded-full object-cover" src="{{ $profile->avatar }}" alt="{{ $profile->name }}" />
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
        @endif
        @if($type == "videos")
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
        @endif
    </div>

    <div class="mb-4">
        <div class="text-large font-bold mb-2">
            Add List
        </div>
        <form wire:submit="create">
            <div class="flex w-full items-center">
                <div class="grow">
                    {{ $this->form }}
                </div> 
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <x-heroicon-o-arrow-path wire:loading class="h-6 w-6 mr-2 text-white animate-spin"/>
                    <span wire:loading.class="hidden">Add List</span>
                </button>
            </div>
        </form>
    </div>

    <div class="mb-4">
        <div class="text-large font-bold mb-2">
            Your Lists
        </div>
        <div class="grid grid-cols-1 gap-4">
            @foreach ($items as $list)
                <div class="flex items-center justify-between gap-2">
                    <div class="flex grow items-center">
                        <x-heroicon-o-list-bullet class="h-4 w-4"/> 
                        <span class="ml-2">{{ $list->name }}</span>
                    </div>                    
                    <div class="flex gap-2">  
                        @if($type == "users")
                            @livewire('lists.list-button', [
                                'app' => $app,
                                'id' => $list->id,
                                'object_type' => 'App\Models\User',
                                'object_id' => $profile->id
                            ], key('list-button-'.$list->id.'-'.$profile->id)) 
                        @endif
                        @if($type == "videos")
                            @livewire('lists.list-button', [
                                'app' => $app,
                                'id' => $list->id,
                                'object_type' => 'App\Models\Video',
                                'object_id' => $video->id
                            ], key('list-button-'.$list->id.'-'.$video->id)) 
                        @endif             
                    </div>                
                </div>
            @endforeach
        </div>
    </div>
</div>
