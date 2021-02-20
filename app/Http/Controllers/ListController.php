<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;

class ListController extends Controller
{
    const CACHE_KEY = 'LIST';
    const CACHE_MINUTES = 5;
    //
   public function getPostsList(){
    $limit = 10;
    $offset = 0;
    if(isset($_GET['limit'])){
      $limit = $_GET['limit'];
    } 
    if(isset($_GET['offset'])){
      $limit = $_GET['offset'];
    } 
    $list = Post::take($limit)
                  ->skip($offset)
                  ->get();
    $key = self::CACHE_KEY.".PostList";
    return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),function() use ($list){
      return $list;
    });           
}

   public function getCommentsPerPost($post_id){
    $list = Comment::where('post_id',$post_id)
                           -> get();  
    $key = self::CACHE_KEY.".CommentsPerPost.".$post_id;
    return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),function() use ($list){
      return $list;
    });                                                                         
   }

   public function getCommentsPerUser($user_id){
    $list =  Comment::where('user_id',$user_id)
                        -> get();  
    $key = self::CACHE_KEY.".CommentsPerUser.".$user_id;
    return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),function() use ($list){
      return $list;
    });                                                                      
   }

   public function getPostsPerUser($user_id){
    $list =  Post::where('user_id',$user_id)
                        -> get();  
    $key = self::CACHE_KEY.".PostsPerUser.".$user_id;
    return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),function() use ($list){
      return $list;
    });                                                                                                          
   }
   //Tags
   public function getPostsPerTag($tag_id){
    $list = Post::whereHas('tags',function($query) use ($tag_id) {
      $query->where('tag_id',$tag_id);
    })->get(); 
    $key = self::CACHE_KEY.".PostsPerTag.".$tag_id;
   return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),function() use ($list){
    return $list;
  });           
}
public function getTagsOfPost($post_id){
  $list = Tag::whereHas('posts',function($query) use ($post_id) {
    $query->where('post_id',$post_id);
  })->get();

 $key = self::CACHE_KEY.".TagsPerPost.".$post_id;
 return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),function() use ($list){
  return $list;
});           
}
public function getAllTags(){
  $limit = 10;
  $offset = 0;
  if(isset($_GET['limit'])){
    $limit = $_GET['limit'];
  } 
  if(isset($_GET['offset'])){
    $limit = $_GET['offset'];
  } 

  $list = Tag::take($limit)
               ->skip($offset)
               ->get();
 $key = self::CACHE_KEY.".TagList";
 return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),function() use ($list){
  return $list;
});           
}
}
