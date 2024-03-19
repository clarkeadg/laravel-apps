<?php

namespace App\Http\Controllers;

use App\Services\ListService;
use App\Services\VideoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    protected $tweetService;

    public function __construct(
        ListService $listService,
        VideoService $videoService
    )
    {
        $this->listService = $listService;
        $this->videoService = $videoService;
    }

    public function home($app)
    {
        // get data
        $categoriesData = $this->videoService->getCategories();
        
        $categories = [];        
        foreach($categoriesData['items'] as $category) {
            $data = $this->videoService->getVideos(1, 10, $category);
            if (isset($data)) {
                $categories[$category->slug] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'videos' => $data['items']
                ];
            }
        }

        // return the view
        return view('apps.'.$app.'.home', [
            'app' => 'topmusicvideos',
            'top' => isset($categories['top']) ? $categories['top'] : null,
            'categories' => $categories
        ]);
    }
    
    public function show(Request $request, $slug, $app)
    {
        $type = $request->query('type');
        $id = $request->query('id');
        
        // get data
        $data = $this->videoService->getVideoBySlug($slug, $type, $id);  
        if (!isset($data)) {
            return abort(404);
        }      

        // return the view
        return view('apps.'.$app.'.video.show', [
            'app' => $app,
            'video' => $data['video'],
            'category' => $data['category'],
            'playlist' => $data['playlist'],
            'object_type' => $type,
            'id' => $id
        ]);
    }

    public function artist($slug, $app)
    {
        // get data
        $artist = $this->videoService->getArtistBySlug($slug);

        // return the view
        return view('apps.'.$app.'.artists.show', [
            'app' => $app,
            'artist' => $artist
        ]);
    }

    public function categories($app)
    {
        // get data
        $data = $this->videoService->getCategories();

        // return the view
        return view('apps.'.$app.'.categories.index', [
            'app' => $app,
            'categories' => $data['items']
        ]);
    }

    public function category($slug, $app)
    {
        // get data
        $category = $this->videoService->getCategoryBySlug($slug);

        // return the view
        return view('apps.'.$app.'.categories.show', [
            'app' => $app,
            'category' => $category
        ]);
    }

    public function list($id, $app)
    {
        $user = Auth::user();
        
        // get data
        $list = $this->listService->getList($user->id, $id);

        // return the view
        return view('apps.'.$app.'.lists.show',[
            'app' => $app,
            'list' => $list
        ]);
    }
}
