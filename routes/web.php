<?php

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ListingController;
use App\Models\Destination;
use App\Models\Listing;

/**
 * Pages
 */
/* Homepage */
Route::get('/', function () {
  $listings = Listing::latest()->get();
  return view('pages.home', compact('listings'));
})->name('home');

/* Listings */
Route::get('/annonces', function () {
  $query = Listing::query();

  if (request('type')) {
    $query->where('type', request('type'));
  }

  if (request('city')) {
    $city = trim(request('city'));

    if (request()->boolean('include_nearby')) {
      $destination = Destination::query()
        ->whereRaw('LOWER(name) = ?', [strtolower($city)])
        ->where('country', 'FR')
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->first();

      if ($destination) {
        $query
          ->whereNotNull('latitude')
          ->whereNotNull('longitude')
          ->whereRaw("
            (6371 * acos(
              cos(radians(?)) * cos(radians(latitude)) *
              cos(radians(longitude) - radians(?)) +
              sin(radians(?)) * sin(radians(latitude))
            )) <= 20
          ", [$destination->latitude, $destination->longitude, $destination->latitude]);
      } else {
        $query->whereRaw('LOWER(city) = ?', [strtolower($city)]);
      }
    } else {
      $query->whereRaw('LOWER(city) = ?', [strtolower($city)]);
    }
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
          $term = '%' . request('q') . '%';
          $u->where('first_name', 'like', $term)
            ->orWhere('last_name', 'like', $term)
            ->orWhere('host_name', 'like', $term);
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

  // Price filtering with unit normalization
  $priceMin = request('price_min');
  $priceMax = request('price_max');

  if ($priceMin || $priceMax) {
    // Include known-price listings in range and keep contact-price listings out of numeric comparisons
    $query->where(function ($q) use ($priceMin, $priceMax) {
      $q->where('price_unit', '!=', 'contact')
        ->whereRaw("CASE
          WHEN price_unit = 'hour' THEN price_amount * 24 * 7
          WHEN price_unit = 'half-day' THEN price_amount * 2 * 7
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

  // Sort: known-price listings first (sorted by normalized price), then contact-price listings at bottom
  match (request('sort')) {
    'price_asc' => $query
      ->orderByRaw("CASE WHEN price_unit = 'contact' THEN 1 ELSE 0 END")
      ->orderByRaw("CASE
        WHEN price_unit = 'hour' THEN price_amount * 24 * 7
        WHEN price_unit = 'half-day' THEN price_amount * 2 * 7
        WHEN price_unit IN ('night', 'day') THEN price_amount * 7
        WHEN price_unit = 'week' THEN price_amount
        WHEN price_unit = 'month' THEN price_amount / 4.33
        ELSE NULL
      END"),
    'price_desc' => $query
      ->orderByRaw("CASE WHEN price_unit = 'contact' THEN 1 ELSE 0 END")
      ->orderByRaw("CASE
        WHEN price_unit = 'hour' THEN price_amount * 24 * 7
        WHEN price_unit = 'half-day' THEN price_amount * 2 * 7
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

/* Listing suggestions API (autocomplete) */
Route::get('/api/listings/suggest', function () {
  $q = trim(request('q', ''));
  if (strlen($q) < 2) return response()->json([]);

  $results = Listing::query()
    ->with('user:id,name,first_name,last_name,host_name')
    ->where(function ($query) use ($q) {
      $term = '%' . $q . '%';
      $query->where('title', 'like', $term)
        ->orWhereHas('user', function ($u) use ($term) {
          $u->where('first_name', 'like', $term)
            ->orWhere('last_name', 'like', $term)
            ->orWhere('host_name', 'like', $term);
        });
    })
    ->where('is_active', true)
    ->orderByRaw('CASE WHEN title LIKE ? THEN 0 ELSE 1 END', ['%' . $q . '%'])
    ->orderBy('title')
    ->limit(8)
    ->get(['id', 'title', 'slug', 'type', 'city', 'user_id'])
    ->map(fn($l) => [
      'title' => $l->title,
      'slug'  => $l->slug,
      'type'  => $l->typeLabel(),
      'owner' => $l->user?->display_host_name,
      'city'  => $l->city,
      'url'   => route('listing', $l),
    ]);

  return response()->json($results);
})->name('api.listings.suggest');

/* Listing city API (autocomplete) */
Route::get('/api/listings/cities', function () {
  $q = trim(request('q', ''));
  if (strlen($q) < 2) return response()->json([]);

  $url = 'https://geo.api.gouv.fr';
  $qEncoded = urlencode($q);

  $responses = Http::pool(fn (Pool $pool) => [
    $pool->get("$url/communes?nom=$qEncoded&fields=nom,region,departement&boost=population&limit=5"),
    $pool->get("$url/departements?nom=$qEncoded&fields=nom,region&limit=3"),
    $pool->get("$url/regions?nom=$qEncoded&fields=nom&limit=2"),
  ]);

  $communes = $responses[0]->ok() ? $responses[0]->json() : [];
  $departements = $responses[1]->ok() ? $responses[1]->json() : [];
  $regions = $responses[2]->ok() ? $responses[2]->json() : [];

  $results = [];

  foreach ($regions as $r) {
    $results[] = ['type' => 'region', 'name' => $r['nom'], 'region' => 'Région'];
  }
  foreach ($departements as $d) {
    $results[] = ['type' => 'department', 'name' => $d['nom'], 'region' => $d['region']['nom'] ?? 'Département'];
  }
  foreach ($communes as $c) {
    $results[] = ['type' => 'city', 'name' => $c['nom'], 'region' => $c['departement']['nom'] ?? ($c['region']['nom'] ?? '')];
  }

  return response()->json($results);
})->name('api.listings.cities');

/* Listing */
Route::get('/annonces/{listing:slug}', function (Listing $listing) {
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
Route::middleware('auth')->group(function () {
  Route::get('/mon-espace', [AccountController::class, 'index'])->name('account');
  Route::get('/mon-espace/profil', [AccountController::class, 'profile'])->name('account.profile');
  Route::put('/mon-espace/profil', [AccountController::class, 'updateProfile'])->name('account.profile.update');
  Route::put('/mon-espace/profil/{field}', [AccountController::class, 'updateProfileField'])->name('account.profile.field.update');
  Route::delete('/mon-espace/profil/{field}', [AccountController::class, 'clearProfileField'])->name('account.profile.clear');
  Route::get('/mon-espace/abonnements', [AccountController::class, 'subscriptions'])->name('account.subscriptions.index');
});

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
