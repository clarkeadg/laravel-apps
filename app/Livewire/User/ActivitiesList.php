<?php

namespace App\Livewire\User;

use App\Livewire\InfiniteScroll;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class ActivitiesList extends InfiniteScroll
{
    protected $userService;
    
    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function fetchData($page)
    {        
        $this->pageNumber = $page;

        $user = Auth::user();

        $data = $this->userService->getActivities(
            $user->id,
            $page,
            $this->perPage,
            $this->name,        
            $this->object_type,                        
            $this->view
        );

        if (isset($data)) {
            $this->setData($page, $data);
        } 
    }

    public function render()
    {
        return view('livewire.user.activities-list');
    }
}
