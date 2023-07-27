<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRaffle extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = [];
    public $table = "user_raffles";

    public function raffle(){
        return $this->belongsTo(Raffle::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
