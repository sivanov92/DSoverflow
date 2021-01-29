<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class ListController extends Controller
{
    //
   public function getPostsList( $max=10 ){
     return Post::all()->take($max)->get();
   }

   public function getCommentsPerPost($post_id , $limit = 10 , $offset = 0){
       return Comment::where('post_id',$post_id)
                           -> offset($offset)
                           -> limit($limit)
                           -> get();                  
   }

   public function getCommentsPerUser($user_id , $limit = 10 , $offset = 0){
    return Comment::where('user_id',$user_id)
                        -> offset($offset)
                        -> limit($limit)
                        -> get();                  
   }

   public function getPostsPerUser($user_id , $limit = 10 , $offset = 0){
    return Post::where('user_id',$user_id)
                        -> offset($offset)
                        -> limit($limit)
                        -> get();                  
   }

}
