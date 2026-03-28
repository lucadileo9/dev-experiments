<?php

use Illuminate\Support\Facades\Route;
use App\Models\Idea;

Route::get('/', function () {
    return view('welcome',
        [
            'name' => request('name', 'Guest')
        ]
    );
});

// Route::get('/about', function () {
//     return view('about');
// });

// Route::view('/contact', 'contact');

Route::get('/about', function () {
    return view('about', [
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
    ]);
});

Route::view('/contact', 'contact', [
    'title' => 'Contact Us'
]);

// Index
Route::get('/ideas', function () {
    // $ideas = session()->get('ideas', []); 
    // now let's use the database instead of the session
    $ideas = \Illuminate\Support\Facades\DB::table('ideas')->get();

    // $ideas = \Illuminate\Support\Facades\DB::table('ideas')->where('status', 'pending')->get();

    // $ideas = \App\Models\Idea::where('status', 'pending')->get();
    return view('ideas/index', [
        'ideas' => $ideas
    ]);
});

// Store
Route::post('/ideas', function () {
    // $idea = request('idea');
    // session()->push('ideas', $idea);

    // dd(request()->all());
    Idea::create([
        'description' => request('idea'),
        'status' => 'pending'
    ]);
    return redirect('/ideas')->with('message', 'Idea submitted successfully!');

    // dump($_REQUEST);
    // dd($idea);
    // Save the idea to the database or do something with it
    // return redirect('/ideas')->with('message', 'Idea submitted successfully!');
});

/*
Altri modi di prendere la richiesta get sono:
Route::get('/ideas', function (Illuminate\Http\Request $request) {
    $idea = $request->input('idea');
    // ...
});

Route::get('/ideas', function (Illuminate\Http\Request $request) {
    $idea = $request->query('idea');
    // ...
});

Route::get('/ideas', function () {
    request()->all(); // Get all query parameters
    request()->input('idea'); // Get a specific query parameter
    dd(request()->input('idea')); // Dump the value of 'idea' and stop execution

Route::get('/ideas', function () {
    $idea = \Illuminate\Support\Facades\Request::input('idea');

Route::get('/ideas', function (Request $request) {
    $idea = $request->idea;
    */

// Show
Route::get('/ideas/{idea}', function (Idea $idea) {
    return view('ideas/show', [
        'idea' => $idea
    ]);
});

// Edit
Route::get('/ideas/{idea}/edit', function (Idea $idea) {

    return view('ideas/edit', [
            'idea' => $idea
        ]);
});

// Update
Route::patch('/ideas/{idea}/', function (Idea $idea) {
    // dd(request()->all());
    $idea->update([
        'description' => request('idea')
    ]);
    return redirect("/ideas/{$idea->id}")->with('message', 'Idea updated successfully!');
});

// Destroy
Route::delete('/ideas/{idea}', function (Idea $idea) {
    $idea->delete();
    return redirect('/ideas')->with('message', 'Idea deleted successfully!');
});


// Destroy All
Route::delete('/ideas', function () {
    Idea::truncate();
});

Route::get('/register', [\App\Http\Controllers\Auth\RegistredUserController::class, 'create']);

Route::post('/register', [\App\Http\Controllers\Auth\RegistredUserController::class, 'store']);

