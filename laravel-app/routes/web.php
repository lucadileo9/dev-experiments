<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\Auth\RegistredUserController;
use App\Http\Controllers\Auth\SessionController;
use Illuminate\Container\Attributes\Auth;

// ============================================================
// PUBLIC ROUTES (no authentication required)
// ============================================================

Route::get('/', function () {
    return view('welcome',
        [
            'name' => request('name', 'Guest')
        ]
    );
})->name('home');

Route::get('/about', function () {
    return view('about', [
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
    ]);
})->name('about');

Route::view('/contact', 'contact', [
    'title' => 'Contact Us'
])->name('contact');

// ============================================================
// REGISTRATION ROUTES
// ============================================================

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegistredUserController::class, 'create'])->name('register.create');
    Route::post('/register', [RegistredUserController::class, 'store'])->name('register.store');
    Route::get('/login', [SessionController::class, 'create']);
    Route::post('/login', [SessionController::class, 'store']);
});

// ============================================================
// IDEAS ROUTES 
// ============================================================


Route::middleware('auth')->prefix('/ideas')->group(function () {
        // List all ideas
        Route::get('/', [IdeaController::class, 'index'])
            ->name('ideas.index');
        
        // Show create form (if needed in future)
        Route::get('/create', [IdeaController::class, 'create'])
            ->name('ideas.create');
        
        // Store new idea
        Route::post('/', [IdeaController::class, 'store'])
            ->name('ideas.store');
        
        // Show single idea
        Route::get('/{idea}', [IdeaController::class, 'show'])
            ->name('ideas.show');
        
        // Show edit form
        Route::get('/{idea}/edit', [IdeaController::class, 'edit'])
            ->name('ideas.edit');
        
        // Update idea
        Route::patch('/{idea}', [IdeaController::class, 'update'])
            ->name('ideas.update');
        
        // Delete idea
        Route::delete('/{idea}', [IdeaController::class, 'destroy'])
            ->name('ideas.destroy');

        // Logout
        Route::post('/logout', [SessionController::class, 'destroy'])
            ->name('logout');
});

// ============================================================
// SETUP FOR FUTURE: AUTH-PROTECTED IDEAS (example)
// ============================================================
// To enable authentication on ideas, replace the group above with:
//
// Route::middleware(['auth'])->group(function () {
//     Route::resource('ideas', IdeaController::class)
//         ->names([
//             'index' => 'ideas.index',
//             'create' => 'ideas.create',
//             'store' => 'ideas.store',
//             'show' => 'ideas.show',
//             'edit' => 'ideas.edit',
//             'update' => 'ideas.update',
//             'destroy' => 'ideas.destroy',
//         ]);
// });
