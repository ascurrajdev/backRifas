<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRaffleRequest;
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

    public function store(Raffle $raffle,UserRaffleRequest $request){
        $params = $request->validated();
        $userRaffle = UserRaffle::create([
            'min_number' => $params['min_number'],
            'max_number' => $params['max_number'],
            'raffle_id' => $raffle->id,
            'user_id' => $params['user_id']
        ]);
        return $this->success($userRaffle);
    }

    public function destroy(Raffle $raffle, UserRaffle $userRaffle){
        $userRaffle->delete();
        return $this->success($userRaffle);
    }
}
