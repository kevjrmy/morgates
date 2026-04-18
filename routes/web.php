<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;

/**
 * Pages
 */
/* Homepage */
Route::get('/', function () {
  $listings = \App\Models\Listing::latest()->get();
  return view('pages.home', compact('listings'));
})->name('home');

/* Annonces */
Route::get('/annonces', function () {
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

/* Légal */
Route::get('/confidentialite', function () {
  return view('pages.legal.privacy');
})->name('privacy');

Route::get('/conditions-utilisation', function () {
  return view('pages.legal.terms');
})->name('terms');

Route::get('/a-propos', function () {
  return view('pages.legal.about');
})->name('about');

/**
 * Authentification
 */
Route::middleware('guest')->group(function () {
  Route::view('/connexion', 'auth.login')->name('login');
  Route::post('/connexion', [AuthController::class, 'login']);

  Route::view('/inscription', 'auth.register')->name('register');
  Route::post('/inscription', [AuthController::class, 'register']);
});

Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/**
 * Compte
 */
Route::get('/mon-espace', [AccountController::class, 'index'])->name('account')->middleware('auth');