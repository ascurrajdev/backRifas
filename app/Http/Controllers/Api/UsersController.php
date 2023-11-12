<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSearchRequest;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use ResponseTrait;
    public function search(UserSearchRequest $request){
        $params = $request->validated();
        if(empty($params['limit'])){
            $params['limit'] = 5;
        }
        $users = User::where("email",'like',"%".$params['q']."%")->limit($params['limit'])->get(['id','email','name']);
        return $this->success($users);
    }
}
