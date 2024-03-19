<?php

namespace App\Livewire\Tags;

use App\Livewire\InfiniteScroll;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use App\Services\TagService;

class TagsSearch extends InfiniteScroll
{
    protected $tagService;
    
    public function boot(TagService $tagService)
    {
        $this->tagService = $tagService;
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
        
        $data = $this->tagService->search(
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
        return view('livewire.tags.tags-search');
    }
}