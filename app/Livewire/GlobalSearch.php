<?php

namespace App\Livewire;

use App\Services\TagService;
use App\Services\TweetService;
use App\Services\UserService;
use App\Services\VideoService;
use Livewire\Component;

class GlobalSearch extends Component 
{
    public ?string $app = null;

    public $perPage = 5;

    public $categories = [
        //'Users' => [],
        //'Tweets' => [],
        //'Tags' => [],      
    ];

    public $showDropdown = false;

    public $q = '';

    public $totalCount = 0;

    protected $tagService;

    protected $tweetService;

    protected $userService;

    protected $videoService;

    public function boot(
        TagService $tagService,
        TweetService $tweetService,
        UserService $userService,
        VideoService $videoService
    )
    {
        $this->tagService = $tagService;
        $this->tweetService = $tweetService;
        $this->userService = $userService;
        $this->videoService = $videoService;
    }

    public function updatedQ($value)
    {
        $this->fetchData();
    }

    public function fetchData()
    {        
        $this->totalCount = 0;
        
        foreach($this->categories as $key => $values) {
            $this->categories[$key] = $this->fetchCategory($key);
        }

        if ($this->totalCount) {
            $this->showDropdown = true;
        }
    }

    public function fetchCategory($model)
    { 
        $q = $this->q;

        if (!$q) {
            return [
                'items' => null,
                'count' => 0
            ];
        }

        switch($model) {
            case 'Artists':
                $data = $this->videoService->search($q, 1, 5, 'artists');
            break;
            case 'Tags':
                $data = $this->tagService->search($q, 1, 5);
            break;
            case 'Tweets':
                $data = $this->tweetService->getList(1, 5, 'search', null, null, $q);
            break;
            case 'Videos':
                $data = $this->videoService->search($q, 1, 5, 'videos');
            break;
            default:
                $data = $this->userService->search2($q, 1, 5);
            break;
        }
        
        if (isset($data)) {        
            $count = $data['count'];
            $this->totalCount += $count;
            return $data;
        }

        return [
            'items' => [],
            'count' => 0
        ];
    }    

    public function create(): void
    {
        $this->fetchData();
    }   

    public function render()
    {
        return view('livewire.global-search');
    }
}
