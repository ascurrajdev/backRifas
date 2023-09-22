<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Raffle;
use Illuminate\Http\Request;
use App\Models\UserRaffle;
use App\Traits\ResponseTrait;

class UserRafflesController extends Controller
{
    use ResponseTrait;
    public function getDetails(string $uuid){
        $detail = UserRaffle::with(['user','raffle'])->findOrFail($uuid);
        return $this->success($detail);
    }

    public function index(Raffle $raffle){
        $usersRaffle = UserRaffle::with(['user'])->where('raffle_id',$raffle->id)->get();
        return $this->success($usersRaffle);
    }
}
