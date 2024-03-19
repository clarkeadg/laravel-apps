<?php

namespace App\Livewire\Messenger;

use App\Events\MessageCreated;
use App\Models\User;
use App\Services\MessengerService;
use App\Services\UserService;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Cmgmyr\Messenger\Models\Thread;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;

class MessagesThread extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?string $app = null;

    public ?int $threadId = null;

    public ?Thread $thread = null;

    public ?User $recipient = null;

    protected $messengerService;
    
    protected $userService; 
    
    public function boot(
        MessengerService $messengerService,
        UserService $userService
    )
    {
        $this->messengerService = $messengerService;

        $this->userService = $userService;
    }
    
    public function mount(): void
    {
        $this->fetchData();
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

    public function fetchData()
    {  
        $this->thread = $this->messengerService->getThreadById($this->threadId);

        if (isset($this->thread)) {
            $userId = Auth::id();
            $this->messengerService->markRead($this->thread, $userId);
            
            foreach($this->thread->participants as $user) {
                if ($user->user_id != $userId) {
                    $user = $this->userService->getById($user->user_id);
                    if (isset($user)) {
                        $this->recipient = $user;
                    }
                }
            }
        }
    }    

    public function create(): void
    {
        if ($this->recipient->blocked_me) {
            return;
        }
        
        $user = Auth::user();
        $state = $this->form->getState();

        $this->thread->activateAllParticipants();

        $message = $this->messengerService->createMessage($this->thread->id, $user->id, $state["message"]);

        $participant = $this->messengerService->createParticipant($thread->id, $user->id);

        $this->form->fill([]);

        $this->fetchData();

        MessageCreated::dispatch($message);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('message')->label("")
            ])
            ->statePath('data');
    }
    
    public function render()
    {
        return view('livewire.messenger.messages-thread');
    }
}
