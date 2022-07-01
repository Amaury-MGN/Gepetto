<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Post as PostResource;
use Validator;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::all();

        return $this->sendResponse(PostResource::collection($post), 'Images retrieved successfully.');
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
    public function store(Request $request, Post $post)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, $id)
    {
        $post = Post::find($id);
        // dd($post);

        // return $this->sendResponse(new PostResource($post), 'Posts retrieved successfully.');
        return response()->json(['data' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        // $request->validate([
        //     'firstPost'     => 'nullable',
        //     'secondPost'    => 'nullable',
        //     'thirdPost'     => 'nullable',
        //     'fourthPost'    => 'nullable',
        // ]);
        $post->webPage = $post->webPage;
        // dd($request->firstPost, $post->firstPost, $request->secondPost);
        if ($request->firstPost === null) {
            $firstPost = $post->firstPost;
        } else ($firstPost = $request->firstPost);
        // dd($request->secondPost);
        if ($request->secondPost === null) {
            $secondPost = $post->secondPost;
        } else ($secondPost = $request->secondPost);

        if ($request->thirdPost === null) {
            $thirdPost = $post->thirdPost;
        } else ($thirdPost = $request->thirdPost);

        if ($request->fourthPost === null) {
            $fourthPost = $post->fourthPost;
        } else ($fourthPost = $request->fourthPost);

        // dd($firstPost, $secondPost, $thirdPost, $fourthPost);
        $post->firstPost = $firstPost;
        $post->secondPost = $secondPost;
        $post->thirdPost = $thirdPost;
        $post->fourthPost = $fourthPost;


        $post->save();

        return $this->sendResponse(new PostResource($post), 'Post updated successfully');
        // return response()->json(['success' => 'Post updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
