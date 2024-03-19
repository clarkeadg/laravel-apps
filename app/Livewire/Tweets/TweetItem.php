<?php

namespace App\Livewire\Tweets;

use Illuminate\Support\Facades\Auth;
use App\Services\TweetService;
use App\Models\Tweet;
use Livewire\Component;

class TweetItem extends Component
{
    public ?string $app = null;

    public ?Tweet $item = null;

    public ?bool $hideFooter = false;

    protected $tweetService;

    public function boot(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    public function handleTweetUpdatedEvent($data)
    {
        if (isset($data['tweet'])) {
            $this->getItem($data['tweet']['id']);
        }
    }

    public function getItem($id)
    {
        $this->item = $this->tweetService->getById($id);
    }

    public function repost($id)
    {
        $user = Auth::user();

        $tweet = Tweet::where('id', $id)->get()->first();
        if (isset($tweet)) {
            
            $reposted = Tweet::where('user_id', $user->id)
                                ->where('repost_id', $id)
                                ->get()->first();

            if (isset($reposted)) {
                $reposted->delete();
            } else {            
                $newTweet = Tweet::create([
                    'user_id' => $user->id,
                    'content' => $tweet->content,
                    'repost_id' => $id,
                ]);
            }
        }
    }

    protected function getListeners()
    {
        $listeners = [];        
        if (isset($this->item)) {
            $listeners = [
                "echo:Tweet.".$this->item->id.",TweetUpdated" => "handleTweetUpdatedEvent",
            ];
        }

        return $listeners;
    }

    public function render()
    {
        $reposter = null;
        $tweet = $this->item;        

        if (isset($tweet->repost_id)) {
            $reposter = $tweet->user;
            $tweet = $tweet->original;        
        } 
        
        return view('livewire.tweets.tweet-item',[
            'reposter' => $reposter,
            'tweet' => $tweet,
        ]);
    }
}
