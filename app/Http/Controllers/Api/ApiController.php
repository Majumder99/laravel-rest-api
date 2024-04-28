<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller {
    //Register api, login api, profile api, logout api
    // POST[name,email,password] /api/register
    public function register(Request $request) {
        // Validation
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        // User
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            "status" => true,
            "message" => "User created successfully",
            "data" => [
                "name" => $request->name,
                "email" => $request->email,
            ]
        ]);
    }

    // POST[email,password] /api/login
    public function login(Request $request) {
        //  validation
        $request->validate([
            'email' => 'required|email|string',
            'password' => 'required',
        ]);
        $user = User::where("email", $request->email)->first();
        if (!empty($user)) {
            // user found
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("auth_token")->plainTextToken;
                return response()->json([
                    "status" => true,
                    "message" => "User logged in successfully",
                    "data" => [
                        "name" => $user->name,
                        "email" => $user->email,
                    ],
                    "token" => $token
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Password not matched",
                    "data" => []
                ]);
            }
        } else {
            return response()->json([
                "status" => false,
                "message" => "User not found",
                "data" => []
            ]);
        }
    }

    // GET [Auth: Token] /api/profile
    public function profile() {
        $userData = auth()->user();
        return response()->json([
            "status" => true,
            "message" => "User profile",
            "data" => $userData,
            "id" => auth()->user()->id
        ]);
    }

    // GET [Auth: Token] /api/logout
    public function logout() {
        auth()->user()->tokens()->delete();
        return response()->json([
            "status" => true,
            "message" => "User logged out successfully",
            "data" => []
        ]);
    }
}
