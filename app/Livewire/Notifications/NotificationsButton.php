<?php

namespace App\Livewire\Notifications;

use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationsButton extends Component
{
    public ?string $app = null;

    public ?string $name = null;
    
    public ?string $object_type = null;

    public $pageNumber = 1;

    public $perPage = 5;

    public $count = 0;

    public ?Collection $items = null;

    protected $notificationService;

    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function mount(): void
    {
        $this->fetchData(1);        
    }

    public function fetchData($page)
    {        
        $this->pageNumber = $page;
        
        $user = Auth::user();
        if(isset($user)) {
            $data = $this->notificationService->get(
                $user->id,
                $page,
                $this->perPage,
            );

            if (isset($data)) {
                if (isset($data['count'])) {
                    $this->count = $data['count'];
                }
                if (isset($data['items'])) {
                    if ($page == 1) {
                        $this->items = $data['items'];
                    } else {
                        if (isset($this->items)) {
                            $this->items = $this->items->merge($data['items']);
                        } else {
                            $this->items = $data['items'];
                        }
                    }
                }
            }
        } 
    }

    public function handleNotificationCreatedEvent($notification)
    {
        $this->fetchData(1);
    }

    protected function getListeners()
    {
        $listeners = [
            "echo-private:Notifications.User." . auth()->user()->id . ",NotificationCreated" => "handleNotificationCreatedEvent",
        ];

        return $listeners;
    }

    public function hasMorePages()
    {
        return $this->count > ($this->pageNumber * $this->perPage);
    }

    public function loadMore()
    {
        $this->pageNumber += 1;
        $this->fetchData($this->pageNumber); 
    }

    public function render()
    {
        return view('livewire.notifications.notifications-button');
    }
}
