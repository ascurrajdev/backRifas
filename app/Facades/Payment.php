<?php
namespace App\Facades;

use App\Services\PaymentService;
use Illuminate\Support\Facades\Facade;

class Payment extends Facade{

    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return PaymentService::class;
    }
}