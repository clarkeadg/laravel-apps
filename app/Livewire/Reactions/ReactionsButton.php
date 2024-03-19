<?php

namespace App\Livewire\Reactions;

use App\Models\Reaction;
use App\Services\ReactionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReactionsButton extends Component
{
    public ?int $user_id = null;
    
    public ?string $name = null;

    public ?bool $showCount = false;

    public ?int $count = 0;

    public ?string $class = null;

    public ?string $icon = null;

    public ?string $title = null;

    public ?string $activeClass = null;

    public ?string $activeIcon = null;

    public ?string $activeTitle = null;

    public ?string $object_type = null;

    public ?int $object_id = null;

    public ?Reaction $reaction = null;

    protected $reactionService;

    public function boot(ReactionService $reactionService)
    {
        $this->reactionService = $reactionService;
    }

    public function mount(): void
    {
        if ($this->showCount) {
            $this->getCount();
        }

        $user = Auth::user();
        if (isset($user)) {
            $reaction = $this->reactionService->get($user->id, $this->name, $this->object_type, $this->object_id);
            if (isset($reaction)) {
                $this->reaction = $reaction;
            }
        }
    }

    public function handleReactionUpdatedEvent($reaction)
    {
        if ($this->showCount) {
            $this->getCount();
        }       
    }

    protected function getListeners()
    {
        $object_type = str_replace("App\\Models\\", "", $this->object_type);

        $listeners = [
            "echo:Reactions.".$this->name."-".$object_type."-".$this->object_id.",ReactionUpdated" => "handleReactionUpdatedEvent",
        ];        

        return $listeners;
    }    

    public function getCount() {
        $this->count = $this->reactionService->getCount($this->name, $this->object_type, $this->object_id);
    }

    public function onClick() {       
        $user = Auth::user();
        if (isset($user)) {
            if (!isset($this->reaction)) {
                $this->reaction = $this->reactionService->create($user->id, $this->name, $this->object_type, $this->object_id);
            } else {
                $this->reaction = $this->reactionService->delete($this->reaction->id);
            }

            if ($this->showCount) {
                $this->getCount();
            }
        }
    }
    
    public function render()
    {
        return view('livewire.reactions.reactions-button');
    }
}
