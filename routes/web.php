<?php

use Illuminate\Support\Facades\Route;

/* Homepage */
Route::get('/', function () {
  $listings = \App\Models\Listing::latest()->get();
  return view('pages.home', compact('listings'));
})->name('home');

/* Search */
Route::get('/search', function () {
  $query = \App\Models\Listing::query();

  if (request('type')) {
    $query->where('type', request('type'));
  }

  if (request('city')) {
    $query->where('city', request('city'));
  }

  if (request('q')) {
    $query->where(function ($q) {
      $q->where('title', 'like', '%' . request('q') . '%')
        ->orWhere('description', 'like', '%' . request('q') . '%')
        ->orWhere('city', 'like', '%' . request('q') . '%');
    });
  }

  if (request('tag')) {
    $query->whereJsonContains('tags', request('tag'));
  }

  $listings = $query->latest()->get();

  return view('pages.search', compact('listings'));
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
