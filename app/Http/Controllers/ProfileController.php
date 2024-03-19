<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $notificationService;

    protected $userService;

    public function __construct(
        NotificationService $notificationService,
        UserService $userService
    )
    {
        $this->notificationService = $notificationService;
        $this->userService = $userService;
    }

    public function show($name, $app, $view=".profile.show")
    {
        // get profile groups
        $profile_groups = $this->userService->getProfileGroups();
        
        // get profile
        $profile = $this->userService->getProfile($name);

        // get profile data
        $profile_data = $this->userService->getProfileData($profile);

        // create profile_view activity
        $user = Auth::user();
        if (isset($user) && isset($profile)) {
            if ($user->id != $profile->id) {

                // create user activity
                $this->userService->createActivity(
                    $user->id,
                    "viewed_profile",
                    "App\Models\User",
                    $profile->id
                );

                // create notification
                $this->notificationService->create(
                    $profile->id,
                    "viewed_profile",
                    "App\Models\User",
                    $user->id
                );
            }
        }

        // return the view
        return view('apps.'.$app.$view, [
            'app' => $app,
            'profile_groups' => $profile_groups,
            'profile_data' => $profile_data,
            'profile' => $profile,
        ]);
    }

    public function broadcast($app, $view=".broadcast.show")
    {
        // get profile groups
        $profile_groups = $this->userService->getProfileGroups();
        
        // get profile
        $user = Auth::user();
        $profile = $this->userService->getProfile($user->name);

        // get profile data
        $profile_data = $this->userService->getProfileData($profile);        

        // return the view
        return view('apps.'.$app.$view, [
            'app' => $app,
            'profile_groups' => $profile_groups,
            'profile_data' => $profile_data,
            'profile' => $profile,
        ]);
    }
}
