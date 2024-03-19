<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReactionService;

class ReactionsController extends Controller
{
    protected $reactionService;

    public function __construct(ReactionService $reactionService)
    {
        $this->reactionService = $reactionService;
    }
    
    /**
     * @OA\Get(
     *     path="/api/reaction/like/tweet/1",
     *     tags={"Reactions"},
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function getReaction($name, $type, $id)
    {
        $userId = 1;
        $type = 'App\\Models\\'.ucfirst($type);
        
        $reaction = $this->reactionService->get($userId, $name, $type, $id);

        if(!isset($reaction)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        return response()->json($reaction);
    }

    /**
     * @OA\Get(
     *     path="/api/reaction/count/like/tweet/1",
     *     tags={"Reactions"},
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function getReactionCount($name, $type, $id)
    {
        $type = 'App\\Models\\'.ucfirst($type);
        
        $count = $this->reactionService->getCount($name, $type, $id);

        if(!isset($count)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        return response()->json(['count' => $count]);
    }
}
