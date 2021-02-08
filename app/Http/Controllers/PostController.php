<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Controllers\ListController;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);
        if(!$validated){
            return response('Validator failed',400);
        }

        //
      $title = $request->input('title');
      $content= $request->input('content') ;
      $post = new Post;
      $post->title = $title;
      $post->content = $content;
      $post->created_at = now();
      $post->user = $request->user->id(); 

      $tag_list=array();
      if ($request->has('tags')) {
          array_push($tag_list, $request->input('tags'));
      }
      $post->tags()->attach($tag_list);

      $post->save();
      $cache_key1 = ListController::CACHE_KEY.'.PostList';
      $cache_key2 = ListController::CACHE_KEY.'.PostsPerUser.'.$post->user;
      cache()->forget($cache_key1);
      cache()->forget($cache_key2);

      return response("Success");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
     return Post::find($id); 

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $post=  Post::findOrFail($id);
        if($request->input('title')!=""){
            $title = $request->input('title');
            $post->title = $title;
        }
        if($request->input('content')!=""){
            $content = $request->input('content');
            $post->content = $content;
        }       
        $tag_list=array();
        if ($request->has('tags')) {
            array_push($tag_list, $request->input('tags'));
            $post->tags()->attach($tag_list);
        }
  
        $post->save();     
        $cache_key1 = ListController::CACHE_KEY.'.PostList';
        $cache_key2 = ListController::CACHE_KEY.'.PostsPerUser.'.$post->user;
        cache()->forget($cache_key1);
        cache()->forget($cache_key2);
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
      $post = Post::find($id);
      $cache_key1 = ListController::CACHE_KEY.'.PostList';
      $cache_key2 = ListController::CACHE_KEY.'.PostsPerUser.'.$post->user;
      $post->delete();  
      cache()->forget($cache_key1);
      cache()->forget($cache_key2);

    }
}
