<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.homepage');
});
Route::get('/register', function () {
    return view('home.register');
});
Route::get('/login', function () {
    return view('home.login');
});
Route::get('/about', function () {
    return view('home.about');
});
