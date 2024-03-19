<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;

class ModalDelete extends ModalComponent
{
    public ?string $app = null;

    public ?string $view = null;

    public ?string $name = null;

    public ?int $id = 0;

    public ?int $id2 = 0;
    
    public function handleDelete()
    {
        $this->dispatch($this->name, id: $this->id, id2: $this->id2);
        
        $this->closeModal();
    }
    
    public function render()
    {
        return view('apps.'.$this->app.".".$this->view);
    }
}
