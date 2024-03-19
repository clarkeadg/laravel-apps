<?php

namespace App\Livewire\Messenger;

use App\Livewire\InfiniteScroll;
use App\Services\MessengerService;
use Illuminate\Support\Facades\Auth;

class MessagesList extends InfiniteScroll
{
    protected $messengerService;   
    
    public function boot(MessengerService $messengerService)
    {
        $this->messengerService = $messengerService;
    }
    
    public function fetchData($page)
    {        
        $this->pageNumber = $page; 
        
        $user = Auth::user();
        if (isset($user)) {
            $data = $this->messengerService->getList($user->id);

            if (isset($data)) {
                $this->setData($page, $data);
            } 
        }
    }

    public function handleMessageCreatedEvent($message)
    {
        $this->fetchData(1);
    }

    protected function getListeners()
    {
        $listeners = [
            "echo-private:Messages.User." . auth()->user()->id . ",MessageCreated" => "handleMessageCreatedEvent",
        ];

        return $listeners;
    }

    public function render()
    {
        return view('livewire.messenger.messages-list');
    }
}
