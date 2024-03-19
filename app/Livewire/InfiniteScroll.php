<?php

namespace App\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InfiniteScroll extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?string $app = null;

    public ?string $view = null;

    public ?string $object_type = null;

    public ?int $object_id = null;

    public $object;

    public $name = "";

    public $pageNumber = 1;

    public $perPage = 20;

    public $count = 0;

    public ?Collection $items = null;

    public function mount(): void
    {
        //$this->tweetService = app(TweetService::class);
        
        $this->fetchData(1);
    }

    public function hasMorePages ()
    {
        return $this->count > ($this->pageNumber * $this->perPage);
    }

    public function loadMore()
    {
        $this->pageNumber += 1;
        $this->fetchData($this->pageNumber); 
    }

    public function fetchData($page)
    {        
        $this->pageNumber = $page;

        $data = [];
            
        $this->setData([
            'items' => $data,
            'count' => 0
        ]);
    }

    public function setData($page, $data)
    {
        if (isset($data['count'])) {
            $this->count = $data['count'];
        }
        if (isset($data['items'])) {
            if ($page == 1) {
                $this->items = $data['items'];
            } else {
                if (isset($this->items)) {
                    $this->mergeCollections($data);
                } else {
                    $this->items = $data['items'];
                }
            }
        }        
    }
    
    public function mergeCollections($data) {
        $this->items = $this->items->merge($data['items'])->sortByDesc('id');
    }

    public function form(Form $form): Form
    {        
        return $form
            ->schema([])
            ->statePath('data');
    }    

    public function create(): void
    {
        $this->fetchData(1);
    }
    
    public function render()
    {  
        return view('livewire.search-members');
    }
}