<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

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
Route::get('/profile/{id}', [HomeController::class, 'view_profile']);

//posts
Route::get('/post/{id}', [PostController::class, 'view_post']);
Route::post('/new_post',[PostController::class,'new_post']);
Route::post('/delete_post',[PostController::class,'delete_post']);

//comments
Route::post('/new_comment', [PostController::class, 'new_comment']);
Route::post('/delete_comment',[PostController::class,'delete_comment']);
