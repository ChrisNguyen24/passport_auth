<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserLogin;
use App\Http\Requests\UserRegister;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    //dang ki
    public function register(UserRegister $request)
    {
        $validated =  $request->validated();
        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);
        return response()->json(['user' => $user, 'msg' => 'dang ky thanh cong', 201]);
    }

    //dang nhap
    public function login(UserLogin $request)
    {
        $validated  = $request->validated();
        if (auth()->attempt($validated)) {
            $user = auth()->user();
            $token = $user->createToken($user)->accessToken;
            return response()->json(['user' => $user, 'msg' => 'dang nhap ok', 'token' => $token]);
        } else {
            return response()->json(['msg' => 'dang nhap fails']);
        }
    }
    
    //get me
    public function getMe(){
        $user = auth()->user();
        return response()->json(['user'=>$user,'code' => 200]);
    }
}
