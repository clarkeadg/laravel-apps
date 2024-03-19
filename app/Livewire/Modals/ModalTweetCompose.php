<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;

class ModalTweetCompose extends ModalComponent
{
    public $id = 0;

    public ?string $app = null;

    public ?string $view = null;

    public ?string $content = null;
      
    public function render()
    {
        return view('apps.'.$this->app.".".$this->view);
    }
}
