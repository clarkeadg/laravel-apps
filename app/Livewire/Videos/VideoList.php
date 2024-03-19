<?php

namespace App\Livewire\Videos;

use App\Livewire\InfiniteScroll;
use App\Services\VideoService;

class VideoList extends InfiniteScroll
{
    protected $videoService;
    
    public function boot(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }
    
    public function fetchData($page)
    {
        $this->pageNumber = $page;

        $data = $this->videoService->getVideos($page, $this->perPage, $this->object, $this->object_type);
        
        if (isset($data)) {
            $this->setData($page, $data);
        } 
    }

    public function render()
    {
        return view('livewire.videos.video-list');
    }
}
