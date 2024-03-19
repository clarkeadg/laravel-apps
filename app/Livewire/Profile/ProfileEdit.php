<?php

namespace App\Livewire\Profile;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Models\ProfileGroup;
use Livewire\Component;

class ProfileEdit extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public $group = "";

    public $group_id = null;

    public $fields = [];

    public $columns = 1;

    public $hideTitle = false;

    protected $userService;   
    
    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function mount(): void
    {
        $fields = [];
        $user = Auth::user();
        if (isset($user)) {
            $profileData = $this->userService->getProfileData($user);
             if (isset($profileData)) {
                foreach($profileData as $key => $values) {
                    $fields[$key] = $values['value'];            
                }
            }
        }
        $this->form->fill($fields);
    }

    private function makeSchema(ProfileGroup $group): Array {
        $schema = [];
        foreach($group->profile_fields as $field) {
            $this->fields[$field->id] = $field;
            if ($field->type == "textbox")
            {
                array_push($schema, 
                    TextInput::make("field_".$field->id)
                                ->label($field->title)
                );
            }
            if ($field->type == "textarea")
            {
                array_push($schema, 
                    Textarea::make("field_".$field->id)
                                ->label($field->title)
                );
            }
            if ($field->type == "datebox")
            {
                array_push($schema, 
                    DatePicker::make("field_".$field->id)
                                ->label($field->title)
                );
            }
            if ($field->type == "selectbox")
            {
                $options = [];

                foreach($field->options as $option) {
                    $key = isset($option['value']) ? $option['value'] : $option['name'];
                    $options[$key] = $option['name'];
                }

                array_push($schema, 
                    Select::make("field_".$field->id)
                            ->label($field->title)
                            ->options($options)
                );
            }
        }
        return $schema;
    }    

    public function form(Form $form): Form
    { 
        $schema = [];
        $group = $this->userService->getProfileGroup($this->group);
        if (isset($group)) {
            $this->group_id = $group->id;
            $schema = $this->makeSchema($group);
        }

        return $form
            ->schema($schema)
            ->columns($this->columns)
            ->statePath('data');
    }    

    public function create(): void
    {
        $user = Auth::user();
        if (isset($user)) {
            $state = $this->form->getState();
            $data = [];
            foreach($state as $key => $value) {
                $fieldId = (int) str_replace("field_", "", $key);
                if (isset($this->fields[$fieldId]) && $value) {
                    $field = $this->fields[$fieldId];
                    $data[$key] = [
                        'name' => $field->name,
                        'title' => $field->title,
                        'value' => $value
                    ];
                }                
            }
            $this->userService->createProfileData($user->id, $this->group_id, $data);
            $user->save();
        }
    }
    
    public function render()
    {
        return view('livewire.profile.profile-edit');
    }
}