<?php

namespace App\Livewire\Videos;

use App\Livewire\InfiniteScroll;
use App\Services\VideoService;

class ArtistsList extends InfiniteScroll
{
    protected $videoService;
    
    public function boot(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }
    
    public function fetchData($page)
    {
        $this->pageNumber = $page;

        $data = $this->videoService->getArtists($page, $this->perPage);
        
        if (isset($data)) {
            $this->setData($page, $data);
        } 
    }

    public function mergeCollections($data) {
        $this->items = $this->items->merge($data['items'])->sortBy('name');
    }
    
    public function render()
    {
        return view('livewire.videos.artists-list');
    }
}
