<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index(){

        $users = User::all();
        
        return response()->json($users, 201);

    }

    public function show($userId){

        $user = User::findOrFail($userId);

        return response()->json($user, 201);


    }

    public function store(Request $request){

        $input = $request->all();

        $this->validate($request, [
            'name'     => 'required',
            'password' => 'required',
            'email'    => 'required|unique:users|email'
        ]);

        $user = User::create($input);

        return response()->json([
            'msg'    => 'Usuário adicionado com sucesso!',
            'result' => $user
        ], 201);

    }

    public function delete($userId){

        User::findOrFail($userId)->delete();

        return response()->json([
            'msg' => 'Usuário deletado com sucesso!'
        ], 201);

    }

    public function update($userId, Request $request){

        $user = User::find($userId);

        $input = $request->all();

        $this->validate($request, [
            'name'     => 'required',
            'password' => 'required',
            'email'    => 'required|unique:users|email'
        ]);

        if(empty($input['password'])){
            unset($input['password']);
        }

        $user->update($input);

        $user = User::find($userId);

        return response()->json([
            'msg'    => 'Usuário alterado com sucesso!',
            'result' => $user
        ], 201);

    }

}
