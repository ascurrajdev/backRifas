<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminRaffle;
use App\Models\Client;
use App\Models\Raffle;
use App\Models\UserRaffle;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    use ResponseTrait;
    public function general(Request $request){
        $user = $request->user();
        $rafflesUser = Raffle::where('user_id',$user->id)->get(['id'])->pluck(['id'])->toArray();
        $rafflesForUser = UserRaffle::where('user_id',$user->id)->get(['raffle_id'])->pluck('raffle_id')->toArray();
        $rafflesForAdmin = AdminRaffle::where('user_id',$user->id)->get(['raffle_id'])->pluck('raffle_id')->toArray();
        $raffleIds = array_merge($rafflesForUser,$rafflesForAdmin,$rafflesUser);
        $raffles = Raffle::whereIn("id",$raffleIds)->count();
        $clients = Client::count();
        return $this->success([
            'raffles_count'=>$raffles,
            'clients_count' => $clients
        ]);
    }
}
