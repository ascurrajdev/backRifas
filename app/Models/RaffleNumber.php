<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaffleNumber extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function raffle(){
        return $this->belongsTo(Raffle::class);
    }
}
