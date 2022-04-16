<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\FavRatingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/logout', [UserController::class, 'logout'])->middleware(['auth:sanctum']);

Route::get('/films',[FilmController::class,'index']);
Route::post('/films',[FilmController::class,'store'])->middleware(['auth:sanctum',roleChecker::class]);
Route::get('/films/{id}',[FilmController::class,'show']);
Route::put('/films/{id}',[FilmController::class,'update'])->middleware(['auth:sanctum',roleChecker::class]);
Route::delete('/films/{id}',[FilmController::class,'destroy'])->middleware(['auth:sanctum',roleChecker::class]);

Route::get('/statuses',[StatusController::class,'index']);
Route::get('/statuses/{id}',[StatusController::class,'show']);

Route::get('/favorites',[FavRatingController::class,'index'])->middleware(['auth:sanctum',roleChecker::class]);
Route::post('/favorites',[FavRatingController::class,'store'])->middleware(['auth:sanctum']);
Route::get('/favorites/{id}',[FavRatingController::class,'show'])->middleware(['auth:sanctum']);
Route::get('/favorites/{id}/fav',[FavRatingController::class,'showFav'])->middleware(['auth:sanctum']);
Route::put('/favorites/{id}',[FavRatingController::class,'update'])->middleware(['auth:sanctum']);
