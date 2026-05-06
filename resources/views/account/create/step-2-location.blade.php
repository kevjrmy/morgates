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
              @foreach(config('countries') ?? [] as $code => $name)
                <option value="{{ $code }}" {{ old('country', $listing->country ?? '') === $code ? 'selected' : '' }}>
                  {{ $name }}
                </option>
              @endforeach
              {{-- Fallback if config not available yet --}}
              @if(!config('countries'))
                <option value="FR" {{ old('country', $listing->country ?? '') === 'FR' ? 'selected' : '' }}>France</option>
                <option value="ES" {{ old('country', $listing->country ?? '') === 'ES' ? 'selected' : '' }}>Espagne</option>
                <option value="IT" {{ old('country', $listing->country ?? '') === 'IT' ? 'selected' : '' }}>Italie</option>
                <option value="PT" {{ old('country', $listing->country ?? '') === 'PT' ? 'selected' : '' }}>Portugal</option>
                <option value="HR" {{ old('country', $listing->country ?? '') === 'HR' ? 'selected' : '' }}>Croatie</option>
                <option value="GR" {{ old('country', $listing->country ?? '') === 'GR' ? 'selected' : '' }}>Grèce</option>
                <option value="ME" {{ old('country', $listing->country ?? '') === 'ME' ? 'selected' : '' }}>Monténégro</option>
              @endif
            </select>
            @svg('tabler-chevron-down', ['class' => 'lc-select-icon'])
          </div>
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

      </div>

      <div class="lc-actions">
        <a href="{{ route('listings.create.index', ['step' => 1]) }}" class="lc-btn-back">Retour</a>
        <button type="submit" class="lc-btn-next">Continuer</button>
      </div>
    </form>
  </div>
@endsection