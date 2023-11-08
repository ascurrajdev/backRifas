<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRaffle;
use App\Http\Resources\AdminRaffleResource;
use App\Models\AdminRaffle;
use App\Models\Raffle;

class AdminRafflesController extends Controller
{
    public function index($raffle){
        $this->authorize("viewAny",[AdminRaffle::class, $raffle]);
        return AdminRaffleResource::collection(AdminRaffle::with('user')->where('raffle_id',$raffle)->get());
    }
    
    public function show(Raffle $raffle, AdminRaffle $adminRaffle){
        $this->authorize("view",$adminRaffle);
        $adminRaffle->load('user');
        return new AdminRaffleResource($adminRaffle);
    }

    public function store(Raffle $raffle, StoreAdminRaffle $request){
        $this->authorize("create",[AdminRaffle::class,$raffle->id]);
        $params = $request->validated();
        $params["raffle_id"] = $raffle->id;
        $adminRaffle = AdminRaffle::create($params);
        return new AdminRaffleResource($adminRaffle);
    }

    public function delete(Raffle $raffle, AdminRaffle $adminRaffle){
        $this->authorize("delete",$adminRaffle);
        $adminRaffle->delete();
        return new AdminRaffleResource($adminRaffle);
    }
}
