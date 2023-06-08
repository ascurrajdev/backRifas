<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRaffle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function raffle(){
        return $this->belongsTo(Raffle::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
