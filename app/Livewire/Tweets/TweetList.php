<?php

namespace App\Livewire\Tweets;

use App\Livewire\InfiniteScroll;
use App\Services\TweetService;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

class TweetList extends InfiniteScroll
{  
    public ?array $data = [];

    public $perPage = 5;

    public ?string $title = null;

    public ?string $icon = null;

    #[Url]
    public ?string $username = null;

    protected $tweetService;

    public function boot(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }
    
    public function handleTweetCreatedEvent($tweet)
    {
        $this->fetchData(1);
    }

    protected function getListeners()
    {
        $listeners = [
            "echo:Tweets,TweetCreated" => "handleTweetCreatedEvent",
        ];

        return $listeners;
    } 

    #[On('delete-tweet')] 
    public function deleteItem($id)
    {
        $user = Auth::user();
        if (isset($user)) {
            $tweet = $this->tweetService->getById($id);
            if (isset($tweet) && $tweet->user_id == $user->id) {
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
                $this->tweetService->delete($tweet->id);
            }
        }
    }

    public function fetchData($page)
    {        
        $this->pageNumber = $page;

        $state = $this->form->getState();

        $data = $this->tweetService->getList(
            $page,
            $this->perPage,
            $this->name,
            $this->object_type,
            $this->object_id,
            $state['query'],
            $this->username
        );

        if (isset($data)) {
            $this->setData($page, $data);

            if (isset($data['title'])) {
                $this->title = $data['title'];
            }
        } 
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('query')->hiddenLabel()
            ])
            ->statePath('data');
    }
    
    public function render()
    {
        return view('livewire.tweets.tweet-list');
    }
}
