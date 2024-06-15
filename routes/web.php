<?php

use App\Http\Controllers\DuckController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::user()){
        return to_route('ducks.create');
    }

    return to_route('login');
});

Route::middleware('throttle:120,1', 'auth')->group(function () {
    Route::prefix('profile')->group(function(){
        Route::get('/', [ProfileController::class, 'edit'])
             ->name('profile.edit');

        Route::patch('/', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/', [ProfileController::class, 'destroy'])
             ->name('profile.destroy');
    });

    Route::prefix('ducks')->group(function(){
        Route::get('/', [DuckController::class, 'index'])
             ->name('ducks.index');

        Route::get('/create', [DuckController::class, 'create'])
             ->name('ducks.create');

        Route::post('/create', [DuckController::class, 'store'])
             ->name('ducks.store');
    
        Route::prefix('{duckId}')->group(function(){
            Route::get('/', [DuckController::class, 'view'])
                 ->name('ducks.view');

            Route::get('/download', [DuckController::class, 'download'])
                 ->name('ducks.download');
        });
    });
});

require __DIR__.'/auth.php';
