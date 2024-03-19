<?php

use App\Http\Controllers\PhotosController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

function tmv() {
    $app = "topmusicvideos";

    // Home
    Route::get('/', function() use($app) {
        return App::call('App\Http\Controllers\VideoController@home', ['app' => $app]);
    })->name($app.'.home');
    
    // Artists
    Route::view('/artists', 'apps.'.$app.'.artists.index', ['app' => $app])->name($app.'.artists');   
    Route::get('/artist/{slug}', function($slug) use($app) {
        return App::call('App\Http\Controllers\VideoController@artist', ['slug' => $slug, 'app' => $app]);
    })->name($app.'.artists.show');
    
    // Categories
    Route::get('/categories', function() use($app) {
        return App::call('App\Http\Controllers\VideoController@categories', ['app' => $app]);
    })->name($app.'.categories');
    Route::get('/category/{slug}', function($slug) use($app) {
        return App::call('App\Http\Controllers\VideoController@category', ['slug' => $slug, 'app' => $app]);
    })->name($app.'.categories.show');
    
    // Videos
    Route::get('/video/{slug}', function($slug) use($app) {
        return App::call('App\Http\Controllers\VideoController@show', ['slug' => $slug, 'app' => $app]);
    })->name($app.'.video.show');

    // Profile
    Route::get('/@{name}', function($name) use($app) {
        return App::call('App\Http\Controllers\ProfileController@show', ['name' => $name, 'app' => $app]);
    })->name($app.'.members.show');

    // Requires Logged In
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function() use($app) {    

        // Favorites
        Route::view('/favorite/videos', 'apps.'.$app.'.favorites.videos.index', ['app' => $app])->name($app.'.favorite_videos'); 
        
        // Lists
        Route::view('/lists', 'apps.'.$app.'.lists.index', ['app' => $app])->name($app.'.lists');
        Route::get('/list/{id}', function($id) use($app) {
            return App::call('App\Http\Controllers\VideoController@list', ['id' => $id, 'app' => $app]);
        })->name($app.'.list');
        
        // Notifications
        Route::view('/notifications', 'apps.'.$app.'.notifications.index', ['app' => $app])->name($app.'.notifications');
        
        // Settings
        Route::view('/settings', 'apps.'.$app.'.settings.profile', ['app' => $app])->name($app.'.settings.profile');
        Route::view('/settings/account', 'apps.'.$app.'.settings.account', ['app' => $app])->name($app.'.settings.account'); 
        Route::view('/settings/mail', 'apps.'.$app.'.settings.mail', ['app' => $app])->name($app.'.settings.mail'); 
        Route::view('/settings/photos', 'apps.'.$app.'.settings.photos', ['app' => $app])->name($app.'.settings.photos'); 
        Route::post('/settings/photos', [PhotosController::class, 'storePhoto']);
        Route::post('/settings/photos/set_main', [PhotosController::class, 'setMainPhoto']);
        Route::post('/settings/photos/delete', [PhotosController::class, 'deletePhoto']);
    });
}

function twitter() {
    $app = "twitter";

    // Home
    Route::view('/', 'apps.'.$app.'.home', ['app' => $app])->name($app.'.home');

    // Profile
    Route::get('/@{name}', function($name) use($app) {
        return App::call('App\Http\Controllers\ProfileController@show', ['name' => $name, 'app' => $app]);
    })->name($app.'.members.show');
    Route::get('/@{name}/posts_replies', function($name) use($app) {
        return App::call('App\Http\Controllers\ProfileController@show', ['name' => $name, 'app' => $app, 'view' => '.profile.posts_replies']);
    })->name($app.'.members.posts_replies');
    Route::get('/@{name}/media', function($name) use($app) {
        return App::call('App\Http\Controllers\ProfileController@show', ['name' => $name, 'app' => $app, 'view' => '.profile.media']);
    })->name($app.'.members.media'); 
    Route::get('/@{name}/followers', function($name) use($app) {
        return App::call('App\Http\Controllers\ProfileController@show', ['name' => $name, 'app' => $app, 'view' => '.profile.followers']);
    })->name($app.'.members.followers');
    Route::get('/@{name}/following', function($name) use($app) {
        return App::call('App\Http\Controllers\ProfileController@show', ['name' => $name, 'app' => $app, 'view' => '.profile.following']);
    })->name($app.'.members.following');

    // Tags
    Route::get('/tag/{id}', function($id) use($app) {
        return view('apps.'.$app.'.tag.show', ['app' => $app, 'id' => $id]);
    })->name($app.'.tag'); 

    // Tweets
    Route::get('/tweet/{id}', function($id) use($app) {
        return App::call('App\Http\Controllers\TweetController@show', ['id' => $id, 'app' => $app]);
    })->name($app.'.tweet');    

    // Requires Logged In
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function() use($app) {   

        // Profile - Likes
        Route::get('/@{name}/likes', function($name) use($app) {
            return App::call('App\Http\Controllers\ProfileController@show', ['name' => $name, 'app' => $app, 'view' => '.profile.likes']);
        })->name($app.'.members.likes');

        // Blocks
        Route::view('/blocks', 'apps.'.$app.'.blocks.index', ['app' => $app])->name($app.'.blocks');
        
        // Mutes
        Route::view('/mutes', 'apps.'.$app.'.mutes.index', ['app' => $app])->name($app.'.mutes');        
        
        // Bookmakrs
        Route::view('/bookmarks', 'apps.'.$app.'.bookmarks.index', ['app' => $app])->name($app.'.bookmarks');
        
        // Lists
        Route::view('/lists', 'apps.'.$app.'.lists.index', ['app' => $app])->name($app.'.lists');
        Route::get('/list/{id}', function($id) use($app) {
            return view('apps.'.$app.'.lists.show', ['app' => $app, 'id' => $id]);
        })->name($app.'.list'); 
        
        // Messages
        Route::view('/messages', 'apps.'.$app.'.messages.inbox', ['app' => $app])->name($app.'.messages');      
        Route::view('/messages/sent', 'apps.'.$app.'.messages.sent', ['app' => $app])->name($app.'.messages.sent');
        Route::get('/messages/create/{name}', function($name) use($app) {
            return view('apps.'.$app.'.messages.create', ['name' => $name, 'app' => $app ]);
        })->name($app.'.messages.create');   
        Route::get('/messages/{id}', function($id) use($app) {
            return view('apps.'.$app.'.messages.show', ['threadId' => $id, 'app' => $app ]);
        })->name($app.'.messages.show');    
       
        // Notifications
        Route::view('/notifications', 'apps.'.$app.'.notifications.index', ['app' => $app])->name($app.'.notifications');
       
        // Search
        Route::view('/search', 'apps.'.$app.'.search.index', ['app' => $app])->name($app.'.search');
        Route::view('/search/tweets', 'apps.'.$app.'.search.tweets', ['app' => $app])->name($app.'.search.tweets');
        Route::view('/search/hashtags', 'apps.'.$app.'.search.hashtags', ['app' => $app])->name($app.'.search.hashtags');
        
        // Settings
        Route::view('/settings', 'apps.'.$app.'.settings.index', ['app' => $app])->name($app.'.settings');
        Route::view('/settings/profile', 'apps.'.$app.'.settings.profile', ['app' => $app])->name($app.'.settings.profile');
        Route::view('/settings/email', 'apps.'.$app.'.settings.email', ['app' => $app])->name($app.'.settings.email'); 
        Route::view('/settings/password', 'apps.'.$app.'.settings.password', ['app' => $app])->name($app.'.settings.password');
        Route::view('/settings/sessions', 'apps.'.$app.'.settings.sessions', ['app' => $app])->name($app.'.settings.sessions');
        Route::view('/settings/account', 'apps.'.$app.'.settings.account', ['app' => $app])->name($app.'.settings.account'); 
    });
}

$host = "localhost";
if (isset($_SERVER['HTTP_HOST'])) {
    $host = $_SERVER['HTTP_HOST'];
}
$hostList = explode('.', $host);
$subdomain = array_shift($hostList);

switch($subdomain) {
    
    // Top Music Videos
    case 'local-topmusicvideos':
        Route::domain('local-topmusicvideos.boosh.io')->group(function(){ tmv(); });
    break;
    case 'topmusicvideos':
        Route::domain('topmusicvideos.boosh.io')->group(function(){ tmv(); });
    break;

    // Twitter
    case 'local-twitter':
        Route::domain('local-twitter.boosh.io')->group(function(){ twitter(); });
    break;
    case 'twitter':
        Route::domain('twitter.boosh.io')->group(function(){ twitter(); });
    break;

    // Boosh
    case 'local-laravel':
        Route::domain('local-laravel.boosh.io')->group(function(){ 
            Route::get('/', function(){
    
                // Home
                return view('apps.boosh.home', [
                    'apps' => [
                        "topmusicvideos" => [
                            "name" => "Top Music Videos",
                            "logo" => "/images/topmusicvideos/logo.jpg",
                            "url" => "http://local-topmusicvideos.boosh.io:8000"
                        ],
                        "twitter" => [
                            "name" => "Twitter",
                            "logo" => "/images/twitter/logo.png",
                            "url" => "http://local-twitter.boosh.io:8000"
                        ]
                    ]
                ]);
            })->name('boosh.home');
        });
    break;

    default:
    break;
}

// Boosh
Route::get('/', function(){
    
    // Home
    return view('apps.boosh.home', [
        'apps' => [
            "topmusicvideos" => [
                "name" => "Top Music Videos",
                "logo" => "/images/topmusicvideos/logo.jpg",
                "url" => "http://topmusicvideos.boosh.io"
            ],
            "twitter" => [
                "name" => "Twitter",
                "logo" => "/images/twitter/logo.png",
                "url" => "http://twitter.boosh.io"
            ],
        ]
    ]);
})->name('boosh.home');
