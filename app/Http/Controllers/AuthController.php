<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        $request->validate(
            [
                'name' => 'string|required',
                'email' => 'required|unique:users,email|email',
                'password' => 'required|string|confirmed'
            ]
        );

        $user = User::create(
            [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password'])
            ]
        );

        $token = $user->createToken('token')->plainTextToken;
        return ['is_done' => true, 'token' => $token];
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            session()->regenerate();
            $user = auth()->user();
            $done = [
                'user' => auth()->user(),
                'token' => $user->createToken('token')->plainTextToken,
            ];
            return response($done, 200);
        } else {
            return response("Unsuccessfull Attempt", 401);
        }
    }
    public function logout(Request $request)
    {

        auth()->user()->tokens()->delete();
        Auth::logout();
        return response("Logged Out", 200);
    }
}
