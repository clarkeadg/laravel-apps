<div class="w-full lg:w-4/6">                        
    <!-- Player -->
    <div class="aspect-16x9">
        <div 
            id="player"
            class="video-player"
            data-ytid="{{ $video->ytid }}"
            data-slug="{{ $video->slug }}">
        </div>
    </div>
    <!-- Title -->
    <h5 class="p-4 lg:p-2 text-xl md:text-2xl font-bold tracking-tight">
        {{ $video->name }} - <a href="{{ route($app.'.artists.show', $video->artist->slug) }}" class="text-blue-400 hover:text-blue-600" >{{ $video->artist->name }}</a>
    </h5>
    <!-- Button Bar -->
    @auth
        <div class="flex justify-end gap-4">
            <button onclick="Livewire.dispatch('openModal', { component: 'modals.modal-list-add', arguments: { app: '{{ $app }}', view: '.modals._lists-add', id: {{ $video->id }} }})" class="flex bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <x-heroicon-o-list-bullet class="h-6 w-6"/>
                <span class="ml-2">Add to Playlist</span>
            </button>
        
            @livewire('reactions.reactions-button', [
                'name' => 'favorite',
                'icon' => 'heart',
                'title' => 'Add Favorite',
                'activeTitle' => 'Favorited',
                'object_type' => 'App\Models\Video',
                'object_id' => $video->id
            ])
        </div>
    @endauth
</div> 