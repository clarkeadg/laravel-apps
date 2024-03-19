<?php

namespace App\Livewire\Lists;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;
use App\Models\Video;
use App\Services\ListService;
use App\Services\UserService;
use App\Services\VideoService;
use Livewire\Component;

class ListAdd extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?string $app = null;

    public ?string $type = null;

    public ?int $id = null;

    public ?User $profile = null;

    public ?Video $video = null;

    public ?Collection $items = null;

    protected $listService;
    
    protected $userService;

    protected $videoService;   
    
    public function boot(
        ListService $listService,
        UserService $userService,
        VideoService $videoService
    )
    {
        $this->listService = $listService;
        $this->userService = $userService;
        $this->videoService = $videoService;
    }

    public function mount(): void
    {
        $this->fetchData();
    }
    
    public function fetchData()
    {   
        $user = Auth::user();

        if ($this->type == "users") {
            $this->profile = $this->userService->getById($this->id);
        }

        if ($this->type == "videos") {
            $this->video = $this->videoService->getVideoById($this->id);
        }

        if (isset($user)) {
            $this->items = $this->listService->getLists($user->id, $this->type); 
        }   
    }    

    public function create(): void
    { 
        $user = Auth::user();
        $state = $this->form->getState();

        if (isset($user)) {
            $this->listService->create($user->id, $this->type, $state['name']);
            $this->fetchData();
        }        
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->hiddenLabel()->required()
            ])
            ->statePath('data');
    }
    
    public function render()
    {
        return view('livewire.lists.list-add');
    }
}

