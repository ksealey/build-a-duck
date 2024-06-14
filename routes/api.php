<?php

use App\Http\Controllers\DuckController;
use Illuminate\Http\Request;
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

Route::prefix('ducks')->middleware('throttle:120,1')->group(function(){
    Route::get('/', [DuckController::class, 'index'])
         ->name('ducks.index');

    Route::post('/', [DuckController::class, 'create'])
         ->name('ducks.create');

    Route::prefix('{duck}')->middleware('can:manage,duck')->group(function(){
        
    });
});