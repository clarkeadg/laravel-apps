<?php

namespace App\Services;

use App\Actions\Reactions\CreateReaction;
use App\Actions\Reactions\DeleteReaction;
use App\Models\Reaction;

class ReactionService
{
    // Create
    
    public function create($userId, $name, $object_type, $object_id)
    {       
        // $reaction = new Reaction;
        // $reaction->user_id = $userId;
        // $reaction->name = $name;
        // $reaction->object_type = $object_type;
        // $reaction->object_id = $object_id;
        // $reaction->save();

        // return $reaction;

        return CreateReaction::handle($userId, $name, $object_type, $object_id);
    }

    // Read

    public function get($userId, $name, $object_type, $object_id)
    {       
        return Reaction::where('user_id', $userId)
                        ->where('name', $name)
                        ->where('object_type', $object_type)
                        ->where('object_id', $object_id)
                        ->first();
    }    

    public function getById($id)
    {       
        return Reaction::where('id', $id)
                        ->first();
    }

    public function getUserReactions($userId, $name, $object_type)
    {       
        return Reaction::where('user_id', $userId)
                        ->where('name', $name)
                        ->where('object_type', $object_type)
                        ->get();
    }

    public function getList($page=1, $limit=10, $name, $object_type, $object_id, $userId, $view)
    {        
        $data = null;
        $count = 0;

        switch($view) {
            case 'me':
                $query = Reaction::where('object_id', $userId)
                                    ->where('name', $name) 
                                    ->where('object_type', $object_type);
            break;
            case 'profile':
                $query = Reaction::where('user_id', $object_id)
                                    ->where('name', $name) 
                                    ->where('object_type', $object_type);
            break;
            default:
                $query = Reaction::where('user_id', $userId)
                                    ->where('name', $name) 
                                    ->where('object_type', $object_type);
            break;
        }
        
        $count = $query->count();

        $data = $query
            ->with('object')
            //->with('object.profile_data.field')
            ->orderBy('id', 'desc')
            ->offset(($page-1)*$limit)
            ->limit($limit)
            ->get();
        
        return [
            'items' => $data,
            'count' => $count,
        ];
    }

    public function getCount($name, $object_type, $object_id)
    {       
        return Reaction::where('name', $name)
                        ->where('object_type', $object_type)
                        ->where('object_id', $object_id)
                        ->count();
    } 
    
    // Update

    // Delete

    public function delete($id)
    {       
        $reaction = $this->getById($id);
        // if(isset($reaction)) {
        //     $reaction->delete();
        // }

        // return null;

        return DeleteReaction::handle($reaction);
    }
}
