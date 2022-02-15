<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchController;
use Symfony\Component\HttpKernel\Profiler\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {return Redirect('login');});

Auth::routes();

//home
Route::get('/home', [HomeController::class, 'index'])->name('home');

//Users - sidebar-> Full page
Route::get('/users', [HomeController::class, 'view_users']);

//profile
Route::get('/profile/{id}', [ProfileController::class, 'view_profile']);
Route::get('/profile/{{id}}/comments', [ProfileController::class, 'view_comments']);
Route::get('/profile/{id}/edit', [ProfileController::class, 'edit_profile']);
Route::post('/profile/follow', [ProfileController::class, 'follow_user']);

//profile Edit - Details/Media/Bio
Route::post('/profile/edit/details', [ProfileController::class, 'profile_edit_details']);
Route::post('/profile/edit/media', [ProfileController::class, 'profile_edit_media']);
Route::post('/profile/edit/bio', [ProfileController::class, 'profile_edit_bio']);

//posts
Route::get('/post/{id}', [PostController::class, 'view_post']);

Route::post('/new_post',[PostController::class,'new_post']);
Route::post('/delete_post',[PostController::class,'delete_post']);
Route::post('/like_post',[PostController::class,'like_post']);
Route::post('/favorite_post',[PostController::class,'favorite_post']);
Route::post('/repost_post',[PostController::class,'repost_post']);

//comments
Route::post('/new_comment', [CommentController::class, 'new_comment']);
Route::post('/delete_comment',[CommentController::class,'delete_comment']);

//search-ajax
Route::get('search_result', [SearchController::class, 'search_result']);

