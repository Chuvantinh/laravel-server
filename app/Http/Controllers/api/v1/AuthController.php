<?php

namespace App\Http\Controllers\api\v1;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller{

    public function register(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 200);
    }

    public function login(Request $request){
        try{
            $request->validate([
                'email' => 'required|string|email|exists:users',
                'password' => 'required|string'
            ]);
    
            if(!Auth::attempt($request->only('email', 'password'))){
                return response()->json([
                    'message' => 'Invalid login credentials',
                    401
                ]);
            }
    
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $request->user()
            ], 200);
            
        }catch (\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function logout( Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout successfully'
        ]);
    }
}