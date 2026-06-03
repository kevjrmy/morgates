<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
  private const CLEARABLE_PROFILE_FIELDS = [
    'host_name',
    'phone',
    'country',
    'bio',
    'locale',
  ];

  public function index()
  {
    return view('account.index');
  }

  public function listings()
  {
    $listings = auth()->user()->listings()->latest()->get();

    return view('account.listings.index', compact('listings'));
  }

  public function profile()
  {
    $user = auth()->user();
    $profileCompletion = $this->profileCompletion($user);

    return view('account.profile.profile', compact('user', 'profileCompletion'));
  }

  public function updateProfile(Request $request)
  {
    $user = $request->user();
    $data = $request->validate($this->profileValidationRules($user));

    $user->update($this->normalizeProfileData($data));

    return redirect()->route('account.profile')->with('success', 'Votre profil a été mis à jour.');
  }

  public function updateProfileField(Request $request, string $field)
  {
    $user = $request->user();
    $rules = $this->profileValidationRules($user);

    abort_unless(array_key_exists($field, $rules), 404);

    $data = $request->validate([
      $field => $rules[$field],
    ]);

    $user->update($this->normalizeProfileData($data));

    return redirect()->route('account.profile')->with('success', 'La valeur a été mise à jour.');
  }

  public function clearProfileField(Request $request, string $field)
  {
    abort_unless(in_array($field, self::CLEARABLE_PROFILE_FIELDS, true), 404);

    $data = [
      $field => $field === 'locale' ? $this->defaultValueFor($field) : null,
    ];

    $request->user()->update($data);

    return redirect()->route('account.profile')->with('success', 'La valeur a été supprimée.');
  }

  public function subscriptions()
  {
    $user = auth()->user();
    $listings = $user->listings()->latest()->get();

    $plan = [
      'name' => 'Plan Découverte',
      'status' => 'Actif',
      'ends_at' => now()->addMonth()->locale('fr')->translatedFormat('d F Y'),
      'publication_limit' => 3,
    ];

    return view('account.subscriptions.index', compact('listings', 'plan'));
  }

  private function profileValidationRules($user): array
  {
    return [
      'first_name' => ['required', 'string', 'max:255'],
      'last_name' => ['nullable', 'string', 'max:255'],
      'host_name' => ['nullable', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
      'phone' => ['nullable', 'string', 'max:20'],
      'country' => ['nullable', 'string', 'size:2'],
      'bio' => ['nullable', 'string', 'max:1000'],
      'locale' => ['nullable', 'string', 'max:5'],
    ];
  }

  private function normalizeProfileData(array $data): array
  {
    if (array_key_exists('email', $data)) {
      $data['email'] = strtolower($data['email']);
    }

    if (array_key_exists('first_name', $data) || array_key_exists('last_name', $data)) {
      $firstName = $data['first_name'] ?? auth()->user()?->first_name;
      $lastName = $data['last_name'] ?? auth()->user()?->last_name;
      $data['name'] = trim(collect([$firstName, $lastName])->filter()->implode(' ')) ?: null;
    }

    if (array_key_exists('country', $data)) {
      $data['country'] = $data['country'] ? strtoupper($data['country']) : null;
    }

    if (array_key_exists('locale', $data)) {
      $data['locale'] = $data['locale'] ?: 'fr';
    }

    return $data;
  }

  private function profileCompletion($user): int
  {
    $missingFields = collect(['first_name', 'phone', 'country', 'bio'])
      ->filter(fn($field) => empty($user->$field))
      ->count();

    return (int) round((4 - $missingFields) / 4 * 100);
  }

  private function defaultValueFor(string $field): ?string
  {
    return [
      'locale' => 'fr',
    ][$field] ?? null;
  }
}
