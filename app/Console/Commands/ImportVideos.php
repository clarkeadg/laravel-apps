<?php

namespace App\Console\Commands;

use App\Models\Artist;
use App\Models\Category;
use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import videos from itunes and youtube';

    private $genres = [
        [ "name" => "Top", "slug" => "top", "itid" => null ],
        [ "name" => "Pop", "slug" => "pop", "itid" => "1614" ],
        [ "name" => "Rock", "slug" => "rock", "itid" => "1621" ],
        [ "name" => "Alternative", "slug" => "alternative", "itid" => "1620" ],
        [ "name" => "Country", "slug" => "country", "itid" => "1606" ],
        [ "name" => "Dance", "slug" => "dance", "itid" => "1617" ],
        [ "name" => "Electronic", "slug" => "electronic", "itid" => "1607" ],
        [ "name" => "Rap", "slug" => "rap", "itid" => "1618" ],
        [ "name" => "Latino", "slug" => "latino", "itid" => "1612" ],
        [ "name" => "Soul", "slug" => "soul", "itid" => "1615"]
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $i = 0;
        $j = 0;
        foreach ($this->genres as $genre) {
            $category = Category::where('slug', $genre["slug"])->first();
            if (!isset($category)) {
                $category = Category::create([
                    'name' => $genre["name"],
                    'slug' => $genre["slug"],
                    'order' => $i,
                    'type' => 'videos',
                ]);
                echo 'Created new category: ',  $genre["name"], "\n";
            }
            if (isset($category)) {
                $items = $this->getFromItunes($genre["itid"]);
                $reversed = array_reverse($items);
                foreach($reversed as $item) {
                    echo $j.' Import Video: ',  $item["name"], " - ", $item["artist"], " - ", $category->name, "\n";
                    $this->importVideo([ "name" => $item["name"], "artist" => $item["artist"] ], $category);
                    $j++;
                }
            }
            $i++;
        }        
    }

    private function getFromItunes($genre=null, $limit=100)
    {
        $url = "http://itunes.apple.com/us/rss/topmusicvideos/limit=".$limit."/";
        if (isset($genre)) {
            $url.= "genre=".$genre."/";
        }
        $url.= "json";
        $response = Http::get($url);
        $items = [];
        if ($response->ok()) {
            $data = $response->json();
            if (isset($data["feed"]) && isset($data["feed"]["entry"])) {
                $feed = $data["feed"]["entry"];
                 foreach($feed as $item) {
                    if (isset($item["im:name"]) && isset($item["im:artist"])) {
                        array_push($items, [
                            "name" => $item["im:name"]["label"],
                            "artist" => $item["im:artist"]["label"]
                        ]);
                    }
                }
            }
        }
        return $items;
    }

    private function getFromYoutube($query) {
        $videoId = null;

        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=1&type=video&format=json";
        $url.= "&key=".env("YOUTUBE_API_KEY");
        $url.= "&q=".str_replace(" ", "+", $query);

        $response = Http::withoutVerifying()->get($url);
        if ($response->ok()) {
            $data = $response->json();
            $items = $data["items"];
            if (count($items)) {
                $item = $items[0];
                if (isset( $item["id"])) {
                    $videoId = $item["id"]["videoId"];
                }
            }
        } else {
            var_dump($response->body());
            exit();
        }
        
        return $videoId;
    }

    private function importVideo($videoItem, $category) {
        try {
            $artist = Artist::where('name', $videoItem["artist"])->get()->first();
            
            // create new artist
            if (!isset($artist)) {                
                $artist = new Artist;
                $artist->name = $videoItem["artist"];
                $artist->slug = $this->slugify($videoItem["artist"]);
                try {
                    $artist->save();
                    echo 'Created new artist: ',  $artist->name, "\n";
                } catch(Exception $e) {
                    echo 'Error creating new artist: ',  $artist->name, "\n";
                }
            }

            // create new video
            $video = Video::where('name', $videoItem["name"])->get()->first();
            if (!isset($video)) {
                $video = new Video;
                $video->name = $videoItem["name"];
                $video->artist_id = $artist->id;
                $video->slug = $this->slugify($videoItem["name"])."-".$this->slugify($videoItem["artist"]);

                $checkVideo = Video::where('slug', $video->slug)->get()->first();
                if (!isset($checkVideo)) {                
                    // search youtube
                    $searchQuery = $artist->name . " " . $video->name . " " . "music video";
                    echo 'Search Youtube: ',  $searchQuery, "\n";
                    $youtubeVideo = $this->getFromYoutube($searchQuery);
                    if (isset($youtubeVideo)) {
                        $video->ytid = $youtubeVideo;
                        $checkVideo = Video::where('ytid', $youtubeVideo)->get()->first();
                        if (!isset($checkVideo)) {
                            try {
                                $video2 = Video::where('slug', $video->slug)->get()->first();
                                if (!isset($video2)) {
                                    $video->save();
                                    echo 'Created new video: ',  $video->name, "\n";
                                }
                            } catch(Exception $e) {
                                echo 'Error Creating new video: ',  $video->name, "\n";
                            }
                        } 
                    }
                    //sleep(2);
                }         
            }
            
            // add video to category if not already
            $category->videos()->syncWithoutDetaching($video->id);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    private function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        // try {
        //     $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // } catch(Exception $e) {
        //     echo "Error slugify: ".$text."\n";
        // }

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
