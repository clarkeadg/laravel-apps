<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ProfileData;
use App\Models\ProfileField;
use App\Models\ProfileGroup;
use App\Models\SearchForm;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserMeta;

class UserService
{
    // Create

    public function createActivity($userId, $name, $object_type, $object_id)
    {
        $activity = UserActivity::updateOrCreate([
            "user_id" => $userId,
            "name" => $name,
            "object_type" => $object_type,
            "object_id" => $object_id
        ], [
            "user_id" => $userId,
            "name" => $name,
            "object_type" => $object_type,
            "object_id" => $object_id
        ]);

        return $activity;
    }

    public function createMeta($userId, $key, $value)
    {
        $meta = UserMeta::updateOrCreate([
            "user_id" => $userId,
            "meta_key" => $key,
        ], [
            "user_id" => $userId,
            "meta_key" => $key,
            "meta_value" => $value
        ]);

        return $meta;
    }

    public function createProfileData($userId, $groupId, $data)
    {
        $profileData = ProfileData::where('user_id',$userId)->first();
        if (isset($profileData)) {
            if (!isset($profileData->values)) {
                $profileData->values = [];
            }
            $values = $profileData->values;
            foreach($data as $k => $v) {
                if ($v) {
                    $values[$k] = $v;
                }
            }  
            $profileData->values = $values;         
            $profileData->save();
        } else {
            $profileData = ProfileData::create([
                'user_id' => $userId,
                'values' => $data
            ]);
        }

        return $profileData;
    }

    // Read
    
    public function getById($id)
    {       
        return User::where('id', $id)
                        ->with('media')
                        ->first();
    }
    
    public function getByName($name)
    {       
        return User::where('name', $name)
                        ->with('media')
                        ->first();
    }

    public function getProfile($name)
    {
        return User::where('name', $name)
                        ->with('media')
                        ->with('profile_data')
                        ->first();
    }

    public function getProfileData($profile, $groupId=null)
    {
        $profile_data = [];

        foreach($profile->profile_data as $data) {
            foreach($data->values as $key => $value) {
                $profile_data[$key] = $value;
            }
        }

        return $profile_data;
    }

    public function getProfileGroups()
    {
        $profile_groups_data = ProfileGroup::with('profile_fields')->get();
        $profile_groups = [];
        foreach($profile_groups_data as $profile_group) {
            $profile_groups[$profile_group->name] = $profile_group->profile_fields; 
        }

        return $profile_groups;
    }

    public function getProfileGroup($name)
    {
        return ProfileGroup::with('profile_fields')
                            ->where('name', $name)
                            ->first();
    }

    public function getProfileField($id)
    {
        return ProfileField::where('id', $id)
                            ->first();
    }

    public function getSearchForm($name)
    {
        return SearchForm::where('name', $name)
                            ->first();
    }

    public function search($q="", $page=1, $limit=10, $state=null)
    {       
        $items = [];
        $count = 0; 
        
        //dd($state);

        $query = User::search($q);

        if (isset($state['hasPhoto']) && $state['hasPhoto']) {
            $query = $query->where('hasPhoto', true);
        }

        if (isset($state)) {
            foreach($state as $key => $value) {
                if ($key != 'hasPhoto' && count($value)) {
                    $newKey = str_replace(" ", "_", $key);
                    $query = $query->whereIn(
                        $newKey, $value
                    );
                }
            }
        }

        $data = $query->orderBy('id', 'desc')
                        ->paginate($limit, ['*'], $page);
        
        $items = new Collection($data->items());
        $count = $data->total(); 

        return [
            'items' => $items,
            'count' => $count,
        ];
        
        //dd($state);
        
        // $query = User::where('id', '<', 1);
        
        // if ($q) {
        //     $query = User::where('name', 'LIKE', "%".$q."%"); 
        // }
        
        // if (isset($state)) {
        //     $query = User::whereNot('id', 0);

        //     if (isset($state["hasPhoto"]) && $state["hasPhoto"]) {
        //         $query = $query->whereNotNull('photo_id');
        //     }
    
        //     foreach($state as $key => $value) {
        //         if ($key != "hasPhoto" && $value) {
        //             $query = $query
        //                 ->whereHas('profile_data', function (Builder $query) use($key, $value) {
        //                     $jsonKey = "values->".$key."->value";
        //                     if (is_array($value)) {
        //                         for($i=0;$i<count($value);$i++) {
        //                             if ($i < 1) {
        //                                 $query = $query->where($jsonKey, '=', $value[$i]);
        //                             } else {
        //                                 $query = $query->orWhere($jsonKey, '=', $value[$i]);
        //                             }
        //                         }
        //                     } else {
        //                         $query = $query->where($jsonKey, '=', $value);
        //                     }
        //                 });
        //         }
        //     }
        // }

        // $count = $query->count();

        // $data = $query
        //     ->with('media')
        //     ->with('profile_data')
        //     ->orderBy('id', 'desc')
        //     ->offset(($page-1)*$limit)
        //     ->limit($limit)
        //     ->get(); 

        // return [
        //     'items' => $data,
        //     'count' => $count,
        // ];
    }

    public function search2($q, $page=1, $limit=10)
    {       
        $items = [];
        $count = 0;
        
        $data = User::search($q)
                        ->orderBy('id', 'desc')
                        ->paginate($limit, ['*'], $page);

        $items = new Collection($data->items());
        $count = $data->total(); 

        return [
            'items' => $items,
            'count' => $count,
        ];
    }

    public function getActivities($userId, $page=1, $limit=10, $name, $object_type, $view)
    {       
        switch($view) {
            case 'me';
                $query = UserActivity::where('object_id', $userId)
                                        ->where('name', $name) 
                                        ->where('object_type', $object_type);
            break;
            default:
                $query = UserActivity::where('user_id', $userId)
                                        ->where('name', $name) 
                                        ->where('object_type', $object_type);
            break;
        }

        $count = $query->count();

        $data = $query
            ->with(['user.profile_data.field', 'user.media','object.profile_data.field','object.media'])
            ->orderBy('id', 'desc')
            ->offset(($page-1)*$limit)
            ->limit($limit)
            ->get();

        return [
            'items' => $data,
            'count' => $count,
        ];
    }

    public function getMetas($userId)
    {
        return UserMeta::where('user_id', $userId)
                        ->get();
    }

    public function getMeta($userId, $key)
    {
        return UserMeta::where('user_id', $userId)
                        ->where('meta_key', $key)
                        ->first();
    }    

    // Update

    // Delete
}
