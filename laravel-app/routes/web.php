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
