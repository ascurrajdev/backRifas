<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Relations\Pivot;
 
class AdminRaffles extends Pivot
{
    public $table = "admin_raffles";
    public $incrementing = true;
}