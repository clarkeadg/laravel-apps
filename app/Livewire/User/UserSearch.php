<?php

namespace App\Livewire\User;

use App\Livewire\InfiniteScroll;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use App\Services\UserService;

class UserSearch extends InfiniteScroll
{
    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function mount(): void
    {
        $initialData = [
            'q' => ''
        ];
              
        $this->form->fill($initialData);
    }
    
    public function fetchData($page)
    {        
        $this->pageNumber = $page;

        $state = $this->form->getState();
        
        $data = $this->userService->search(
            $state['q'],
            $page,
            $this->perPage,
        );

        if (isset($data)) {
            $this->setData($page, $data);
        }
    }    

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('q')->hiddenLabel()
            ])
            ->statePath('data');
    }

    public function render()
    {  
        return view('livewire.user.user-search');
    }
}