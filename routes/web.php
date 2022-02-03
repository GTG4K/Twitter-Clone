<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');

//profile
Route::get('/profile/{id}', [ProfileController::class, 'view_profile']);
Route::get('/profile/{id}/comments', [ProfileController::class, 'view_profile_comments']);
Route::get('/profile/{id}/edit', [ProfileController::class, 'edit_profile']);

//profile Edit -
    //Details
    Route::post('/profile/edit/details', [ProfileController::class, 'profile_edit_details']);

    //Media
    Route::post('/profile/edit/media', [ProfileController::class, 'profile_edit_media']);

    //Bio
    Route::post('/profile/edit/bio', [ProfileController::class, 'profile_edit_bio']);

//posts
Route::get('/post/{id}', [PostController::class, 'view_post']);
Route::post('/new_post',[PostController::class,'new_post']);
Route::post('/delete_post',[PostController::class,'delete_post']);

//comments
Route::post('/new_comment', [PostController::class, 'new_comment']);
Route::post('/delete_comment',[PostController::class,'delete_comment']);
