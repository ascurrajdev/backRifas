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
}
