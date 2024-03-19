<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On; 

class ProfileAvatar extends Component
{
    public ?string $app = null;
    
    public ?User $profile = null;

    public function mount(): void
    {
        $this->fetchData();
    }
    
    #[On('profile-photo-update')] 
    public function fetchData()
    {   
        $this->profile = Auth::user();   
    }    
    
    public function render()
    {
        return view('livewire.profile.profile-avatar');
    }
}
