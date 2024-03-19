<?php

namespace App\Livewire\Lists;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Services\ListService;
use Livewire\Component;
use Livewire\Attributes\On; 

class ListCreate extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?string $app = null;

    public ?string $type = null;

    public ?Collection $items = null;

    protected $listService;   
    
    public function boot(ListService $listService)
    {
        $this->listService = $listService;
    }

    public function mount(): void
    {
        $this->fetchData();
    }

    #[On('edit-list')] 
    public function fetchData()
    {   
        $user = Auth::user();
        if (isset($user)) {
            $this->items = $this->listService->getLists($user->id, $this->type);
        }
    }    

    #[On('delete-list')] 
    public function deleteItem($id)
    {
        $user = Auth::user();
        if (isset($user)) {
            $this->listService->delete($user->id, $id);
            $this->fetchData();            
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
        return view('livewire.lists.list-create');
    }
}
