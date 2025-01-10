<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'code' => 200,
            'message' => 'Daftar User Berhasil Diambil',
            'data' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
            
        ]);

        $user = User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' =>  $request->role,
        ]);

        return response()->json([
            'code' => 201,
            'message' => 'User Berhasil Dibuat',
            'data' => $user,
        ], 201);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        } else {
            return response()->json([
                'code' => 200,
                'message' => 'User Berhasil Diambil',
                'data' => $user
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'nullable|string|in:teacher,user',
        ]);

        $user->username = $validatedData['username'];
        $user->fullname = $validatedData['fullname'];
        

        if (!empty($validatedData['email'])) {
            $user->email = $validatedData['email'];
        }

        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        if (!empty($validatedData['role'])) {
            $user->role = $validatedData['role'];
        }

        $user->save();

        return response()->json([
            'code' => 200,
            'message' => 'User updated successfully',
            'data' => $user,
        ]);
    }





    // Hapus laporan
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json([
            'code' => 200,
            'message' => 'User Berhasil Dihapus',
        ]);
    }
}