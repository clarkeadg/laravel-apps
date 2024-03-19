<?php

namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;
use App\Services\TweetService;
use App\Models\Tweet;

class ModalTweetPhotos extends ModalComponent
{
    public $id = 0;

    public ?string $app = null;

    public ?string $view = null;

    public ?Tweet $tweet = null;

    protected $tweetService;

    public function boot(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }
   
    public function mount(): void
    {
        if (isset($this->id)) {
            $this->tweet =  $this->tweetService->getById($this->id);
        }       
    }
   
    public function render()
    {
        return view('apps.'.$this->app.".".$this->view);
    }
}
