<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Auth;
use App\Services\ReactionService;

class ModalMuteUser extends ModalComponent
{
    public $id = 0;

    public ?string $app = null;

    public ?string $view = null;

    protected $reactionService;

    public function boot(ReactionService $reactionService)
    {
        $this->reactionService = $reactionService;
    }
    
    public function handleMute()
    {
        $user = Auth::user();
        if (isset($user)) {  
            $reaction = $this->reactionService->get($user->id, 'mute', 'App\Models\User', $this->id);
            if(!isset($reaction)) {
                $reaction = $this->reactionService->create($user->id, 'mute', 'App\Models\User', $this->id);
            }            
        }
        
        $this->closeModal();

        redirect()->route($this->app.'.mutes');
    }
    
    public function render()
    {
        return view('apps.'.$this->app.".".$this->view);
    }
}
