<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;

class UsersController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * @OA\Get(
     *     path="/api/user/clarkeadg",
     *     tags={"Users"},
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function getUserByName($name)
    {       
        $user = $this->userService->getByName($name);

        if(!isset($user)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        return response()->json($user);
    }
}
