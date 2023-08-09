<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRaffle;
use App\Http\Resources\AdminRaffleResource;
use App\Models\AdminRaffle;
use App\Models\Raffle;
use Illuminate\Http\Request;

class AdminRafflesController extends Controller
{
    public function index(){
        $this->authorize("viewAny",AdminRaffle::class);
        return AdminRaffleResource::collection(AdminRaffle::get());
    }
    
    public function show(Raffle $raffle, AdminRaffle $adminRaffle){
        $this->authorize("viewAny",AdminRaffle::class);
        return new AdminRaffleResource($adminRaffle);
    }

    public function store(Raffle $raffle, StoreAdminRaffle $request){
        $this->authorize("create",AdminRaffle::class);
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
