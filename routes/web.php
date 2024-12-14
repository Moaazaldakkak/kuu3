<?php

use App\Http\Controllers\Kuu3ProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/*
Route::get('/profiles', [Kuu3ProfileController::class, 'index'])->name('profiles.index');
Route::get('/profiles/add', [Kuu3ProfileController::class, 'create'])->name('profiles.create');
Route::post('/profiles/store', [Kuu3ProfileController::class, 'store'])->name('profiles.store');
Route::delete('/profiles/{profile}', [Kuu3ProfileController::class, 'destroy'])->name('profiles.destroy');
Route::get('/profiles/{profile}', [Kuu3ProfileController::class, 'show'])->name('profiles.show');
Route::get('/profiles/{profile}/edit', [Kuu3ProfileController::class, 'edit'])->name('profiles.edit');
Route::patch('/profiles/{profile}/update', [Kuu3ProfileController::class, 'update'])->name('profiles.update');
*/

// Profiles routes
Route::resource('profiles', Kuu3ProfileController::class);

Route::post('/profiles/{profile}/comments', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('profiles.comments.store');

Route::delete('/profiles/{profile}/comments/{comment}', [CommentController::class, 'destroy'])
->middleware('auth')
->name('profiles.comments.destroy');

require __DIR__.'/auth.php';