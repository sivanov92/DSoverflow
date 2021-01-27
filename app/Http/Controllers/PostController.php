<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

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
            '0.title' => 'required|max:255',
            '0.content' => 'required',
        ]);
        if(!$validated){
            return response('Validator failed',400);
        }

        //
      $title = $request->input('0.title');
      $content= $request->input('0.content') ;
      $post = new Post;
      $post->title = $title;
      $post->content = $content;
      $post->created_at = now();
      $post->user = $request->user->id(); 
      $post->save();

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
        if($request->input('0.title')!=""){
            $title = $request->input('0.title');
            $post->title = $title;
        }
        if($request->input('0.content')!=""){
            $content = $request->input('0.content');
            $post->content = $content;
        }       
        $post->save();         
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
      $post->delete();  
    }
}
