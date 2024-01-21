<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $token = $user->createToken('api-token')->plainTextToken;
    
            return response()->json([
                'user' => $user,
                'access_token' => $token,
            ]);
        }catch(ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        }
    }

    public function login(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        
            $user = User::where('email', $request->email)->first();
        
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        
            $token = $user->createToken('api-token')->plainTextToken;
        
            return response()->json([
                'user' => $user,
                'access_token' => $token,
            ]);
        }catch(ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        }
    }

    public function logout(Request $request)
    {
        try{
            Auth::user()->tokens()->delete();

            return response()->json(['message' => 'Logged out successfully']);
        }catch(ValidationException $e) {
            return response()->json(['error' => $e], 422);
        }
    }
}
