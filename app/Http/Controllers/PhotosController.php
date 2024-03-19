<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhotosController extends Controller
{
    public function storePhoto()
    {
        $user = Auth::user();
         
        $newPhoto = $user
            ->addMediaFromRequest('image')
            ->toMediaCollection('photos');

        if (!isset($user->photo_id)) {
            $user->photo_id = $newPhoto->id;
            $user->save();
        }

        return back();
    }

    public function setMainPhoto(Request $request)
    {        
        $photoId = $request->input('photo_id');
        $user = Auth::user();
        $photo = $user->getMedia('photos')->where('id', $photoId)->first();

        if (isset($photo)) {            
            $user->photo_id = $photoId;
            $user->save();
        }

        return redirect('/settings/photos');
    }

    public function deletePhoto(Request $request)
    {
        
        $photoId = $request->input('photo_id');
        $user = Auth::user();
        $user->deleteMedia($photoId);

        // remove photo attachement if was main photo
        if ($user->photo_id == (int)$photoId) {
            $user->photo_id = null;
            $user->save();
        }

        // try to set a new main photo
        // if (!$user->photo_id) {
        //     $newPhoto = $user->getFirstMedia('photos');
        //     if (isset($newPhoto)) {
        //         $user->photo_id = $newPhoto->id;
        //         $user->save();
        //     }           
        // }

        return redirect('/settings/photos');
    }
}
