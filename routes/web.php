<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
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

Route::get('/', [ClientController::class,'index'])->name('client.index');
Route::get('/match/{slug}', [ClientController::class,'show'])->name('client.show');

Auth::routes(['register' => false]);

Route::prefix('admin')->middleware(['auth','logincontrol'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('/league', LeagueController::class)->except(['create', 'show'])->middleware('can:Admin');
    Route::resource('/player', PlayerController::class)->except(['create', 'show'])->middleware('can:Admin');
    Route::resource('/team', TeamController::class)->except(['show'])->middleware('can:Admin');
    Route::resource('/match', MatchController::class)->middleware('can:Admin');
    Route::resource('/user', UserController::class)->except('show')->middleware('can:Admin');
    Route::post('goal/store', [GoalController::class, 'store'])->name('goal.store')->middleware('can:Admin');
    Route::post('goal/update', [GoalController::class, 'update'])->name('goal.update')->middleware('can:Admin');
    Route::post('/match/statuschange/{slug}', [MatchController::class,'statuschange'])->name('match.statuschange')->middleware('can:Admin');
});
