<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DestinationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login',[AuthController::class,"login"])->name('login');
Route::post('/register',[AuthController::class,"register"])->name('register');
Route::post('/logout',[AuthController::class,"logout"])->name('logout');
Route::get('/destinations',[DestinationController::class,"getDestinations"])->name('destinations');
Route::delete('/delete/{id}',[DestinationController::class,"deleteDestination"])->name("delDest");
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});