<?php

namespace App\Services;

use App\Services\ListService;
use App\Services\ReactionService;
use App\Services\TagService;
use App\Services\UserService;
use App\Models\Tweet;
use App\Models\Mention;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TweetService
{
    public function __construct(
        ListService $listService,
        ReactionService $reactionService,
        TagService $tagService,
        UserService $userService,
    )
    {
        $this->listService = $listService;
        $this->reactionService = $reactionService;
        $this->tagService = $tagService;
        $this->userService = $userService;
    }

    private function getFollowingIds($user)
    {
        $reactions = $this->reactionService->getUserReactions($user->id, 'follow', 'App\Models\User');
        $ids = [$user->id];
        if(isset($reactions)) {
            foreach($reactions as $reaction) {
                array_push($ids, $reaction->object_id);
            }
        }
        return $ids;
    }

    private function getPinIds($object_id)
    {
        $reactions = $this->reactionService->getUserReactions($object_id, 'pin', 'App\Models\Tweet');
        $ids = [];
        if(isset($reactions)) {
            foreach($reactions as $reaction) {
                array_push($ids, $reaction->object_id);
            }
        }
        return $ids;
    }

    // Create

    public function create($userId, $content="", $sensitive=false, $parent_id=null)
    {
        return Tweet::create([
            'user_id' => $userId,
            'content' => $content,
            'sensitive' => $sensitive,
            'parent_id' => $parent_id
        ]);
    }

    public function createHashTags($userId, $tweet)
    {
        preg_match_all('/#(\w+)/', $tweet->content, $hashtags);
        if (isset($hashtags) && isset($hashtags[1])) {
            foreach($hashtags[1] as $hashtag) {
                $tag = $this->tagService->getByName($hashtag);                
                if(!isset($tag)) {
                    $tag = $this->tagService->create($hashtag);
                }
                $tagItem = $this->tagService->getItem($tag->id, 'App\Models\Tweet', $tweet->id);
                if(!isset($tagItem)) {
                    $tagItem = $this->tagService->createItem(
                        $userId,
                        $tag->id,
                        'App\Models\Tweet',
                        $tweet->id
                    );
                }
            }
        } 
    }

    public function createMentions($tweet)
    {
        preg_match_all('/@(\w+)/', $tweet->content, $mentions);
        if (isset($mentions) && isset($mentions[1])) {
            foreach($mentions[1] as $mention) {
                $profile = $this->userService->getByName($mention);
                if(isset($profile)) {
                    $tweetMention = Mention::where('user_id', $profile->id)
                                            ->where('object_type', 'App\Models\Tweet')
                                            ->where('object_id', $tweet->id)
                                            ->first();
                    if(!isset($tweetMention)) {
                        $tweetMention = new Mention;
                        $tweetMention->user_id =  $profile->id;
                        $tweetMention->object_type = 'App\Models\Tweet';
                        $tweetMention->object_id = $tweet->id;
                        $tweetMention->save();
                    }
                }
            }
        }
    }

    // Read
    
    public function getById($id)
    {     
        return Tweet::where('id', $id)
                        ->with('user')
                        ->with('user.media')
                        ->with('parent')
                        ->first(); 
    }    

    public function getList($page=1, $limit=10, $name="", $object_type="", $object_id=0, $q="", $username="")
    {        
        $user = Auth::user();
        $title = null;
        $data = null;
        $count = 0; 

        switch($name) {
            case 'comments':
                $query = Tweet::where('parent_id', $object_id);
            break;
            case 'feed':
                if (isset($user)) {
                    $query = Tweet::whereIn('user_id', $this->getFollowingIds($user));
                } else {
                    $query = Tweet::where('user_id', ">", 0)
                                ->whereNull('parent_id');
                }
            break;
            case 'list':
                $list = $this->listService->getList($user->id, $object_id); 
                if (isset($list)) {
                    $title = $list->name;
                    $listItems = $this->listService->getListItems($user->id, $list->id); 
                }                               
                $userIds = [];
                if (isset($listItems)) {                    
                    foreach($listItems as $item) {
                        array_push($userIds, $item->object_id);
                    }
                }
                $query = Tweet::whereIn('user_id', $userIds);
            break;
            case 'pins':
                $query = Tweet::whereIn('id', $this->getPinIds($object_id));
            break;
            case 'profile':
                $query = Tweet::where('user_id', $object_id)
                                ->whereNull('parent_id')
                                ->whereNotIn('id', $this->getPinIds($object_id));
            break;
            case 'profile_replies':
                $query = Tweet::where('user_id', $object_id)
                                ->whereNotIn('id', $this->getPinIds($object_id));
            break;
            case 'profile_media':
                $query = Tweet::where('user_id', $object_id)
                                ->has('media');
            break;
            case 'search':                
                if ($q) {
                    return $this->search($q, $page, $limit, $username);
                } else {
                    $query = Tweet::where('id', '<', 1);
                }
            break;
            case 'tweet':
                $query = Tweet::where('id', $object_id);
            break;
            case 'tag':
                $tag = $this->tagService->getByName($object_type);
                if(isset($tag)) {
                    $query = Tweet::whereHas('tag_items', function (Builder $query) use($tag) {
                                        $query->where('tag_id', '=', $tag->id)
                                                ->where('object_type', '=', 'App\Models\Tweet');
                                    });
                } else {
                    $query = Tweet::where('user_id', "<", 0)
                                ->whereNull('parent_id');
                }
            break;            
            default:
                $query = Tweet::where('user_id', ">", 0)
                                ->whereNull('parent_id');
            break;
        }
        
        $count = $query->count();

        $data = $query
            ->with('user')
            ->with('user.media')
            ->with('parent')
            ->orderBy('id', 'desc')
            ->offset(($page-1)*$limit)
            ->limit($limit)
            ->get();
        
        return [
            'title' => $title,
            'items' => $data,
            'count' => $count,
        ];
    }
    
    public function search($q, $page=1, $limit=10, $username=null)
    {       
        $items = [];
        $count = 0;

        if(isset($username)) {
            $profile = $this->userService->getByName($username);
            if (isset($profile)) {
                $data = Tweet::search($q)
                                ->where('user_id', $profile->id)
                                ->orderBy('id', 'desc')
                                ->paginate($limit, ['*'], $page);
            }
        }

        if(!isset($data)) {       
            $data = Tweet::search($q)
                            ->orderBy('id', 'desc')
                            ->paginate($limit, ['*'], $page);
        }
        
        $items = new Collection($data->items());
        $count = $data->total();

        return [
            'items' => $items,
            'count' => $count,
        ];
    }

    // Update

    public function update($id, $content, $sensitive)
    {
        $tweet = $this->getById($id);
        if (isset($twee)) {
            $tweet->content = $content;
            $tweet->sensitive = $sensitive;
            $tweet->save();
        }

        return $tweet;
    }

    // Delete

    public function delete($id)
    {
        $tweet = $this->getById($id);
        if (isset($tweet)) {
            $tweet->delete();
        }
    }

    public function deletePhoto($tweetId, $photoId)
    {
        $tweet = $this->getById($tweetId);
        if (isset($tweet)) {
            foreach($tweet->photos as $photo) {
                if ($photo->id == $photoId) {
                    $photo->delete();
                }
            }
        }
    }
}
