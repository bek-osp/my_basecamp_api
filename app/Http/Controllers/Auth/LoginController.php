<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(LoginRequest $request)
    {
        $user = User::firstWhere('email', $request->email);

        if (!$user) {
            throw new AuthException('User not found');
        }

        if (!Hash::check($request->password, $user->password)) {
            throw new AuthException('Password is incorrect');
        }

        $token = $user->createToken($user->name)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }
}
