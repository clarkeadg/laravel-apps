<?php

namespace App\Livewire\Chat;

use App\Events\ChatMessageCreated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Livewire\Attributes\On;

class ChatRoom extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?string $app = null;

    public ?string $roomName = null;

    public $user = null;

    public $messages = [];

    public $users = [];

    public function mount(): void
    {
        $user = Auth::user();
        if(isset($user)) {
            $this->user = $user;
        }

        $messages = Redis::get('chat:room:'.$this->roomName);
        if (isset($messages)) {
            $this->messages = json_decode($messages, true);
        }
    }

    protected function getListeners()
    {
        $listeners = [
            //Presence Channel
            "echo-presence:ChatRoom.".$this->roomName.",here"    => 'here',
            "echo-presence:ChatRoom.".$this->roomName.",joining" => 'joining',
            "echo-presence:ChatRoom.".$this->roomName.",leaving" => 'leaving',
            // Chat Channel
            "echo:ChatMessage.".$this->roomName.",ChatMessageCreated"    => 'message',
        ];        

        return $listeners;
    }

    public function here($users)
    {
        foreach($users as $user) {
            array_push($this->users, $user["name"]);
        }
    }

    public function joining($user)
    {
        // add user
        if (!in_array($user['name'], $this->users)) {
            array_push($this->users, $user['name']);

            // create message
            $this->newMessage($user['name'], 'status', "joined the room");
        }     
    }

    public function leaving($user)
    {
        // remove user 
        $this->users = array_filter($this->users, static function($element) use($user) {
            return $element !== $user['name'];
        });

        // create message
        $this->newMessage($user['name'], 'status', "left the room");        
    }

    public function message($event) {
        $this->newMessage($event['message']['username'], 'user', $event['message']['message']);
    }

    public function newMessage($username, $type, $message) {
        array_push($this->messages, [
            'username' => $username,
            'type' => $type,
            'message' => $message
        ]);
    }

    public function create(): void
    {       
        // get form state
        $state = $this->form->getState();

        // create message
        ChatMessageCreated::dispatch([
            'username' => $this->user->name,
            'roomName' => $this->roomName,
            'message' => $state['message']
        ]);

        $messages = [];
        $oldMessages = Redis::get('chat:room:'.$this->roomName);
        if (isset($oldMessages)) {
            $messages = json_decode($oldMessages, true);
        }

        array_push($messages, [
            'username' => $this->user->name,
            'type' => 'user',
            'message' => $state['message']
        ]);

        Redis::set('chat:room:'.$this->roomName, json_encode($messages), 'EX', 60*60*24*7);

        // reset form
        $this->form->fill([]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('message')
                    ->hiddenLabel()
                    ->required()
                    ->autocomplete(false)
            ])
            ->statePath('data');
    }

    public function render()
    {
        return view('livewire.chat.chat-room');
    }
}
