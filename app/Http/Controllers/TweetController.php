<?php

namespace App\Http\Controllers;

use App\Services\TweetService;

class TweetController extends Controller
{
    protected $tweetService;

    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }
    
    public function show($id, $app)
    {       
        // get tweet
        $tweet = $this->tweetService->getById($id);

        // return the view
        return view('apps.'.$app.'.tweet.show', [
            'app' => $app,
            'id' => $id,
            'tweet' => $tweet
        ]);
    }
}
