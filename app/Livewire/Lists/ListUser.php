<?php

namespace App\Livewire\Lists;

use App\Models\ListItem;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\ListService;
use Livewire\Component;

class ListUser extends Component
{
    public ?string $app = null;

    public ?string $type = null;

    public ?int $id = null;

    public ?User $profile = null;

    public ?ListItem $item = null;

    protected $listService;   
    
    public function boot(ListService $listService)
    {
        $this->listService = $listService;
    }

    public function mount(): void
    {
        $this->fetchData();
    }

    public function fetchData()
    {   
        $user = Auth::user();
        if (isset($user)) {
            $this->item = $this->listService->getListItem(
                $user->id,
                $this->id,
                'App\Models\User',
                $this->profile->id
            );
        }
    }    

    public function onClick() {
        $user = Auth::user();
        if (!isset($this->item)) {
            $this->item = $this->listService->createItem(
                $user->id,
                $this->id,
                'App\Models\User',
                $this->profile->id
            );
            $this->dispatch('fetch-list');
        } else {
            $this->dispatch('delete-list-item', id: $this->item->id);
            $this->dispatch('delete-listsearch-item', id: $this->item->object_id);
        }       
    }
    
    public function render()
    {
        return view('livewire.lists.list-user');
    }
}
