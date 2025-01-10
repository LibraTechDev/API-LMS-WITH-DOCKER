<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'fullname' => $validated['fullname'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'code' => 201,
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'     => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'fullname' => $user->fullname,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'code' => 200,
            'message' => 'Logout successful',
        ]);
    }
}