<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields =  $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user =  User::create($fields);

        $token = $user->createToken($request->name);


        return ['user' => $user, 'token' => $token];
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken($user->name);


        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'message' => 'The Provided credentials are incorrect.'
            ];
        } else {
            return ['user' => $user, 'token' => $token->plainTextToken];
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out'
        ];
    }
}
