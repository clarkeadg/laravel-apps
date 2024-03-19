<?php

namespace App\Livewire\Reactions;

use App\Livewire\InfiniteScroll;
use App\Services\ReactionService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class ReactionsList extends InfiniteScroll
{   
    public ?int $profile_id = null;

    protected $reactionService;

    protected $userService;
    
    public function boot(
        ReactionService $reactionService,
        UserService $userService
    )
    {
        $this->reactionService = $reactionService;
        $this->userService = $userService;
    }
    
    public function fetchData($page)
    {        
        $this->pageNumber = $page;

        if (isset($this->profile_id)) {
            $user = $this->userService->getById($this->profile_id);
        } else {
            $user = Auth::user();
        }

        $data = $this->reactionService->getList(
            $page,
            $this->perPage,
            $this->name,
            $this->object_type,
            $this->object_id,
            $user->id,
            $this->view
        );

        if (isset($data)) {
            $this->setData($page, $data);
        } 
    }
    
    public function render()
    {
        return view('livewire.reactions.reactions-list');
    }
}
