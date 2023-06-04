<?php

use App\Http\Controllers\LotteryDrawWinnerController;
use App\Http\Controllers\LotteryTicketsController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\LotteryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return to_route('home');
});

Route::get('/home', HomepageController::class)->name('home');

Route::resource('/lottery', LotteryController::class);
Route::post('/lottery/{lottery}/tickets', [LotteryTicketsController::class, 'store'])->name('lottery.tickets.create');
Route::get('/lottery/{lottery}/tickets', [LotteryTicketsController::class, 'index'])->name('lottery.tickets.index');
Route::get('/lottery/{lottery}/draw-winner', LotteryDrawWinnerController::class)->name('lottery.draw-winner');
