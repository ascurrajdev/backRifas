<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;
 
class UserRaffles extends Pivot
{
    use HasUuids;
    public $table = "admin_raffles";
    public $incrementing = false;
}