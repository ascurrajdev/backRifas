<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Raffle extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function admin(){
        return $this->belongsToMany(User::class,"admin_raffles");
    }

    public function users(){
        return $this->belongsToMany(User::class,"user_raffles");
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function numbers(){
        return $this->hasMany(RaffleNumber::class);
    }
}
