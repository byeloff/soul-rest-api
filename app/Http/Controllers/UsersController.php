<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index(){

        $users = User::all();
        
        return response()->json($users);

    }

    public function getUser($userId){

        $user = User::findOrFail($userId);

        return response()->json($user);


    }

    public function addUser(Request $request){

        $input = $request->all();

        $this->validate($request, [
            'name'     => 'required',
            'password' => 'required',
            'email'    => 'required|email'
        ]);

        if(User::where('email', $input['email'])->count() > 0){
            return response('Este e-mail já está cadastrado!', 400);
        }

        $user = User::create($input);

        return response()->json($user);

    }

    public function deleteUser($userId){

        User::findOrFail($userId)->delete();

        return response('Usuário deletado com sucesso!');

    }

    public function editUser($userId, Request $request){

        $user = User::find($userId);

        $input = $request->all();

        $this->validate($request, [
            'name'     => 'required',
            'password' => 'required',
            'email'    => 'required|email'
        ]);

        if(User::where('email', $input['email'])->where('id', '!=', $userId)->count() > 0){
            return response('Este e-mail já está cadastrado!', 400);
        }

        if(empty($input['password'])){
            unset($input['password']);
        }

        $user->update($input);

    }

}
