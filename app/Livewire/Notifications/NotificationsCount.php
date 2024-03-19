<?php

namespace App\Livewire\Notifications;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

class NotificationsCount extends Component
{
    public ?int $count = null;

    protected $notificationService;

    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    
    public function mount(): void
    {
        $this->fetchData();
    }    

    public function fetchData()
    {
        $user = Auth::user();        
        if (isset($user)) {
            $this->count = $this->notificationService->getCount($user->id);
        } 
    }

    public function handleNotificationCreatedEvent($notification)
    {
        $this->fetchData();
    }

    protected function getListeners()
    {
        $listeners = [
            "echo-private:Notifications.User." . auth()->user()->id . ",NotificationCreated" => "handleNotificationCreatedEvent",
        ];

        return $listeners;
    }        
    
    public function render()
    {
        return view('livewire.notifications.notifications-count');
    }
}
