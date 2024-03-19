<?php

namespace App\Livewire\Notifications;

use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Services\NotificationService;
use Livewire\Component;

class NotificationsItem extends Component
{
    public ?string $app = null;
    
    public ?Notification $item = null;

    public ?string $size = null;

    protected $notificationService;

    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function readNotification($id)
    {
        $user = Auth::user();
        if (isset($user)) {
            $notification = $this->notificationService->markRead($user->id, $id);
            if (isset($notification)) {
                $this->gotoNotificationItem($notification);
            }
        }        
    }

    public function gotoNotificationItem($notification)
    {
        redirect()->route($this->app.'.members.show', $notification->object->name);
    }
    
    public function render()
    {
        return view('livewire.notifications.notifications-item');
    }
}
