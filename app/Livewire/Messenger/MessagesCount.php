<?php

namespace App\Livewire\Messenger;

use Livewire\Component;
use Livewire\Attributes\On; 
use Illuminate\Support\Facades\Auth;
use App\Services\MessengerService;

class MessagesCount extends Component
{
    public ?int $count = null;

    protected $messengerService;   
    
    public function boot(MessengerService $messengerService)
    {
        $this->messengerService = $messengerService;
    }

    public function mount(): void
    {        
        $this->getCount();  
    }

    public function getCount()
    {
        $this->setCount(
            $this->messengerService->getUnreadCount()
        );
    }

    #[On('messages-count')]
    public function setCount($count)
    {
        $this->count = $count;
    }

    protected function getListeners()
    {
        $listeners = [
            "echo-private:Messages.User." . auth()->user()->id . ",MessageCreated" => "getCount",
        ];

        return $listeners;
    }      
    
    public function render()
    {
        return view('livewire.messenger.messages-count');
    }
}

