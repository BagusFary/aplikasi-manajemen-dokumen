<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function register(RegisterRequest $request){

        $user = User::create([
            'name' => $request['name'],
            'role_id' => '2',
            'email' => $request['email'],
            'email_verified_at' => now(),
            'password' => Hash::make($request['password']),
        ]);

        if(!$user){
            return response()->json([
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }

        return response()->json([
            'message' => 'Registrasi berhasil!',
            'user' => $user
        ], 201);

    }

    public function login(LoginRequest $request){

        $user = User::where('email', $request['email'])->first();

        if(!$user || !Hash::check($request['password'], $user->password)){
            return response()->json([
                "message" => "Kredensial tidak valid"
            ], 400);
        }

        $user->tokens()->delete();
        
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            "message" => "Login berhasil!",
            "user" => $user,
            "token" => $token
        ], 201);

    }

    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout berhasil!'
        ]);
    }
}
