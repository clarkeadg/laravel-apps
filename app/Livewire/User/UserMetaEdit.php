<?php

namespace App\Livewire\User;

use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use Livewire\Component;

class UserMetaEdit extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public $group = "Mail Settings";

    public ?array $fields = [
        "notification_activity_new_mention" => "Notifiy me when there is a new mention",
        "notification_activity_new_reply" => "Notifiy me when there is a new reply",
        "notification_messages_new_message" => "Notifiy me when there is a new message",
        "notification_friends_friendship_request" => "Notifiy me when there is a friend request",
        "notification_friends_friendship_accepted" => "Notifiy me when a friend accepted my request",
        "notification_groups_invite" => "Notifiy me when there is a group invite",
        "notification_groups_group_updated" => "Notifiy me a group is updated",
        "notification_groups_admin_promotion" => "Notifiy me a group has news",
        "notification_groups_membership_request" => "Notifiy me when there is a group membership request",
        "notification_membership_request_completed" => "Notifiy me when a group membership request is accepted",
        "notification_starts_following" => "Notifiy me when a member starts following me",        
    ];

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
            $meta = $this->userService->getMetas($user->id);            
            
            foreach($meta as $field) {
                if (isset($this->fields[$field->meta_key])) {
                    $fields[$field->meta_key] = ($field->meta_value == "1") ? true : false;
                }
            }
        }

        $this->form->fill($fields);
    }

    public function form(Form $form): Form
    {
        $fields = [];
        foreach($this->fields as $key => $value) {
            array_push($fields, Toggle::make($key)->label($value));
        }

        return $form
            ->schema($fields)
            ->statePath('data');
    }

    public function create(): void
    {
        $user = Auth::user();
        $state = $this->form->getState();

        foreach($state as $key => $value) {
            $this->userService->createMeta($user->id, $key, $value);
        }    
    }
    
    public function render()
    {
        return view('livewire.user.user-edit');
    }
}

