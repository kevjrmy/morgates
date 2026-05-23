{{--
  listings/create/step-2-location.blade.php
  Step 2: Where is the listing?
--}}
@extends('layouts.listing-create')

@section('title', 'Localisation — Publier une annonce')

@section('content')
  <div class="lc-step">
    <div class="lc-step-header">
      <h1 class="lc-title">Où se situe votre bien ?</h1>
      <p class="lc-subtitle">Ces informations aident les voyageurs à vous trouver.</p>
    </div>

    <form action="{{ route('listings.create.location') }}" method="POST" class="lc-form">
      @csrf

      <div class="lc-fields">

        {{-- Country --}}
        <div class="lc-field">
          <label for="country" class="lc-label">Pays</label>
          <div class="lc-select-wrap">
            <select name="country" id="country" class="lc-select" required>
              <option value="" disabled {{ old('country', $listing->country ?? '') === '' ? 'selected' : '' }}>Sélectionnez un pays</option>
              @foreach(config('countries') ?? [] as $country)
                <option value="{{ $country['code'] }}" {{ old('country', $listing->country ?? '') === $country['code'] ? 'selected' : '' }}>
                  {{ $country['flag'] }} {{ $country['label'] }}
                </option>
              @endforeach
              {{-- Fallback if config not available yet --}}
              @if(!config('countries'))
                <option value="FR" {{ old('country', $listing->country ?? '') === 'FR' ? 'selected' : '' }}>🇫🇷 France</option>
                <option value="ES" {{ old('country', $listing->country ?? '') === 'ES' ? 'selected' : '' }}>🇪🇸 Espagne</option>
              @endif
            </select>
            @svg('tabler-chevron-down', ['class' => 'lc-select-icon'])
          </div>
        </div>

        {{-- Region --}}
        <div class="lc-field">
          <label for="region" class="lc-label">
            Région ou Département
            <span class="lc-label-optional">optionnel</span>
          </label>
          <input
            type="text"
            name="region"
            id="region"
            class="lc-input"
            value="{{ old('region', $listing->region ?? '') }}"
            placeholder="ex. PACA ou Bouches-du-Rhône"
            maxlength="100"
          >
        </div>

        {{-- City --}}
        <div class="lc-field">
          <label for="city" class="lc-label">Ville</label>
          <input
            type="text"
            name="city"
            id="city"
            class="lc-input"
            value="{{ old('city', $listing->city ?? '') }}"
            placeholder="ex. Marseille"
            required
            maxlength="100"
          >
        </div>

        {{-- Address --}}
        <div class="lc-field">
          <label for="address" class="lc-label">
            Adresse
            <span class="lc-label-optional">optionnel</span>
          </label>
          <input
            type="text"
            name="address"
            id="address"
            class="lc-input"
            value="{{ old('address', $listing->address ?? '') }}"
            placeholder="ex. 12 rue du Port"
            maxlength="255"
          >
          <p class="lc-field-hint">L'adresse exacte ne sera partagée qu'après réservation.</p>
        </div>

        {{-- Map URL --}}
        <div class="lc-field">
          <label for="map_url" class="lc-label">
            Lien Google Maps
            <span class="lc-label-optional">optionnel</span>
          </label>
          <input
            type="url"
            name="map_url"
            id="map_url"
            class="lc-input"
            value="{{ old('map_url', $listing->map_url ?? '') }}"
            placeholder="ex. https://goo.gl/maps/..."
            maxlength="255"
          >
          <p class="lc-field-hint">Un lien vers l'emplacement exact pour afficher une carte sur votre annonce.</p>
        </div>

      </div>

      <div class="lc-actions">
        <a href="{{ route('listings.create.index', ['step' => 1]) }}" class="lc-btn-back">Retour</a>
        <button type="submit" class="lc-btn-next">Continuer</button>
      </div>
    </form>
  </div>
@endsection