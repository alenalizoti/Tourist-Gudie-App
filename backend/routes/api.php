<?php
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login',[AuthController::class,"login"])->name('login');
Route::post('/register',[AuthController::class,"register"])->name('register');
Route::post('/logout',[AuthController::class,"logout"])->name('logout');

Route::get('/destinations',[DestinationController::class,"getDestinations"])->name('destinations');
Route::get('/destination/{id}',[DestinationController::class,"getDestination"])->name('destination');
Route::post('/add/destination',[DestinationController::class,"addDestination"])->name('addDestination');
Route::put('/update/destination/{id}',[DestinationController::class,"updateDestination"])->name('UpdateDestination');
Route::delete('/delete/{id}',[DestinationController::class,"deleteDestination"])->name("delDest");

Route::get('/articles',[ArticleController::class,"getArticles"])->name('articles');
Route::get('/article/{id}',[ArticleController::class,"singleArticle"])->name('single.article');
Route::post('/add/article',[ArticleController::class,"addArticle"])->name('add.article');
Route::delete('/delete/article/{id}',[ArticleController::class,"deleteArticle"])->name('deleteArticle');
Route::put('/update/article/{id}',[ArticleController::class,"updateArticle"])->name('updateArticle');

Route::middleware(['role:admin'])->group(function (){
    Route::get('/users',[UserController::class,"getUsers"])->name('users');
    Route::get('/user/{id}',[UserController::class,"getUser"])->name('single.user');
    Route::delete('/delete/user/{id}',[UserController::class,"deleteUser"])->name('delete.user');
    Route::put('/update/user/{id}',[UserController::class,"updateUser"])->name('update.user');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});