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

  if (request('region')) {
    $query->where('region', request('region'));
  }

  if (request('q')) {
    $query->where(function ($q) {
      $q->where('title', 'like', '%' . request('q') . '%')
        ->orWhere('description', 'like', '%' . request('q') . '%')
        ->orWhere('city', 'like', '%' . request('q') . '%')
        ->orWhereHas('user', function ($u) {
          $u->where('name', 'like', '%' . request('q') . '%');
        });
    });
  }

  if (request('tag')) {
    $query->whereJsonContains('tags', request('tag'));
  }

  // Store price_unit in session when filter is applied
  if (request('price_unit')) {
    session(['price_unit' => request('price_unit')]);
  }
  $priceUnit = request('price_unit') ?: session('price_unit', 'night');

  // Price filtering with unit normalization
  $priceMin = request('price_min');
  $priceMax = request('price_max');

  if ($priceMin || $priceMax) {
    // Include known-price listings in range OR trip/contact listings (they'll be sorted to bottom)
    $query->where(function ($q) use ($priceMin, $priceMax) {
      $q->whereNotIn('price_unit', ['trip', 'contact'])
        ->whereRaw("CASE
          WHEN price_unit IN ('night', 'day') THEN price_amount * 7
          WHEN price_unit = 'week' THEN price_amount
          WHEN price_unit = 'month' THEN price_amount / 4.33
          ELSE price_amount
        END BETWEEN ? AND ?", [$priceMin ?: 0, $priceMax ?: 999999]);
    });
  }

  if (request('capacity')) {
    $query->where('capacity', '>=', (int) request('capacity'));
  }

  // Sort: known-price listings first (sorted by normalized price), then trip/contact at bottom
  match (request('sort')) {
    'price_asc' => $query
      ->orderByRaw("CASE WHEN price_unit IN ('trip', 'contact') THEN 1 ELSE 0 END")
      ->orderByRaw("CASE
        WHEN price_unit IN ('night', 'day') THEN price_amount * 7
        WHEN price_unit = 'week' THEN price_amount
        WHEN price_unit = 'month' THEN price_amount / 4.33
        ELSE NULL
      END"),
    'price_desc' => $query
      ->orderByRaw("CASE WHEN price_unit IN ('trip', 'contact') THEN 1 ELSE 0 END")
      ->orderByRaw("CASE
        WHEN price_unit IN ('night', 'day') THEN price_amount * 7
        WHEN price_unit = 'week' THEN price_amount
        WHEN price_unit = 'month' THEN price_amount / 4.33
        ELSE NULL
      END DESC"),
    default => $query->latest(),
  };

  $listings = $query->get();

  return view('pages.listings.index', compact('listings'));
})->name('listings');

/* Listing */
Route::get('/annonces/{listing:slug}', function (\App\Models\Listing $listing) {
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

/* Contact */
Route::get('/contact', function () {
  return view('pages.contact');
})->name('contact');

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
Route::get('/mon-espace/abonnements', [AccountController::class, 'subscriptions'])->name('account.subscriptions.index')->middleware('auth');

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
