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
        <div class="lc-field lc-autocomplete" data-city-autocomplete>
          <label for="city" class="lc-label">Ville</label>
          <input
            type="text"
            name="city"
            id="city"
            class="lc-input"
            value="{{ old('city', $listing->city ?? '') }}"
            placeholder="Sélectionnez d'abord un pays"
            required
            maxlength="100"
            autocomplete="off"
            {{ old('country', $listing->country ?? '') === '' ? 'disabled' : '' }}
          >
          <div class="lc-autocomplete-list" id="city-suggestions"></div>
          <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $listing->latitude ?? '') }}">
          <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $listing->longitude ?? '') }}">
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

@push('styles')
  <style>
    .lc-autocomplete {
      position: relative;
    }

    .lc-autocomplete-list {
      position: absolute;
      top: calc(100% + 0.45rem);
      left: 0;
      right: 0;
      z-index: 30;
      display: none;
      max-height: 18rem;
      overflow-y: auto;
      border: 1px solid rgba(0, 0, 0, 0.08);
      border-radius: 14px;
      background: #fff;
      box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
    }

    .lc-autocomplete-list.is-open {
      display: block;
    }

    .lc-autocomplete-item {
      width: 100%;
      padding: 0.85rem 1rem;
      text-align: left;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      background: #fff;
    }

    .lc-autocomplete-item:last-child {
      border-bottom: 0;
    }

    .lc-autocomplete-item:hover,
    .lc-autocomplete-item.is-active {
      background: var(--clr-softblue);
    }

    .lc-autocomplete-name {
      display: block;
      color: var(--clr-text-dark);
      font-weight: 700;
    }

    .lc-autocomplete-region {
      display: block;
      margin-top: 0.15rem;
      color: var(--clr-text-medium);
      font-size: 0.82rem;
    }
  </style>
@endpush
@push('scripts')
  <script>
    (() => {
      const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (char) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        "'": '&#039;',
        '"': '&quot;',
      }[char]))

      function initAutocomplete({ input, list, fetchSuggestions, renderItem, onSelect }) {
        if (!input || !list) return

        let items = []
        let activeIndex = -1
        let timer = null

        const close = () => {
          list.classList.remove('is-open')
          list.innerHTML = ''
          items = []
          activeIndex = -1
        }

        const setActive = (index) => {
          activeIndex = index
          list.querySelectorAll('[data-autocomplete-index]').forEach((item, itemIndex) => {
            item.classList.toggle('is-active', itemIndex === activeIndex)
          })
        }

        const select = (index) => {
          const item = items[index]
          if (!item) return
          onSelect(item)
          close()
        }

        input.addEventListener('input', () => {
          clearTimeout(timer)
          close()
          timer = setTimeout(async () => {
            const query = input.value.trim()
            if (query.length < 3 || input.disabled) return

            try {
              items = await fetchSuggestions(query)
            } catch {
              close()
              return
            }

            if (!items.length) {
              close()
              return
            }

            list.innerHTML = items.map((item, index) => `
              <button type="button" class="lc-autocomplete-item" data-autocomplete-index="${index}">
                ${renderItem(item)}
              </button>
            `).join('')
            list.classList.add('is-open')
          }, 300)
        })

        list.addEventListener('mousedown', (event) => {
          const item = event.target.closest('[data-autocomplete-index]')
          if (!item) return
          event.preventDefault()
          select(Number(item.dataset.autocompleteIndex))
        })

        input.addEventListener('keydown', (event) => {
          if (!list.classList.contains('is-open')) return

          if (event.key === 'ArrowDown') {
            event.preventDefault()
            setActive(Math.min(activeIndex + 1, items.length - 1))
          } else if (event.key === 'ArrowUp') {
            event.preventDefault()
            setActive(Math.max(activeIndex - 1, 0))
          } else if (event.key === 'Enter' && activeIndex >= 0) {
            event.preventDefault()
            select(activeIndex)
          } else if (event.key === 'Escape') {
            close()
          }
        })

        document.addEventListener('click', (event) => {
          if (!list.contains(event.target) && event.target !== input) close()
        })
      }

      const countryInput = document.getElementById('country')
      const cityInput = document.getElementById('city')
      const regionInput = document.getElementById('region')
      const latitudeInput = document.getElementById('latitude')
      const longitudeInput = document.getElementById('longitude')
      const cityList = document.getElementById('city-suggestions')
      const cache = new Map()

      const updateCityAvailability = () => {
        const country = countryInput.value
        cityInput.disabled = !country
        cityInput.placeholder = country ? 'ex. Vannes' : "Sélectionnez d'abord un pays"

        if (!country) {
          cityInput.value = ''
          regionInput.value = ''
          latitudeInput.value = ''
          longitudeInput.value = ''
        }
      }

      countryInput.addEventListener('change', () => {
        latitudeInput.value = ''
        longitudeInput.value = ''
        updateCityAvailability()
      })

      cityInput.addEventListener('input', () => {
        latitudeInput.value = ''
        longitudeInput.value = ''
      })

      initAutocomplete({
        input: cityInput,
        list: cityList,
        fetchSuggestions: async (query) => {
          if (countryInput.value !== 'FR') return []
          const key = query.toLowerCase()
          if (cache.has(key)) return cache.get(key)

          const controller = new AbortController()
          const timeout = setTimeout(() => controller.abort(), 3000)

          try {
            const response = await fetch(`https://geo.api.gouv.fr/communes?nom=${encodeURIComponent(query)}&fields=nom,region,departement,centre&boost=population&limit=8`, {
              signal: controller.signal,
            })
            if (!response.ok) return []
            const results = await response.json()
            cache.set(key, results)
            return results
          } catch {
            return []
          } finally {
            clearTimeout(timeout)
          }
        },
        renderItem: (result) => `
          <span class="lc-autocomplete-name">${escapeHtml(result.nom)}</span>
          <span class="lc-autocomplete-region">${escapeHtml(result.region?.nom || result.departement?.nom || '')}</span>
        `,
        onSelect: (result) => {
          cityInput.value = result.nom || ''
          regionInput.value = result.region?.nom || ''
          countryInput.value = 'FR'
          cityInput.dispatchEvent(new Event('change', { bubbles: true }))
          latitudeInput.value = result.centre?.coordinates?.[1] ?? ''
          longitudeInput.value = result.centre?.coordinates?.[0] ?? ''
        },
      })

      updateCityAvailability()
    })();

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

    (() => {
      const btn = document.querySelector('.lc-form .lc-btn-next')
      const required = document.querySelectorAll('.lc-form [required]')

      const toggle = () => {
        btn.disabled = !Array.from(required).every(input => input.disabled || input.value.trim() !== '')
      }

      required.forEach(input => {
        input.addEventListener('input', toggle)
        input.addEventListener('change', toggle)
      })

      toggle()
    })();
  </script>
@endpush
