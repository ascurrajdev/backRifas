<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminRaffle extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $table = "admin_raffles";

    public function raffle(){
        return $this->belongsTo(Raffle::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
