<?php

namespace App\Livewire\Lists;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Lists;
use App\Services\ListService;
use Livewire\Component;
use Livewire\Attributes\On; 

class ListEdit extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?string $app = null;

    public ?string $type = null;

    public ?int $id = null;

    public ?Lists $list = null;

    public ?Collection $items = null;

    protected $listService;   
    
    public function boot(ListService $listService)
    {
        $this->listService = $listService;
    }

    public function mount(): void
    {
        $this->fetchData();

        $initialData = [
            "name" => $this->list->name,
        ];
        
        $this->form->fill($initialData);
    }

    #[On('delete-list-item')] 
    public function deleteItem($id)
    {   
        $user = Auth::user();
        if (isset($user)) {
            $item = $this->listService->getListItemById($user->id, $id);
            if (isset($item)) {
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
                $this->listService->deleteItem($user->id, $id);
            }
        }
        $this->fetchData();
    }
    
    #[On('fetch-list')] 
    public function fetchData()
    {   
        $user = Auth::user();
        if (isset($user)) {
            $this->list = $this->listService->getList($user->id, $this->id);
            if (isset($this->list)) {
                $this->items = $this->listService->getListItems($user->id, $this->list->id);
            }
        }
    }    

    public function create(): void
    { 
        $user = Auth::user();
        $state = $this->form->getState();
        if (isset($user)) {
            $this->listService->update($user->id, $this->list->id, $state['name']);
            $this->fetchData();
            $this->dispatch('edit-list');
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
        return view('livewire.lists.list-edit');
    }
}
