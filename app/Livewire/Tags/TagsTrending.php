<?php

namespace App\Livewire\Tags;

use App\Services\TagService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class TagsTrending extends Component
{
    public ?string $app = null;
    
    public ?string $object_type = null;

    public ?Collection $items = null;

    public $limit = 100;

    protected $tagService;

    public function boot(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function mount(): void
    {
        $this->fetchData();
    }

    public function fetchData()
    {        
        $this->items = $this->tagService->getTrending($this->object_type, $this->limit);
    }    
    
    public function render()
    {
        return view('livewire.tags.tags-trending');
    }
}
