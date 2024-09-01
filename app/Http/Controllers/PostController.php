<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'message' => 'Display a listing of posts',
            'data' => $posts
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title'=> 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|int|exists:users,id'
        ]);

        $post = Post::create($request->all());

        return response()->json([
            'message' => 'New post created',
            'data'=> $post,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if ($post) {
            return response()->json([
                'message'=> 'Display the specified resource',
                'data'=> $post
            ], 200);
        }else{
            return response()->json([
                'message'=> 'Post not found'
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'message'=> 'Post not found'
            ], 400);
        }

        // validate the request
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content'=> 'sometimes|required|string',
            'user_id'=> 'sometimes|required|integer|exists:user,id'
        ]);
        //update the post
        $post->update($request->all());

        return response()->json([ 
            'message' =>    'Post updated',
            'data'=> $post
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post){
            return response()->json([
                'message'  => 'Post not found'
            ], 400);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully',
            'data'=> $post
        ], 200);

    }
}
