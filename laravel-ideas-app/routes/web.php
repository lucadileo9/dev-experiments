<?php

use App\Models\Idea;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // $ideas = Idea::latest()->take(6)->get();

    return view('welcome', );
});
