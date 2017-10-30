<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $this->validate($request, [
            'email' => 'required|min:4|max:255|unique:users,email',
            'password' => 'required|min:8|max:255',
        ]);
        return redirect()->route('storeUser');
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|min:4|max:255',
            'password' => 'required|min:8|max:255',
        ]);
        if (! $token = JWTAuth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Wrong Credentials'], 403);
        }
        return response()->json($token, 200);
    }

    public function self(Request $request) {
        if (! $user = JWTAuth::toUser(JWTAuth::getToken())) {
            return response()->json(null, 403);
        }
        return response()->json($user->id, 200);
    }
}
