<?php

namespace App\Services;

use App\Models\ListItem;
use App\Models\Lists;

class ListService
{
    // Create

    public function create($userId, $type, $name)
    {
        $list = Lists::create([
            'user_id' => $userId,
            'type' => $type,
            'name' => $name,
        ]);

        return $list;
    }

    public function createItem($userId, $listId, $object_type, $object_id)
    {
        $listItem = ListItem::create([
            'user_id' => $userId,
            'list_id' => $listId,
            'object_type' => $object_type,
            'object_id' => $object_id,
            'order' => 1,
        ]);

        return $listItem;
    }

    // Read

    public function getLists($userId, $type)
    {       
        return Lists::where('user_id', $userId)
                        ->where('type', $type)
                        ->orderBy('id', 'asc')                     
                        ->get();
    }

    public function getList($userId, $listId)
    {       
        return Lists::where('user_id', $userId)
                        ->where('id', $listId)                        
                        ->first();
    }    
    
    public function getListItems($userId, $listId)
    {       
        return ListItem::where('user_id', $userId)
                        ->where('list_id', $listId)                        
                        ->get();
    }

    public function getListItem($userId, $listId, $object_type, $object_id)
    {       
        return ListItem::where('user_id', $userId)
                        ->where('list_id', $listId)
                        ->where('object_type', $object_type)
                        ->where('object_id', $object_id)
                        ->first();
    }

    public function getListItemById($userId, $id)
    {       
        return ListItem::where('user_id', $userId)
                        ->where('id', $id)
                        ->first();
    }

    // Update

    public function update($userId, $listId, $name)
    {
        $list = $this->getList($userId, $listId);
        if (isset($list)) {
            $list->name = $name;
            $list->save();
        }
        return $list;
    }

    // Delete

    public function delete($userId, $id)
    {
        $list = Lists::where('user_id', $userId)
                            ->where('id', $id)
                            ->first();
        if (isset($list)) {
            $list->delete();
        }
    }

    public function deleteItem($userId, $id)
    {
        $listItem = ListItem::where('user_id', $userId)
                            ->where('id', $id)
                            ->first();
        if (isset($listItem)) {
            $listItem->delete();
        }

        return null;
    }
}
