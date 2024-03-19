<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReactionsController;
use App\Http\Controllers\Api\TestQueriesController;
use App\Http\Controllers\Api\TweetsController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\VideosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Test Querieys
Route::get('/test', [TestQueriesController::class, 'getQuery']);

// Auth
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth/refresh', [AuthController::class, 'refresh']);
Route::post('/auth/me', [AuthController::class, 'me']);

// Reactions
Route::get('/reaction/{name}/{type}/{id}', [ReactionsController::class, 'getReaction']);
Route::get('/reaction/count/{name}/{type}/{id}', [ReactionsController::class, 'getReactionCount']);

// Tweets
Route::get('/tweet/{id}', [TweetsController::class, 'getTweetById']);

// Users
Route::get('/user/{name}', [UsersController::class, 'getUserByName']);

// Videos
Route::get('/videos/artists', [VideosController::class, 'getArtists']);
Route::get('/videos/artist/{slug}', [VideosController::class, 'getVideosByArtist']);
Route::get('/videos/categories', [VideosController::class, 'getCategories']);
Route::get('/videos/category/{slug}', [VideosController::class, 'getVideosByCategory']);
Route::get('/videos/search', [VideosController::class, 'searchVideos']);
Route::get('/videos/search/artists', [VideosController::class, 'searchArtists']);
Route::get('/videos/video/{slug}', [VideosController::class, 'getVideoBySlug']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
