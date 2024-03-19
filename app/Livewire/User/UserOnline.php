<?php

namespace App\Livewire\User;

use Livewire\Component;

class UserOnline extends Component
{
    public $userId = null;
    
    public $online = null;

    public function getListeners()
    {
        return [
            //Presence Channel
            "echo-presence:UsersOnline,here"    => 'here',
            "echo-presence:UsersOnline,joining" => 'joining',
            "echo-presence:UsersOnline,leaving" => 'leaving',
        ];
    }

    public function here($users)
    {
        foreach($users as $user) {
            if ($user["id"] == $this->userId) {
                $this->online = true;
            }
        }
    }

    public function joining($user)
    {
        if ($user["id"] == $this->userId) {
            $this->online = true;
        }        
    }

    public function leaving($user)
    {
        if ($user["id"] == $this->userId) {
            $this->online = false;
        }        
    }
    
    public function render()
    {
        return view('livewire.user.user-online');
    }
}
