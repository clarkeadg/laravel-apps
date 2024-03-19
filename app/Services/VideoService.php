<?php

namespace App\Services;

use App\Models\Artist;
use App\Models\Category;
use App\Models\Lists;
use App\Models\Reaction;
use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class VideoService
{
    // Create

    // Read
    
    public function getArtists($page=1, $limit=20)
    {
        $query = Artist::whereHas('videos');
        
        $count = $query->count();

        $data = $query
                    ->orderBy('name')
                    ->offset(($page-1)*$limit)
                    ->limit($limit)
                    ->get();       

        return [
            'items' => $data,
            'count' => $count,
        ];
    }

    public function getArtistBySlug($slug)
    {
        return Artist::where('slug', $slug)
                        ->first();
    }

    public function getCategories($page=1, $limit=100)
    {
        $query = Category::whereHas('videos');
        
        $count = $query->count();

        $data = $query
                    ->orderBy('order')
                    ->offset(($page-1)*$limit)
                    ->limit($limit)
                    ->get();       

        return [
            'items' => $data,
            'count' => $count,
        ];
    }

    public function getCategoryBySlug($slug)
    {
        return Category::where('slug', $slug)
                            ->first();
    }

    public function getVideos($page=1, $limit=20, $object, $object_type=null)
    {
        switch($object_type) {
            case 'list':
                $query = $object->items();
            break;
            default:
                $query = $object->videos();
            break;
        }    
        
        $count = $query->count();

        $data = $query
                    ->orderBy('id', 'desc')
                    ->offset(($page-1)*$limit)
                    ->limit($limit)
                    ->get();       

        return [
            'items' => $data,
            'count' => $count,
        ];
    }

    public function getVideoById($id)
    {
        return Video::where('id', $id)->first();
    }

    public function getVideoBySlug($slug, $type=null, $id=null, $limit=10)
    {
        $video = Video::where('slug', $slug)->first();
        if (!isset($video)) {
            return null;
        }

        if ($type == "category" && isset($id)) {
            $category = Category::where('id', $id)->first();
        }
        
        if (!isset($category)) { 
            $category = $video->categories()->first();
        }

        $playlist = [];

        if ($type == "artist" && isset($id)) {
            $artist = Artist::where('id', $id)->first();
        }

        if ($type == "list" && isset($id)) {
            $user = Auth::user();
            if (isset($user)) {
                $list = Lists::where('id', $id)
                                ->where('user_id', $user->id)
                                ->first();
            }
        }

        if ($type == "favorite") {
            $user = Auth::user();
            if (isset($user)) {
                $reactions = Reaction::where('user_id', $user->id)
                                    ->where('name', 'favorite')
                                    ->where('object_type', 'App\Models\Video')
                                    ->orderBy("id", "desc")
                                    ->limit($limit)
                                    ->get();

                foreach($reactions as $item) {
                    array_push($playlist, $item->object);
                }
            }
        }

        if (isset($artist)) {
            $playlist = $artist->videos()
                ->orderBy("id", "desc")
                ->limit($limit)
                ->get();             

            $n = 10 - count($playlist);
            if ($n && isset($category)) {
                $playlist2 = $category->videos()
                    ->orderBy("id", "desc")
                    ->limit($n)
                    ->get();

                $playlist = $playlist->concat($playlist2);
            }
        }
        
        else if (isset($list)) {
            $listItems = $list->items()
                ->orderBy("id", "desc")
                ->limit($limit)
                ->get();
                
            foreach($listItems as $item) {
                array_push($playlist, $item->object);
            }
        } 
        
        else if (isset($category)) {
            if(!count($playlist)) {
                $playlist = $category->videos()
                    ->orderBy("id", "desc")
                    ->limit($limit)
                    ->get();
            }
        }

        return [
            'video' => $video,
            'category' => $category,
            'playlist' => $playlist,
        ];
    }

    public function search($q, $page=1, $limit=10, $type)
    {       
        $items = [];
        $count = 0;

        switch($type) {
            case 'artists':
                $data = Artist::search($q)
                                ->orderBy('id', 'desc')
                                ->paginate($limit, ['*'], $page);
                $items = new Collection($data->items());
                $count = $data->total();
            break;
            case 'videos':
                $data = Video::search($q)
                                ->orderBy('id', 'desc')
                                ->paginate($limit, ['*'], $page);
                $items = new Collection($data->items());
                $count = $data->total();
            break;
            default:
            break;
        }

        return [
            'items' => $items,
            'count' => $count,
        ];
    }

    // Update

    // Delete
}
