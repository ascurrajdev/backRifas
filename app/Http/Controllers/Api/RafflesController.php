<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserRaffle;
use App\Models\RaffleNumber;
use App\Traits\ResponseTrait;

class RafflesController extends Controller
{
    use ResponseTrait;

    public function getDetails($token){
        $userRaffle = UserRaffle::with(['user','raffle'])->findOrFail($token);
        $raffleNumber = RaffleNumber::where('user_id',$userRaffle->user_id)->where('raffle_id',$userRaffle->raffle_id)->orderBy('created_at','desc')->first();
        $number = !empty($raffleNumber) ? $raffleNumber->number : ($userRaffle->min_number - 1);
        if(empty($number)){
            $number = 0;
        }
        if(($userRaffle->max_number - $number) < 1 && !empty($userRaffle->max_number)){
            return $this->error("El link expiro",404);
        }
        return $this->success($userRaffle);
    }
}
