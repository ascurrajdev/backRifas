<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use ResponseTrait;
    public function login(Request $request){
        $request->validate([
            'email' => ['required','exists:users,email'],
            'password' => ['required']
        ]);
        $user = User::where("email",$request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            throw ValidationException::withMessages([
                'email' => 'Las credenciales no coinciden'
            ]);
        }
        $token = $user->createToken($request->email)->plainTextToken;
        return $this->success([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
