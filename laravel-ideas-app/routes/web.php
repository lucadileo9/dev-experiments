<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\StepController;
use App\Models\Idea;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $ideas = Idea::with('user')->latest()->take(6)->get();

    return view('welcome', compact('ideas'));
});

// Ideas routes
Route::middleware('auth')->group(function () {
    Route::resource('ideas', IdeaController::class)->except(['create', 'edit']);

    Route::patch('/steps/{step}/toggle', [StepController::class, 'toggle'])->name('steps.toggle');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
