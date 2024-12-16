<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signUp(AuthRequest $requset)
    {
        $data = $requset->validated();
        $data['password'] = bcrypt($data['password']);

        $admin = Admin::create($data);
        $admin->token = $admin->createToken('User Token');

        return response()->json([
            'user'  => $admin,
            'message' => 'Success user login.'
        ]);
    }

    public function login(AuthRequest $request)
    {
        $data = $request->validated();
        $admin = Admin::where('email', $data['email'])->firstOrFail();

        if (Hash::check($data['password'], $admin->password)) {
            return response()->json([
                'message' => 'Success user login.',
                'admin' => $admin,
                'token' => $admin->createToken('Admin Token')->accessToken
            ]);
        }
      
        return response()->json([
            'message' => 'Fail in user login.'
        ]);
    }
}
