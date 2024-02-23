<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // $credentials = $request->only('email', 'password');

        // if (Auth::attempt($credentials)) {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // $token = $user->createToken('MyAppToken')->plainTextToken;

            return response()->json([
                'user' => $user,
                // 'token' => $token
            ], 200);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }


    public function register(Request $request){


        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        // $token = $user->createToken('MyAppToken')->plainTextToken;
        return response()->json([
            'user' => $user,
            // 'token' => $token
        ], 201);
    }


    // public function logout(Request $request){
    //     $request->user()->tokens()->delete();
    //     return response()->json(['message' => 'Logged out successfully'], 200);
    // }


}
