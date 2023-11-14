<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    use ResponseTrait;
    public function logout(Request $request){
        $accessToken = $request->user()->currentAccessToken();
        $accessToken->delete();
        return response()->noContent();
    }
}
