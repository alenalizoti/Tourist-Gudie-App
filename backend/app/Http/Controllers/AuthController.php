<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Expectation;

class AuthController extends Controller
{
    public function register (Request $request){
        $validate = $request->validate([
            'name' => 'required|string|max:255|min:5',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|max:255|min:7',
        ]);

        try {
                $user = User::create([
                    'name' => $validate['name'],
                    'email' => $validate['email'],
                    'password' => $validate['password'], 
                ]);
                return response()->json(['message' => 'User registered successfully!'], 201);
    
            } 
            catch (\Exception $e) {

                return response()->json(['error' => 'An error occurred while registering. Please try again later.'], 500);     
            }

    }

    public function login (Request $request){

        $credentials = $request->validate([
            'email' => 'required|email|string|max:255',
            'password' => 'required',
        ]); 

        if(!Auth::attempt($credentials)){
            return response()->json(['message'=> 'Invalid credentials!'],401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user],200);
    }

    public function logout(Request $request){
        $user = auth()->user();
        if($user){
            $request->user()->tokens()->delete();
        }
        return response()->json(['message' => 'Logged out successfully!'],200);
    }
}
