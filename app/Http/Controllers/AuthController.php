<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginUser(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {
            throw validationException::withMessages([
                'email' => ['the provided credentials are incorrect.']
            ]);
        }
        if (Hash::make($request->password) ==  $user->password) {
            throw validationException::withMessages([
                'email' => ['the provided credentials are incorrect.']
            ]);
        }
        $token = $user->createToken('api_token')->plainTextToken;
        return view('workplace');
    }

    public function logoutUser(request $request)
    {
        $request->user()->tokens()->delete();
        return view('authorize.login');
    }
}
