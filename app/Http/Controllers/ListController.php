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
   public function getPostsList( $limit = 10 , $offset = 0 ){
     $list = Post::all()
               -> offset($offset)
               -> limit($limit)
               -> get();
    $key = self::CACHE_KEY.".PostList";
    return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),$list);           
}

   public function getCommentsPerPost($post_id , $limit = 10 , $offset = 0){
    $list = Comment::where('post_id',$post_id)
                           -> offset($offset)
                           -> limit($limit)
                           -> get();  
    $key = self::CACHE_KEY.".CommentsPerPost.".$post_id;
    return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),$list);                                                                         
   }

   public function getCommentsPerUser($user_id , $limit = 10 , $offset = 0){
    $list =  Comment::where('user_id',$user_id)
                        -> offset($offset)
                        -> limit($limit)
                        -> get();  
    $key = self::CACHE_KEY.".CommentsPerUser.".$user_id;
    return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),$list);                                                                      
   }

   public function getPostsPerUser($user_id , $limit = 10 , $offset = 0){
    $list =  Post::where('user_id',$user_id)
                        -> offset($offset)
                        -> limit($limit)
                        -> get();  
    $key = self::CACHE_KEY.".PostsPerUser.".$user_id;
    return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),$list);                                                                                                          
   }
   //Tags
   public function getPostsPerTag($tag_id , $limit = 10 , $offset = 0 ){
    $posts = Post::all();
    $list = $posts->tags()
              -> where('tag_id' , $tag_id)
              -> offset($offset)
              -> limit($limit)
              -> get();
   $key = self::CACHE_KEY.".PostsPerTag.".$tag_id;
   return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),$list);           
}
public function getTagsOfPost($post_id , $limit = 10 , $offset = 0 ){
  $tags = Tag::all();
  $list = $tags->posts()
            -> where('post_id' , $post_id)
            -> offset($offset)
            -> limit($limit)
            -> get();
 $key = self::CACHE_KEY.".TagsPerPost.".$post_id;
 return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),$list);           
}
public function getAllTags( $limit = 10 , $offset = 0 ){
  $list = Tag::all()
            -> offset($offset)
            -> limit($limit)
            -> get();
 $key = self::CACHE_KEY.".TagList";
 return cache()->remember($key,now()->addMinutes(self::CACHE_MINUTES),$list);           
}
}
