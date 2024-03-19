<?php

namespace App\Livewire\Profile;

use App\Livewire\InfiniteScroll;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;

class ProfileSearch extends InfiniteScroll
{
    protected $userService;

    //public $perPage = 1;
    
    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function mount(): void
    {
        $initialData = [
            //"field_3" => ['Female'],
            //"field_4" => ['Caucasian'],
            //"field_20" => ['Black','Red'],
            //"field_26" => 'Blue',
            "hasPhoto" => true
        ];
        
        $user = Auth::user();
        if (isset($user)) {
            $metaKey = "SearchSettings-".$this->name;
            $meta = $this->userService->getMeta($user->id, $metaKey);  
            if (isset($meta)) {
                $initialData = (Array) json_decode($meta->meta_value);
            }
        }
        
        $this->form->fill($initialData);

        $this->fetchData(1);
    }

    public function fetchData($page)
    {        
        $this->pageNumber = $page;

        $state = $this->form->getState();

        $user = Auth::user();
        if (isset($user)) {
            $metaKey = "SearchSettings-".$this->name;            
            $this->userService->createMeta($user->id, $metaKey, json_encode($state)); 
        }

        $data = $this->userService->search(
            null,
            $page,
            $this->perPage,
            $state           
        );

        if (isset($data)) {
            $this->setData($page, $data);
        } 
    }    

    public function form(Form $form): Form
    {
        $searchForm = $this->userService->getSearchForm($this->name);

        $schema = [];
        $columns = 1;

        if (isset($searchForm)) {
            $columns+= count($searchForm->options);
            
            foreach($searchForm->options as $option) {
                $field = $this->userService->getProfileField($option['field_id']);
                if (isset($field)) {
                    $fieldOptions = [];
                    foreach($field->options as $opt) { 
                        $fieldOptions[$opt["name"]] = $opt["name"];
                    }
                    if ($option['search_mode'] == "is_one_of") {
                        array_push($schema, 
                            Select::make($field->name)                
                                ->label($field->title)
                                ->multiple()
                                ->options($fieldOptions)
                        );
                    } else {
                        array_push($schema, 
                            Select::make($field->name)                
                                ->label($field->title)
                                //->multiple()
                                ->options($fieldOptions)
                        );
                    } 
                }          
            }
        }

        array_push($schema, 
            Toggle::make("hasPhoto")                
                ->label("Has Photo")
                ->inline(false)
        );
        
        return $form
            ->schema($schema)
            ->columns($columns)
            ->statePath('data');
    }

    // public function form2(Form $form): Form
    // {
    //     $searchForm = $this->userService->getSearchForm($this->name);

    //     $schema = [];
    //     $columns = 1;

    //     if (isset($searchForm)) {
    //         $columns+= count($searchForm->options);
            
    //         foreach($searchForm->options as $option) {
    //             $field = $this->userService->getProfileField($option['field_id']);
    //             if (isset($field)) {
    //                 $fieldOptions = [];
    //                 foreach($field->options as $opt) { 
    //                     $fieldOptions[$opt["name"]] = $opt["name"];
    //                 }
    //                 if ($option['search_mode'] == "is_one_of") {
    //                     array_push($schema, 
    //                         Select::make("field_".$field->id)                
    //                             ->label($field->title)
    //                             ->multiple()
    //                             ->options($fieldOptions)
    //                     );
    //                 } else {
    //                     array_push($schema, 
    //                         Select::make("field_".$field->id)                
    //                             ->label($field->title)
    //                             //->multiple()
    //                             ->options($fieldOptions)
    //                     );
    //                 } 
    //             }          
    //         }
    //     }

    //     array_push($schema, 
    //         Toggle::make("hasPhoto")                
    //             ->label("Has Photo")
    //             ->inline(false)
    //     );
        
    //     return $form
    //         ->schema($schema)
    //         ->columns($columns)
    //         ->statePath('data');
    // }

    public function render()
    {  
        return view('livewire.profile.profile-search');
    }
}