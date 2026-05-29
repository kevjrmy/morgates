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

        {{-- Map picker --}}
        <div class="lc-field lc-map-picker" data-map-picker>
          <div class="lc-map-picker-header">
            <label for="map_search" class="lc-label">Position sur Google Maps</label>
            <p class="lc-field-hint">Saisissez l'emplacement à afficher aux visiteurs. Vous pouvez rester vague si vous ne souhaitez pas montrer l'adresse exacte.</p>
          </div>

          <div class="lc-map-search-row">
            <input
              type="search"
              id="map_search"
              class="lc-input"
              value="{{ old('map_search') }}"
              placeholder="ex. Mandelieu-la-Napoule, Port de Cannes, Calanque de Sormiou"
              autocomplete="off"
              data-map-search
            >
            <button type="button" class="lc-map-refresh" data-map-refresh>
              @svg('tabler-search')
              Rechercher
            </button>
          </div>

          <div class="lc-map-preview">
            <iframe
              title="Aperçu Google Maps"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              data-map-frame
            ></iframe>
          </div>

          <input
            type="hidden"
            name="map_url"
            id="map_url"
            value="{{ old('map_url', $listing->map_url ?? '') }}"
            data-map-url
          >

          <details class="lc-map-manual">
            <summary>Coller un lien Google Maps manuellement</summary>
            <input
              type="url"
              class="lc-input"
              value="{{ old('map_url', $listing->map_url ?? '') }}"
              placeholder="ex. https://goo.gl/maps/..."
              maxlength="255"
              data-map-manual-url
            >
          </details>
        </div>

      </div>

      <div class="lc-actions">
        <a href="{{ route('listings.create.index', ['step' => 1]) }}" class="lc-btn-back">Retour</a>
        <button type="submit" class="lc-btn-next" disabled>Continuer</button>
      </div>
    </form>
  </div>
@endsection
@push('scripts')
  <script>
    (() => {
      const picker = document.querySelector('[data-map-picker]');
      if (!picker) return;

      const searchInput = picker.querySelector('[data-map-search]');
      const mapUrlInput = picker.querySelector('[data-map-url]');
      const manualUrlInput = picker.querySelector('[data-map-manual-url]');
      const frame = picker.querySelector('[data-map-frame]');
      const refreshButton = picker.querySelector('[data-map-refresh]');

      const mapSearchUrl = (query) => `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(query)}`;
      const mapEmbedUrl = (query) => `https://maps.google.com/maps?q=${encodeURIComponent(query)}&output=embed`;

      const queryFromUrl = (url) => {
        if (!url) return '';

        try {
          const parsedUrl = new URL(url);
          return parsedUrl.searchParams.get('query') || parsedUrl.searchParams.get('q') || '';
        } catch (error) {
          return '';
        }
      };

      const updateMap = (query, { syncSearch = true, persist = true } = {}) => {
        const cleanQuery = (query || '').trim();
        if (!cleanQuery) return;

        frame.src = mapEmbedUrl(cleanQuery);

        const nextUrl = mapSearchUrl(cleanQuery);
        if (persist && nextUrl.length <= 255) {
          mapUrlInput.value = nextUrl;
          manualUrlInput.value = nextUrl;
        }

        if (syncSearch) {
          searchInput.value = cleanQuery;
        }
      };

      const updateFromSearch = () => {
        updateMap(searchInput.value, { syncSearch: false });
      };

      const updateFromManualUrl = () => {
        const url = manualUrlInput.value.trim();
        if (!url) return;

        mapUrlInput.value = url;

        const manualQuery = queryFromUrl(url);
        if (manualQuery) {
          frame.src = mapEmbedUrl(manualQuery);
          searchInput.value = manualQuery;
        }
      };

      searchInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
          event.preventDefault();
          updateFromSearch();
        }
      });

      searchInput.addEventListener('blur', updateFromSearch);
      refreshButton.addEventListener('click', updateFromSearch);
      manualUrlInput.addEventListener('input', updateFromManualUrl);
      picker.closest('form')?.addEventListener('submit', () => {
        if (searchInput.value.trim()) {
          updateFromSearch();
        }
      });

      const initialQuery = searchInput.value || queryFromUrl(mapUrlInput.value);
      if (initialQuery) {
        updateMap(initialQuery);
      } else {
        updateMap('Paris, France', { syncSearch: false, persist: false });
      }
    })();

    // Enable/disable next button based on required fields
    (() => {
      const btn = document.querySelector('.lc-form .lc-btn-next')
      const required = document.querySelectorAll('.lc-form [required]')

      const toggle = () => {
        btn.disabled = !Array.from(required).every(input => input.value.trim() !== '')
      }

      required.forEach(input => {
        input.addEventListener('input', toggle)
        input.addEventListener('change', toggle)
      })

      toggle()
    })();
  </script>
@endpush
