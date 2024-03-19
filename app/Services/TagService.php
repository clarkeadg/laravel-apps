<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\TagItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class TagService
{
    // Create

    public function create($name)
    {
        $tag = new Tag;
        $tag->name = $name;
        $tag->save();

        return $tag;
    }

    public function createItem($userId, $tagId, $object_type, $object_id)
    {
        $tagItem = new TagItem;
        $tagItem->user_id = $userId;
        $tagItem->tag_id = $tagId;
        $tagItem->object_type = $object_type;
        $tagItem->object_id = $object_id;
        $tagItem->save();

        return $tagItem;
    }

    // Read
    
    public function getByName($name)
    {       
        return Tag::where('name', $name)
                        ->first();
    }

    public function getItem($tagId, $object_type, $object_id)
    {
        return TagItem::where('tag_id', $tagId)
                        ->where('object_type', $object_type)
                        ->where('object_id', $object_id)
                        ->first();
    }

    public function getTrending($object_type, $limit=100)
    {
        return Tag::whereHas('items', function (Builder $query) use($object_type) {
                    $query->where('object_type', '=', $object_type);
                })
                ->withCount('items')
                ->orderBy('items_count', 'desc')
                ->limit($limit)
                ->get();
    }

    public function search($q, $page=1, $limit=10)
    {       
        $items = [];
        $count = 0;
        
        $data = Tag::search($q)
                    ->orderBy('id', 'desc')
                    ->paginate($limit, ['*'], $page);
        $items = new Collection($data->items());
        $count = $data->total(); 

        return [
            'items' => $items,
            'count' => $count,
        ];
    }

    // Update

    // Delete
}
