<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signUp(AuthRequest $requset)
    {
        $data = $requset->validated();
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $user->token = $user->createToken('User Token');

        return response()->json([
            'user'  => $user,
            'message' => 'Success user login.'
        ]);
    }

    public function login(AuthRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->firstOrFail();

        if (Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Success user login.',
                'user' => $user,
                'token' => $user->createToken('User Token')->accessToken
            ]);
        }
      
        return response()->json([
            'message' => 'Fail in user login.'
        ]);
    }
}
