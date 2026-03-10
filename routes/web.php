<?php

use Illuminate\Support\Facades\Route;

/* Homepage */
Route::get('/', function () {
    $listings = \App\Models\Listing::latest()->get();
    return view('pages.home', compact('listings'));
})->name('home');

/* Search */
Route::get('/search', function () {
  return view('pages.search');
})->name('search');

/* Legal */
Route::get('/privacy', function () {
  return view('pages.privacy');
})->name('privacy');

Route::get('/terms', function () {
  return view('pages.terms');
})->name('terms');

Route::get('/about', function () {
  return view('pages.about');
})->name('about');
