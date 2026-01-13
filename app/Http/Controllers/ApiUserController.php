<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ApiUserController extends Controller
{
    function index(Request $request) {
        $user = User::where('email', $request->email)->first();
        if ($user && password_verify($request->password, $user->password)) {
            return response()->json([
                'status' => true,
                'message' => 'User authenticated',
                'token' => $user->createToken('api_token')->plainTextToken
                
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
                ,'token' => null
            ]);
        }
    }
}
