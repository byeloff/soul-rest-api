<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class PostsController extends Controller
{

    public function index(){

        $posts = Post::all();

        return response()->json($posts, 201);

    }

    public function show($postId){

        $post = Post::findOrFail($postId);

        return response()->json($post, 201);

    }

    public function store(Request $request){

        $input = $request->all();

        $this->validate($request, [
            'title'     => 'required',
            'content'  => 'required|min:50',
        ]);

        $input['user_id'] = JWT::decode($request->get('token'), env('JWT_SECRET'), ['HS256'])->sub;

        $post = Post::create($input);

        return response()->json([
            'msg'    => 'Post adicionado com sucesso!',
            'result' => $post
        ], 201);

    }

    public function delete(Request $request, $postId){

        $post = Post::findOrFail($postId);

        $credenciais = JWT::decode($request->get('token'), env('JWT_SECRET'), ['HS256'])->sub;

        if($credenciais != $post->user_id){
            return response()->json([
                'msg'    => 'Só é possível deletar artigos de sua autoria.',
                'result' => $post
            ], 201);
        }

        $post->delete();

        return response()->json([
            'msg' => 'POST deletado com sucesso!'
        ], 201);

    }

    public function update($postId, Request $request){

        $post = Post::find($postId);

        $input = $request::all();

        $this->validate($request, [
            'title'     => 'required',
            'content'  => 'required|min:50',
        ]);

        $post->update($input);

        $post = Post::find($postId);

        return response()->json([
            'msg'    => 'Post alterado com sucesso!',
            'result' => $post
        ], 201);

    }

}
