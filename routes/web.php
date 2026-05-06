<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ListingController;

/**
 * Pages
 */
/* Homepage */
Route::get('/', function () {
  $listings = \App\Models\Listing::latest()->get();
  return view('pages.home', compact('listings'));
})->name('home');

/* Listings */
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

/* Listing */
Route::get('/annonces/{listing}', function (\App\Models\Listing $listing) {
  $listing->load('user');
  return view('pages.listings.show', compact('listing'));
})->name('listing');

/* Legal */
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
  Route::post('/inscription', [AuthController::class, 'register'])->middleware('throttle:5,1');
});

Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/**
 * Account
 */
Route::get('/mon-espace', [AccountController::class, 'index'])->name('account')->middleware('auth');

/* Onboarding */
Route::middleware('auth')->prefix('bienvenue')->name('onboarding.')->group(function () {
  Route::get('/', fn() => view('account.onboarding.index'))->name('index');
  Route::post('/nom', [OnboardingController::class, 'saveName'])->name('name');
  Route::post('/photo', [OnboardingController::class, 'savePicture'])->name('picture');
  Route::post('/tel', [OnboardingController::class, 'savePhone'])->name('phone');
  Route::post('/pays', [OnboardingController::class, 'saveCountry'])->name('country');
  Route::post('/bio', [OnboardingController::class, 'saveBio'])->name('bio');
});

/* Listing creation */
Route::middleware('auth')->prefix('mon-espace/publier')->name('listings.create.')->group(function () {
  Route::get('/', [ListingController::class, 'create'])->name('index');
  Route::post('/type', [ListingController::class, 'storeType'])->name('type');
  Route::post('/localisation', [ListingController::class, 'storeLocation'])->name('location');
  Route::post('/informations', [ListingController::class, 'storeBasics'])->name('basics');
  Route::post('/details', [ListingController::class, 'storeDetails'])->name('details');
  Route::post('/description', [ListingController::class, 'storeDescription'])->name('description');
  Route::post('/photos', [ListingController::class, 'storePhotos'])->name('photos');
});