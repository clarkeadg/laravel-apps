<?php

namespace App\Livewire\Lists;

use App\Models\ListItem;
use App\Services\ListService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListButton extends Component
{
    public ?string $app = null;

    public ?int $id = null;

    public ?string $object_type = null;

    public ?int $object_id = null;

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
                $this->object_type,
                $this->object_id
            );
        }
    }    

    public function onClick() {
        $user = Auth::user();
        if (isset($user)) {
            if (!isset($this->item)) {
                $this->item = $this->listService->createItem(
                    $user->id,
                    $this->id,
                    $this->object_type,
                    $this->object_id
                );            
            } else {
                $this->item =  $this->listService->deleteItem($user->id, $this->item->id);
            }
        }
    }

    public function render()
    {
        return view('livewire.lists.list-button');
    }
}
