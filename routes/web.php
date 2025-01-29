<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Artisan;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LeaderboardController::class, 'index'])->name('leaderboard');
Route::post('/leaderboard/recalculate', function () {
    Artisan::call('leaderboard:recalculate');
    return redirect('/');
})->name('leaderboard.recalculate');