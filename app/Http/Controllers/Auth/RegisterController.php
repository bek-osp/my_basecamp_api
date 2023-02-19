<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $request
     */
    public function index(RegisterRequest $request)
    {
        $request->merge(['password' => Hash::make($request->password)]);

        $user = User::create($request->only('name', 'email', 'password'));

        if (!$user) {
            throw new AuthException('This email is already registered');
        }

        $token = $user->createToken($user->name);

        return response()->json([
            'token' => $token->plainTextToken,
            'user' => $user
        ]);
    }
}
