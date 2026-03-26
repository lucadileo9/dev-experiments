<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/ideas', function () {
    $ideas = session()->get('ideas', []);

    return view('ideas', [
        'ideas' => $ideas
    ]);
});

Route::post('/ideas', function () {
    $idea = request('idea');
    session()->push('ideas', $idea);
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
