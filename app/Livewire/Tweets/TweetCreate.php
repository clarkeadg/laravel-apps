<?php

namespace App\Livewire\Tweets;

use App\Models\Tweet;
use App\Services\TweetService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On; 

class TweetCreate extends Component implements HasForms
{
    use WithFileUploads;
    use InteractsWithForms;

    public ?array $data = [
        'photos' => null
    ];

    public ?string $app = null;

    public ?int $id = null;

    public ?int $parent_id = null;

    public ?bool $redirect = false;

    public ?Tweet $tweet = null;

    public ?bool $showPhotoUpload = false;

    public ?string $content = null;


    protected $tweetService;

    public function boot(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    public function mount(): void
    {
        if (isset($this->id)) {
            $this->tweet = $this->tweetService->getById($this->id);
        }

        $initialData = [];

        if (isset($this->content)) {
            $initialData = [
                'content' => $this->content." ",
                'photos' => null
            ]; 
        }

        if (isset($this->tweet)) {
            $initialData = [
                'content' => $this->tweet->content,
                'photos' => null,
                'sensitive' => $this->tweet->sensitive
            ]; 
        }
        
        $this->form->fill($initialData);
    }

    public function togglePhotoUpload() {
        $this->showPhotoUpload = !$this->showPhotoUpload;
    }

    #[On('delete-tweet-photo')] 
    public function deletePhoto($id, $id2)
    {   
        $user = Auth::user();
        if (isset($user)) {
            $tweet = $this->tweetService->getById($id);
            if (isset($tweet) && $tweet->user_id == $user->id) {
                $this->tweetService->deletePhoto($id, $id2);            
            }
        }
    }
    
    public function form(Form $form): Form
    {      
        return $form
            ->schema([
                Textarea::make('content')
                    ->rows(5)
                    ->hiddenLabel()
                    ->required(),
                SpatieMediaLibraryFileUpload::make("photos")
                    ->hiddenLabel()
                    ->collection('photos')
                    ->disk('media')
                    ->multiple()
                    ->maxFiles(5)
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                        'video/mp4', 
                    ])
                    //->image()
                    ->live()
                    ->saveRelationshipsUsing(static function (SpatieMediaLibraryFileUpload $component) {
                        $component->saveUploadedFiles();
                    }),
                Checkbox::make('sensitive')
                    ->hidden(fn ($get): bool => ! $get('photos'))
                    ->label("Has sensitive content")
            ])
            ->statePath('data')
            ->model(Tweet::class);
    }

    public function create(): void
    {        
        $user = Auth::user();
        $state = $this->form->getState();

        $is_edit = false;

        if (isset($this->tweet)) {
            $is_edit = true;
            $this->tweet = $this->tweetService->update(
                $this->tweet->id,
                $state["content"],
                isset($state["sensitive"]) ? $state["sensitive"] : false,
            );
        } else {
            $this->tweet = $this->tweetService->create(
                $user->id,
                $state["content"],
                isset($state["sensitive"]) ? $state["sensitive"] : false,
                $this->parent_id
            );            
        }
        
        // save photos
        $this->form->model($this->tweet)->saveRelationships(); 

        // parse hashtags
        $this->tweetService->createHashTags($user->id, $this->tweet);      

        // parse mentions
        $this->tweetService->createMentions($this->tweet); 

        $tweetId = $this->tweet->id;

        $this->tweet = null;
        $this->data['photos'] = null;

        $this->form->fill([
            'photos' => null
        ]);

        $this->showPhotoUpload = false;

        $this->dispatch('closeModal');

        if ($this->redirect || $is_edit) {
            redirect()->route($this->app.'.tweet', $tweetId);
        }

        if ($this->parent_id) {
            redirect()->route($this->app.'.tweet', $this->parent_id);
        }
    }

    public function render()
    {
        return view('livewire.tweets.tweet-create');
    }
}
