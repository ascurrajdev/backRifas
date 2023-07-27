<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function admin(){
        return $this->belongsToMany(User::class)->using(AdminRaffles::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->using(UserRaffles::class);
    }
}
