<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TweetService;

class TweetsController extends Controller
{
    protected $tweetService;

    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }
    
     /**
     * @OA\Get(
     *     path="/api/tweet/1",
     *     tags={"Tweets"},
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function getTweetById($id)
    {       
        $tweet = $this->tweetService->getById($id);

        if(!isset($tweet)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        return response()->json($tweet);
    }
}
