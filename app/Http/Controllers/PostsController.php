<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function index(){

        $posts = Post::all();

        return response()->json($posts);

    }

    public function getPost($postId){

        $post = Post::findOrFail($postId);

        return response()->json($post);

    }

    public function addPost(Request $request){

        $input = $request->all();

        $this->validate($request, [
            'title'     => 'required',
            'content'  => 'required|min:50',
        ]);

        $post = Post::create($input);

        return response()->json($post);

    }

    public function deletePost($postId){

        Post::findOrFail($postId)->delete();

        return response('POST deletado com sucesso!');

    }

    public function editPost($postId, Request $request){

        $post = Post::find($postId);

        $input = $request->all();

        $this->validate($request, [
            'title'     => 'required',
            'content'  => 'required|min:50',
        ]);

        $post->update($input);

    }


}
