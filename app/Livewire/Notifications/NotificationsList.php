<?php

namespace App\Livewire\Notifications;

use App\Livewire\InfiniteScroll;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class NotificationsList extends InfiniteScroll
{
    protected $notificationService;
    
    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function markAllRead()
    {
        $user = Auth::user();
        if (isset($user)) {
            $this->notificationService->markAllRead($user->id);
        }
        redirect()->route($this->app.'.notifications');
    }
    
    public function fetchData($page)
    {       
        $this->pageNumber = $page;

        $user = Auth::user();
        if (isset($user)) {
            $data = $this->notificationService->get(
                $user->id,
                $page,
                $this->perPage,
            );

            if (isset($data)) {
                $this->setData($page, $data);
            }
        }
    }

    public function render()
    {
        return view('livewire.notifications.notifications-list');
    }
}
