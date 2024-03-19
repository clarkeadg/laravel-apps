<?php

namespace App\Livewire\Messenger;

use App\Services\MessengerService;
use App\Services\UserService;
use App\Models\User;
use App\Events\MessageCreated;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class MessagesCreate extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?string $app = null;

    public ?string $name = null;

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
        $this->recipient = $this->userService->getByName($this->name);
    }

    public function create(): void
    {       
        if ($this->recipient->blocked_me) {
            return;
        }
        
        $user = Auth::user();
        if(isset($user)) {
            
            $thread = $this->messengerService->createThread();
            if(isset($thread)) {  
                
                $state = $this->form->getState();

                $message = $this->messengerService->createMessage($thread->id, $user->id, $state["message"]);

                $participant = $this->messengerService->createParticipant($thread->id, $user->id);

                if (isset($this->recipient)) {
                    $this->messengerService->addParticipant($this->recipient->id);
                }

                MessageCreated::dispatch($message);

                redirect()->route($this->app.'.messages.sent');
            }
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('message')->hiddenLabel()
            ])
            ->statePath('data');
    }

    public function render()
    {
        return view('livewire.messenger.messages-create');
    }
}
