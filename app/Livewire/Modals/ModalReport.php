<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;

class ModalReport extends ModalComponent
{
    public ?string $app = null;

    public ?string $view = null;

    public ?int $id = null;

    public ?string $object_type = null;

    public ?int $object_id = null;
    
    public function render()
    {  
        return view('apps.'.$this->app.".".$this->view);
    }
}
