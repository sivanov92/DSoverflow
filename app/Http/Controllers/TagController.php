<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Controllers\ListController;

class TagController extends Controller
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
            'name' => 'required|max:255',
        ]);
        if(!$validated){
            return response('Validator failed',400);
        }

        //
      $name = $request->input('name') ;
      $tag = new Tag;
      $tag -> name = $name ;
      $tag ->created_at = now();
      $tag ->save();
      $cache_key1 = ListController::CACHE_KEY.'.TagList';
      cache()->forget($cache_key1);

      return response($tag,201);

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
      return Tag::findOrFail($id);  
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
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);
        if(!$validated){
            return response('Validator failed',400);
        }

        //
      $name = $request->input('name') ;
      $tag = Tag::findOrFail($id);
      $tag -> name = $name ;
      $tag ->save();
      $cache_key1 = ListController::CACHE_KEY.'.TagList';
      cache()->forget($cache_key1);

      return response($tag,200);
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
      $tag = Tag::findOrFail($id);
      $tag -> delete();
      $cache_key1 = ListController::CACHE_KEY.'.TagList';
      cache()->forget($cache_key1);

      return response($tag,200);
  
    }
}
