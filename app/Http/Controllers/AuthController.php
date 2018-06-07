<?php

namespace App\Http\Controllers;

use Validator;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController {

    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    protected function jwt(User $user) {

        $payload = [
            'iss' => "lumen-jwt",
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60*60
        ];

        return JWT::encode($payload, env('JWT_SECRET'));

    }

    public function login(User $user) {

        $input = $this->request->all();

        $this->validate($this->request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        $user = User::where('email', $input['email'])->first();

        if (!$user) {

            return response()->json([
                'error' => 'E-mail não encontrado'
            ], 400);

        }

        if (Hash::check($this->request->input('password'), $user->password)) {

            return response()->json([
                'token' => $this->jwt($user)
            ], 200);

        }

        return response()->json([
            'error' => 'E-mail ou senha incorretos!'
        ], 400);

    }

}