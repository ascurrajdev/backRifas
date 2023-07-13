<?php

use App\Http\Controllers\Api\ClientsController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PaymentLinksController;
use App\Http\Controllers\Api\RafflesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login',[LoginController::class,'login'])->name('login');
Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('clients')->group(function(){
        Route::get('',[ClientsController::class, 'index'])->withoutMiddleware('auth:sanctum');
        Route::get('{client}',[ClientsController::class, 'show'])->withoutMiddleware('auth:sanctum');
        Route::post('',[ClientsController::class, 'store'])->withoutMiddleware('auth:sanctum');
        Route::delete('{client}',[ClientsController::class, 'delete']);
    });
    Route::apiResource("raffles",RafflesController::class);
    Route::get('raffles/details/{token}',[RafflesController::class, 'getDetails'])->withoutMiddleware('auth:sanctum');
});
Route::prefix('payments')->group(function(){
    Route::post('generate',[PaymentLinksController::class,'generateLink']);
    Route::post("tpago/callback",[PaymentLinksController::class,'callback']);
});