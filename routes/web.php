<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ListController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login',[UserController::class,'Login']);

Route::post('/register',[UserController::class,'Register']);

Route::apiResources(['posts'    => PostController::class,
                     'comments' => CommentController::class]);

Route::get('/lists/posts/{$max}',[ListController::class , 'getPostsList']);                     
Route::get('/lists/posts/{$user_id}/{$limit}/{$offset}',[ListController::class , 'getPostsPerUser']);                     
Route::get('/lists/comments/{$user_id}/{$limit}/{$offset}',[ListController::class , 'getCommentsPerUser']);                     
Route::get('/lists/comments/{$post_id}/{$limit}/{$offset}',[ListController::class , 'getCommentsPerPost']);                     


