<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function detail(){
        return $this->hasMany(DetailCollection::class);
    }

    public function detailPayment(){
        return $this->hasMany(PaymentCollection::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function raffleNumbers(){
        return $this->hasMany(RaffleNumber::class);
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s'
    ];
}
