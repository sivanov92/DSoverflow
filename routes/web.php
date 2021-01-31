<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\TagController;

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
                     'comments' => CommentController::class,
                     'tags'     => TagController::class]);

Route::get('/lists/posts/limit/{limit}/offset/{offset}',[ListController::class , 'getPostsList']);                     
Route::get('/lists/posts/user-id/{user_id}/limit/{limit}/offset/{offset}',[ListController::class , 'getPostsPerUser']);                     
Route::get('/lists/comments/user-id/{user_id}/limit/{limit}/offset/{offset}',[ListController::class , 'getCommentsPerUser']);                     
Route::get('/lists/comments/post-id/{post_id}/limit/{limit}/offset/{offset}',[ListController::class , 'getCommentsPerPost']);                     

Route::get('/lists/tags/limit/{limit}/offset/{offset}',[ListController::class , 'getAllTags']);                     
Route::get('/lists/posts/tag-id/{tag_id}/limit/{limit}/offset/{offset}',[ListController::class , 'getPostsPerTag']);                     
Route::get('/lists/tags/post-id/{post_id}/limit/{limit}/offset/{offset}',[ListController::class , 'getTagsOfPost']);                     


