<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
}
