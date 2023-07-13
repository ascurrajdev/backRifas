<?php

namespace App\Http\Controllers\Api;

use App\Models\Raffle;
use App\Models\UserRaffle;
use App\Models\RaffleNumber;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Requests\StoreRaffle;
use App\Http\Requests\UpdateRaffle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class RafflesController extends Controller
{
    use ResponseTrait;

    public function index(Request $request){
        $raffles = Raffle::query();
        $user = $request->user();
        $rafflesForUser = UserRaffle::where('user_id',$user->id)->get(['id'])->pluck('id')->toArray();
        $raffles->where("id",$rafflesForUser);
        foreach($request->input('filters',[]) as $key => $value){
            $raffles->{$key}($value);
        }
        return $raffles->get();
    }

    public function show(Raffle $raffle){
        return $raffle;
    }

    public function store(StoreRaffle $request){
        $params = $request->validated();
        if($request->hasFile("image")){
            $params["image_url"] = Storage::url($request->file('image')->store("raffles"));
            unset($params['image']);
        }
        $raffle = Raffle::create($params);
        return $raffle;
    }

    public function update(Raffle $raffle, UpdateRaffle $request){
        $params = $request->validated();
    }
    public function delete(Raffle $raffle){
        $raffle->delete();
        return $raffle;
    }

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
