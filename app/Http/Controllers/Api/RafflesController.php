<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserRaffle;
use App\Traits\ResponseTrait;

class RafflesController extends Controller
{
    use ResponseTrait;

    public function getDetails($token){
        $userRaffle = UserRaffle::with(['user','raffle'])->findOrFail($token);
        return $this->success($userRaffle);
    }
}
