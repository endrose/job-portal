<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:55',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'User successfully created',
            'access_token' => $token,
            'user' => new UserResource($user)
        ], 201);
    }


    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $validated['email'])->first();


        if (!$user) {
            return response()->json([
                'message' => 'User not found!',
                'status' => false,
            ], 401);
        }

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credential'
            ], 401);
        }


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login success',
            'role' => $user->role,
            'access_token' => $token
        ]);
    }


    public function  logout (Request $request)
    {
        //Logout
        try {
            //code...
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Logout success'
            ]);

        } catch (\Exception $th) {
            //throw $th;
            return response()->json([
                'status' => false,
                'message' => $th->__toString()
            ], 404);
        }


     }
}
