<?php

namespace App\Livewire\Lists;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Services\ListService;
use App\Services\UserService;
use App\Services\VideoService;
use Livewire\Component;
use Livewire\Attributes\On; 

class ListSearch extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?string $app = null;

    public ?string $type = null;

    public ?int $id = null;

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

    #[On('delete-listsearch-item')] 
    public function deleteItem($id)
    {   
        if (isset($this->items)) {
            for($i=0;$i<count($this->items);$i++) {
                if(isset($this->items[$i])) {
                    if ($this->items[$i]->id == $id) {
                        $index = $i;
                    }
                }
            }
            if (isset($index)) {
                $this->items->forget($index);
            }
        }
    }
    
    #[On('fetch-list')] 
    public function fetchData()
    {   
        $this->items = null;
        
        $state = $this->form->getState();
        $q = $state['query'];

        if ($this->type == "users") {
            $data = $this->userService->search($q, 1, 5);
        }

        if ($this->type == "videos") {
            $data = $this->videoService->search($q, 1, 5, 'videos');
        }

        if (isset($data)) {
            $this->items = $data['items'];
        }
    }    

    public function create(): void
    { 
        $this->fetchData();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('query')->hiddenLabel()->required()
            ])
            ->statePath('data');
    }
    
    public function render()
    {
        return view('livewire.lists.list-search');
    }
}
