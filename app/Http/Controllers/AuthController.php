<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'nohp' => 'required|numeric',
            'role' => 'nullable'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nohp' => $data['nohp'],
            'role' => $data['role']
        ]);

        return response()->json(['message' => 'Registrasi user berhasil'], 201);
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'email atau password salah'], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }
}