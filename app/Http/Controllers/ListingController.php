<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
  private int $totalSteps = 6;

  public function create(Request $request)
  {
    $step = (int) $request->query('step', 1);
    $step = max(1, min($step, $this->totalSteps));

    $view = match($step) {
      1 => 'account.create.step-1-type',
      2 => 'account.create.step-2-location',
      3 => 'account.create.step-3-basics',
      4 => 'account.create.step-4-details',
      5 => 'account.create.step-5-description',
      6 => 'account.create.step-6-photos',
    };

    $listingData = $request->session()->get('listing_create', []);
    $listing = (object) $listingData;

    return view($view, [
      'step'       => $step,
      'totalSteps' => $this->totalSteps,
      'listing'    => $listing,
    ]);
  }

  public function storeType(Request $request)
  {
    $validated = $request->validate([
      'type'  => ['required', 'in:boats,stays'],
      'title' => ['required', 'string', 'max:100'],
    ]);

    $request->session()->put('listing_create.type', $validated['type']);
    $request->session()->put('listing_create.title', $validated['title']);
    return redirect()->route('listings.create.index', ['step' => 2]);
  }

  public function storeLocation(Request $request)
  {
    $validated = $request->validate([
      'country' => ['required', 'string', 'size:2'],
      'region' => ['nullable', 'string', 'max:100'],
      'city' => ['required', 'string', 'max:100'],
      'latitude' => ['nullable', 'numeric'],
      'longitude' => ['nullable', 'numeric'],
      'address' => ['nullable', 'string', 'max:255'],
      'map_url' => ['nullable', 'url', 'max:255'],
    ]);

    foreach ($validated as $key => $value) {
      $request->session()->put('listing_create.'.$key, $value);
    }
    return redirect()->route('listings.create.index', ['step' => 3]);
  }

  public function storeBasics(Request $request)
  {
    $type = $request->session()->get('listing_create.type', 'stays');
    $priceUnits = $type === 'boats'
      ? ['hour', 'half-day', 'day', 'week', 'month', 'contact']
      : ['day', 'week', 'month', 'contact'];

    $validated = $request->validate([
      'price_amount'  => ['nullable', 'numeric', 'min:1'],
      'price_unit'    => ['required', 'in:' . implode(',', $priceUnits)],
      'capacity'      => ['required', 'integer', 'min:1', 'max:50'],
      'min_duration'  => ['required', 'integer', 'min:1', 'max:365'],
      'max_duration'  => ['nullable', 'integer', 'min:1', 'max:365'],
    ]);

    foreach ($validated as $key => $value) {
      $request->session()->put('listing_create.'.$key, $value);
    }
    return redirect()->route('listings.create.index', ['step' => 4]);
  }

  public function storeDetails(Request $request)
  {
    $validated = $request->validate([
      'tags'               => ['nullable', 'array'],
      'contact_email'      => ['nullable', 'email', 'max:255'],
      'contact_phone'      => ['nullable', 'string', 'max:50'],
      'contact_whatsapp'   => ['nullable', 'string', 'max:50'],
      'contact_website'    => ['nullable', 'url', 'max:255'],
      'preferred_contact'  => ['required', 'in:email,phone,whatsapp,website'],
    ]);

    foreach ($validated as $key => $value) {
      $request->session()->put('listing_create.'.$key, $value);
    }
    return redirect()->route('listings.create.index', ['step' => 5]);
  }

  public function storeDescription(Request $request)
  {
    $validated = $request->validate([
      'description' => ['nullable', 'string', 'max:1000'],
    ]);

    $request->session()->put('listing_create.description', $validated['description'] ?? null);
    return redirect()->route('listings.create.index', ['step' => 6]);
  }

  public function storePhotos(Request $request)
  {
    $data = $request->session()->get('listing_create', []);

    if (empty($data['title']) || empty($data['city'])) {
        return redirect()->route('listings.create.index')->with('error', 'Veuillez remplir les informations manquantes.');
    }

    $slug = Str::slug($data['title']);
    $originalSlug = $slug;
    $count = 1;
    while (Listing::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $count;
        $count++;
    }

    $listing = Listing::create([
        'user_id' => Auth::id(),
        'type' => $data['type'] ?? 'stays',
        'title' => $data['title'],
        'slug' => $slug,
        'description' => $data['description'] ?? null,
        'price_amount' => $data['price_amount'] ?? null,
        'price_unit' => $data['price_unit'] ?? 'day',
        'capacity' => $data['capacity'] ?? null,
        'min_duration' => $data['min_duration'] ?? null,
        'max_duration' => $data['max_duration'] ?? null,
        'country' => $data['country'] ?? 'FR',
        'region' => $data['region'] ?? null,
        'city' => $data['city'] ?? '',
        'latitude' => $data['latitude'] ?? null,
        'longitude' => $data['longitude'] ?? null,
        'tags' => $data['tags'] ?? [],
        'address' => $data['address'] ?? null,
        'map_url' => $data['map_url'] ?? null,
        'contact_email' => $data['contact_email'] ?? null,
        'contact_phone' => $data['contact_phone'] ?? null,
        'contact_whatsapp' => $data['contact_whatsapp'] ?? null,
        'contact_website' => $data['contact_website'] ?? null,
        'preferred_contact' => $data['preferred_contact'] ?? 'email',
        'is_active' => true,
    ]);

    if (!empty($data['city']) && !empty($data['latitude'])) {
        Destination::firstOrCreate(
            ['name' => $data['city'], 'country' => $data['country'] ?? 'FR'],
            [
                'type' => 'city',
                'region' => $data['region'] ?? null,
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'] ?? null,
            ]
        );
    }

    $request->session()->forget('listing_create');

    return redirect()->route('account')->with('success', 'Annonce créée avec succès !');
  }
}