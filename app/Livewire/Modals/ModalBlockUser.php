<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use App\Services\ReactionService;

class ModalBlockUser extends ModalComponent
{
    public $id = 0;

    public ?string $app = null;

    public ?string $view = null;

    protected $reactionService;

    public function boot(ReactionService $reactionService)
    {
        $this->reactionService = $reactionService;
    }
    
    public function handleBlock()
    {
        $user = Auth::user();
        if (isset($user)) {  
            $reaction = $this->reactionService->get($user->id, 'block', 'App\Models\User', $this->id);
            if(!isset($reaction)) {
                $reaction = $this->reactionService->create($user->id, 'block', 'App\Models\User', $this->id);
            }            
        }
        
        $this->closeModal();

        redirect()->route($this->app.'.blocks');
    }
    
    public function render()
    {
        return view('apps.'.$this->app.".".$this->view);
    }
}
