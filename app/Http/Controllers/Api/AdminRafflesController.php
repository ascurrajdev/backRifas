<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
}
