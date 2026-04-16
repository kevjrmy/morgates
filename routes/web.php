<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/**
 * Pages
 */
/* Homepage */
Route::get('/', function () {
  $listings = \App\Models\Listing::latest()->get();
  return view('pages.home', compact('listings'));
})->name('home');

/* Listings */
Route::get('/listings', function () {
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

  return view('pages.listings.index', compact('listings'));
})->name('listings');

/* Legal */
Route::get('/privacy', function () {
  return view('pages.legal.privacy');
})->name('privacy');

Route::get('/terms', function () {
  return view('pages.legal.terms');
})->name('terms');

Route::get('/about', function () {
  return view('pages.legal.about');
})->name('about');

/**
 * Authentification
 */
Route::middleware('guest')->group(function () {
  Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
  Route::post('/login', [AuthController::class, 'login']);
});
Route::get('/register', function () {
  return view('auth.register');
})->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');