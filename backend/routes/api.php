<?php
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login',[AuthController::class,"login"])->name('login');
Route::post('/register',[AuthController::class,"register"])->name('register');
Route::post('/logout',[AuthController::class,"logout"])->name('logout');


Route::middleware(['role:admin,content_creator'])->group(function (){

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
    Route::get('/destination/articles/{id}',[ArticleController::class,"articlesByDestination"])->name('destination.articles');

    Route::get('/articles/activity/{activityId}',[ArticleController::class,"getArticlesByActivity"])->name('activity.articles');
    Route::get('/activities',[ArticleController::class,"getActivities"])->name('activities');


});

Route::middleware(['role:admin'])->group(function (){
    Route::get('/users',[UserController::class,"getUsers"])->name('users');
    Route::get('/user/{id}',[UserController::class,"getUser"])->name('single.user');
    Route::delete('/delete/user/{id}',[UserController::class,"deleteUser"])->name('delete.user');
    Route::put('/update/user/{id}',[UserController::class,"updateUser"])->name('update.user');
});

Route::get('/app/top/articles', [ArticleController::class,'newestArticles'])->name('article.newest');
Route::get('/app/article/{id}', [ArticleController::class,'incrementVisitCount'])->name('read.article');
Route::get('/app/most-read/articles',[ArticleController::class,'mostRead'])->name('most.read');
Route::post('/app/add/comment',[CommentController::class,'storeComment'])->name('comment.store');
Route::get('/app/add/comment/article/{id}',[CommentController::class,'getComments'])->name('comment.index');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});