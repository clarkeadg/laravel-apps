<?php

namespace App\Livewire\Messenger;

use Livewire\Component;

class MessagesButton extends Component
{
    public ?string $app = null;

    public function render()
    {
        return view('livewire.messenger.messages-button');
    }
}
