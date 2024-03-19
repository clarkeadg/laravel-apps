<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VideoService;

class VideosController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    /**
     * @OA\Get(
     *     path="/api/videos/artists",
     *     tags={"Videos"},
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function getArtists(Request $request)
    {       
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        
        $data = $this->videoService->getArtists($page, $limit);

        if(!isset($data)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        return response()->json($data);
    }
    
    /**
     * @OA\Get(
     *     path="/api/videos/categories",
     *     tags={"Videos"},
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function getCategories()
    {       
        $data = $this->videoService->getCategories();

        if(!isset($data)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        return response()->json($data['items']);
    }

    /**
     * @OA\Get(
     *     path="/api/videos/artist/avril-lavigne",
     *     tags={"Videos"},
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function getVideosByArtist(Request $request, $slug)
    {       
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        
        $artist = $this->videoService->getArtistBySlug($slug);

        if(!isset($artist)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        $data = $this->videoService->getVideos($page, $limit, $artist, 'artist');

        if(!isset($data)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        return response()->json($data);
    }

    /**
     * @OA\Get(
     *     path="/api/videos/category/top",
     *     tags={"Videos"},
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function getVideosByCategory(Request $request, $slug)
    {       
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        
        $category = $this->videoService->getCategoryBySlug($slug);
        
        if(!isset($category)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        $data = $this->videoService->getVideos($page, $limit, $category);

        if(!isset($data)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        return response()->json($data);
    }

    /**
     * @OA\Get(
     *     path="/api/videos/video/girlfriend-avril-lavigne",
     *     tags={"Videos"},
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function getVideoBySlug(Request $request, $slug)
    {       
        $type = $request->input('type');
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        
        $data = $this->videoService->getVideoBySlug($slug, $type, $id, $limit);
        
        if(!isset($data)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        return response()->json($data);
    }

    /**
     * @OA\Get(
     *     path="/api/videos/search",
     *     tags={"Videos"},
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function searchVideos(Request $request)
    {       
        $q = $request->input('q', "");

        if($q) {
            $data = $this->videoService->search($q, 1, 5, 'videos');
        }

        if(!isset($data)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        return response()->json($data);
    }

    /**
     * @OA\Get(
     *     path="/api/videos/search/artists",
     *     tags={"Videos"},
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function searchArtists(Request $request)
    {       
        $q = $request->input('q', "");

        if($q) {
            $data = $this->videoService->search($q, 1, 5, 'artists');
        }

        if(!isset($data)) {
            return response()->json([
                "message" => "Not Found"
            ], 404);
        }

        return response()->json($data);
    }
}
