<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function scopeName($query,$name){
        $query->where('name','ilike',$name);
    }
    public function scopeEmail($query,$email){
        $query->where('email','ilike',$email);
    }
    public function scopeCellphone($query,$cellphone){
        $query->where('cellphone','ilike',$cellphone);
    }
}
