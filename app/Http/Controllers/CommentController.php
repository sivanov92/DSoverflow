<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Controllers\ListController;

class CommentController extends Controller
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
            'content' => 'required',
        ]);
        if(!$validated){
            return response('Validator failed',400);
        }
        //
        $content= $request->input('content') ;
        $comment = new Comment;
        $comment->content = $content;
        $comment->created_at = now();
        $comment->user_id = $request->user()->id; 
        $comment->post_id = $request->input('post_id');
        $comment->save();
        $cache_key1 = ListController::CACHE_KEY.'.CommentsPerPost.'.$comment->post;
        $cache_key2 = ListController::CACHE_KEY.'.CommentsPerUser.'.$comment->user;
        cache()->forget($cache_key1);
        cache()->forget($cache_key2);
        return response($comment,201);
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
      return Comment::findOrFail($id);  
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
        $content= $request->input('content') ;
        $comment = Comment::findOrFail($id);
        $comment->content = $content;
        $comment->save(); 
        $cache_key1 = ListController::CACHE_KEY.'.CommentsPerPost.'.$comment->post;
        $cache_key2 = ListController::CACHE_KEY.'.CommentsPerUser.'.$comment->user;
        cache()->forget($cache_key1);
        cache()->forget($cache_key2);

        return response($comment,200);
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
       $comment = Comment::find($id);
       $cache_key1 = ListController::CACHE_KEY.'.CommentsPerPost.'.$comment->post;
       $cache_key2 = ListController::CACHE_KEY.'.CommentsPerUser.'.$comment->user;
       cache()->forget($cache_key1);
       cache()->forget($cache_key2);
       $comment->delete();    
       return response($comment,200);
    }
}
