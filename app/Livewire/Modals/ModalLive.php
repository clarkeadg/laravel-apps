<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;

class ModalLive extends ModalComponent
{
    public $id = 0;

    public ?string $app = null;

    public ?string $view = null;

    public static function modalMaxWidth(): string
    {
        return '3xl';
    }
   
    public function render()
    {
        return view('apps.'.$this->app.".".$this->view);
    }
}
