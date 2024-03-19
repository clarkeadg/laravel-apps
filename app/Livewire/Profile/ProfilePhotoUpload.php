<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On; 

class ProfilePhotoUpload extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [
        'photos' => null
    ];

    public ?string $app = null;

    public ?Collection $items = null;

    public function mount(): void
    {
        $this->form->fill([
            'photos' => null 
        ]);
        $this->fetchData();
    }

    #[On('fetch-profile-photos')] 
    public function fetchData()
    {   
        $user = Auth::user();

        $this->items = $user->photos;    
    }

    public function setMainPhoto($id = false) {
        $user = Auth::user();

        if (!$id) {
            $user->photo_id = null;
            $user->save();
            $this->dispatch('profile-photo-update');
            return; 
        }

        $photo = $user->getMedia('photos')->where('id', $id)->first();

        if (isset($photo)) {            
            $user->photo_id = $id;
            $user->save();
            $this->dispatch('profile-photo-update');
        }
    }

    public function setCoverPhoto($id = false) {
        $user = Auth::user();

        if (!$id) {
            $user->cover_photo_id = null;
            $user->save();
            $this->dispatch('profile-photo-update');
            return; 
        }

        $photo = $user->getMedia('photos')->where('id', $id)->first();

        if (isset($photo)) {            
            $user->cover_photo_id = $id;
            $user->save();
            $this->dispatch('profile-photo-update');
        }
    }

    #[On('delete-profile-photo')] 
    public function deletePhoto($id) {
        $user = Auth::user();        

        for($i=0;$i<count($this->items);$i++) {
            if(isset($this->items[$i])) {
                if ($this->items[$i]->id == $id) {
                    $this->items->forget($i);                    
                }
            }
        }    

        foreach($user->photos as $photo) {
            if ($photo->id == $id) {
                $photo->delete();
            }
        }

        // remove photo attachement if was main photo
        if ($user->photo_id == $id) {
            $user->photo_id = null;
            $user->save();
        }

        // remove cover photo attachement if was cover photo
        if ($user->cover_photo_id == $id) {
            $user->cover_photo_id = null;
            $user->save();
        }
    }

    public function form(Form $form): Form
    {      
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make("photos")
                    ->hiddenLabel()
                    ->collection('photos')
                    ->disk('media')
                    ->multiple()
                    ->maxFiles(5)
                    ->image()
                    //->live()
                    ->saveRelationshipsUsing(static function (SpatieMediaLibraryFileUpload $component) {
                        $component->saveUploadedFiles();
                    })
            ])
            ->statePath('data')
            ->model(User::class);
    }

    public function create(): void
    {        
        $user = Auth::user();
        $this->form->model($user)->saveRelationships(); 
        $this->form->fill([
            'photos' => null 
        ]);
        $this->fetchData();
        $this->dispatch('fetch-profile-photos');
    }    
    
    public function render()
    {
        return view('livewire.profile.profile-photo-upload');
    }
}
