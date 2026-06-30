{{--
  listings/create/step-2-location.blade.php
  Step 2: Where is the listing?
--}}
@extends('layouts.listing-create')

@section('title', 'Localisation - Publier une annonce')

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
              @if(!config('countries'))
                <option value="FR" {{ old('country', $listing->country ?? '') === 'FR' ? 'selected' : '' }}>🇫🇷 France</option>
                <option value="ES" {{ old('country', $listing->country ?? '') === 'ES' ? 'selected' : '' }}>🇪🇸 Espagne</option>
              @endif
            </select>
            @svg('tabler-chevron-down', ['class' => 'lc-select-icon'])
          </div>
        </div>

        <input type="hidden" name="region" id="region" value="{{ old('region', $listing->region ?? '') }}">

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
        <div class="lc-field lc-autocomplete" data-address-autocomplete>
          <label for="address" class="lc-label">Adresse</label>
          <input
            type="text"
            name="address"
            id="address"
            class="lc-input"
            value="{{ old('address', $listing->address ?? '') }}"
            placeholder="ex. 12 rue du Port"
            maxlength="255"
            required
            autocomplete="off"
          >
          <div class="lc-autocomplete-list" id="address-suggestions"></div>
        </div>

        {{-- Show exact address toggle --}}
        <div class="lc-field lc-toggle-field">
          <div class="lc-toggle-row">
            <div class="lc-toggle-text">
              <span class="lc-label">Afficher l'adresse exacte</span>
              <p class="lc-field-hint">Les visiteurs verront votre adresse complète sur l'annonce.</p>
            </div>
            <label class="lc-toggle" aria-label="Afficher l'adresse exacte aux visiteurs">
              <input type="checkbox" name="show_exact_address" id="show_exact_address" value="1"
                {{ old('show_exact_address', $listing->show_exact_address ?? false) ? 'checked' : '' }}>
              <span class="lc-toggle-track"></span>
            </label>
          </div>
        </div>

        {{-- Map preview (auto-generated from address + city) --}}
        <div class="lc-field lc-map-picker" data-map-picker>
          <label class="lc-label">Aperçu de la carte</label>
          <p class="lc-field-hint">Généré automatiquement depuis votre adresse et votre ville.</p>

          <div class="lc-map-preview" data-map-preview>
            <div class="lc-map-placeholder" data-map-placeholder>
              @svg('tabler-map-pin', ['class' => 'lc-map-placeholder-icon'])
              <p>Complétez l'adresse pour afficher la carte</p>
            </div>
            <iframe
              title="Aperçu Google Maps"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              data-map-frame
              style="display: none;"
            ></iframe>
          </div>

          <input
            type="hidden"
            name="map_url"
            id="map_url"
            value="{{ old('map_url', $listing->map_url ?? '') }}"
            data-map-url
          >

        </div>

      </div>

      <div class="lc-actions">
        <a href="{{ route('listings.create.index', ['step' => 1]) }}" class="lc-btn-back">@svg('tabler-arrow-left') Retour</a>
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

    /* Toggle */
    .lc-toggle-field {
      border: 0.5px solid #EBEBEB;
      border-radius: 0.625rem;
      padding: 0.875rem 1rem;
    }

    .lc-toggle-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
    }

    .lc-toggle-text {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }

    .lc-toggle {
      position: relative;
      flex-shrink: 0;
      width: 2.75rem;
      height: 1.5rem;
      cursor: pointer;
      display: block;
    }

    .lc-toggle input {
      opacity: 0;
      width: 0;
      height: 0;
      position: absolute;
    }

    .lc-toggle-track {
      position: absolute;
      inset: 0;
      background: #D1D5DB;
      border-radius: 99px;
      transition: background 0.2s;
    }

    .lc-toggle-track::after {
      content: '';
      position: absolute;
      top: 3px;
      left: 3px;
      width: 1.125rem;
      height: 1.125rem;
      background: #fff;
      border-radius: 50%;
      transition: transform 0.2s;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .lc-toggle input:checked + .lc-toggle-track {
      background: var(--clr-primary);
    }

    .lc-toggle input:checked + .lc-toggle-track::after {
      transform: translateX(1.25rem);
    }

    /* Map */
    .lc-map-picker {
      gap: 0.75rem;
    }

    .lc-map-preview {
      position: relative;
      width: 100%;
      aspect-ratio: 16 / 9;
      background: #f8fafc;
      border: 0.5px solid #EBEBEB;
      border-radius: 0.625rem;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .lc-map-preview iframe {
      width: 100%;
      height: 100%;
      border: 0;
    }

    .lc-map-placeholder {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      color: var(--clr-text-light);
      padding: 2rem;
    }

    .lc-map-placeholder-icon {
      width: 2.5rem;
      height: 2.5rem;
      margin-bottom: 0.75rem;
      opacity: 0.5;
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

      function initAutocomplete({ input, list, fetchSuggestions, renderItem, onSelect, onResults }) {
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

            if (onResults) onResults(items, query)

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
      const addressInput = document.getElementById('address')
      const addressList = document.getElementById('address-suggestions')
      const cache = new Map()

      let cityCode = ''

      const updateAddressAvailability = () => {
        const isFR = countryInput.value === 'FR'
        const cityReady = isFR ? !!cityCode : cityInput.value.trim() !== ''

        if (cityReady) {
          addressInput.disabled = false
          addressInput.placeholder = 'ex. 12 rue du Port'
        } else {
          addressInput.disabled = true
          addressInput.placeholder = "Sélectionnez d'abord une ville"
          addressInput.value = ''
          addressInput.setCustomValidity('')
        }
      }

      const updateCityAvailability = () => {
        const country = countryInput.value
        cityInput.disabled = !country
        cityInput.placeholder = country ? 'ex. Vannes' : "Sélectionnez d'abord un pays"

        if (!country) {
          cityInput.value = ''
          regionInput.value = ''
          latitudeInput.value = ''
          longitudeInput.value = ''
          cityCode = ''
          addressInput.value = ''
          addressInput.setCustomValidity('')
        }
        updateAddressAvailability()
      }

      countryInput.addEventListener('change', () => {
        cityInput.value = ''
        cityInput.setCustomValidity('')
        regionInput.value = ''
        latitudeInput.value = ''
        longitudeInput.value = ''
        cityCode = ''
        addressInput.value = ''
        addressInput.setCustomValidity('')
        updateCityAvailability()
        cityInput.dispatchEvent(new Event('change', { bubbles: true }))
      })

      cityInput.addEventListener('input', () => {
        latitudeInput.value = ''
        longitudeInput.value = ''
        cityCode = ''
        addressInput.value = ''
        addressInput.setCustomValidity('')
        updateAddressAvailability()
        if (countryInput.value === 'FR') {
          cityInput.setCustomValidity('Veuillez sélectionner une ville dans la liste')
        }
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
            const response = await fetch(`https://geo.api.gouv.fr/communes?nom=${encodeURIComponent(query)}&fields=nom,region,departement,centre,code&boost=population&limit=8`, {
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
          cityCode = result.code || ''
          countryInput.value = 'FR'
          cityInput.setCustomValidity('')
          cityInput.dispatchEvent(new Event('change', { bubbles: true }))
          latitudeInput.value = result.centre?.coordinates?.[1] ?? ''
          longitudeInput.value = result.centre?.coordinates?.[0] ?? ''
          addressInput.value = ''
          addressInput.setCustomValidity('')
          updateAddressAvailability()
        },
        onResults: (results, query) => {
          const match = results.find(r => r.nom.toLowerCase() === query.toLowerCase())
          if (match) {
            cityCode = match.code || ''
            regionInput.value = match.region?.nom || ''
            latitudeInput.value = match.centre?.coordinates?.[1] ?? ''
            longitudeInput.value = match.centre?.coordinates?.[0] ?? ''
            cityInput.setCustomValidity('')
          }
          updateAddressAvailability()
        },
      })

      initAutocomplete({
        input: addressInput,
        list: addressList,
        fetchSuggestions: async (query) => {
          if (countryInput.value !== 'FR' || !cityCode) return []

          const controller = new AbortController()
          const timeout = setTimeout(() => controller.abort(), 3000)

          try {
            const response = await fetch(
              `https://api-adresse.data.gouv.fr/search/?q=${encodeURIComponent(query)}&citycode=${cityCode}&limit=6`,
              { signal: controller.signal }
            )
            if (!response.ok) return []
            const data = await response.json()
            return data.features || []
          } catch {
            return []
          } finally {
            clearTimeout(timeout)
          }
        },
        renderItem: (feature) => `
          <span class="lc-autocomplete-name">${escapeHtml(feature.properties.name)}</span>
          <span class="lc-autocomplete-region">${escapeHtml(feature.properties.postcode)}</span>
        `,
        onSelect: (feature) => {
          addressInput.value = feature.properties.name || ''
          addressInput.setCustomValidity('')
          addressInput.dispatchEvent(new Event('change', { bubbles: true }))
        },
      })

      addressInput.addEventListener('input', () => {
        if (countryInput.value === 'FR') {
          addressInput.setCustomValidity('Veuillez sélectionner une adresse dans la liste')
        }
      })

      updateCityAvailability()

      // Edit/session flow: city + coordinates pre-filled but cityCode not stored - fetch it once
      if (countryInput.value === 'FR' && cityInput.value && latitudeInput.value) {
        fetch(`https://geo.api.gouv.fr/communes?nom=${encodeURIComponent(cityInput.value)}&fields=code&boost=population&limit=1`)
          .then(r => r.json())
          .then(results => {
            if (results[0]?.code) {
              cityCode = results[0].code
              updateAddressAvailability()
            }
          })
          .catch(() => {})
      }
    })();

    (() => {
      const picker = document.querySelector('[data-map-picker]')
      if (!picker) return

      const mapUrlInput = picker.querySelector('[data-map-url]')
      const frame = picker.querySelector('[data-map-frame]')
      const placeholder = picker.querySelector('[data-map-placeholder]')
      const placeholderText = placeholder?.querySelector('p')
      const exactToggle = document.getElementById('show_exact_address')
      const cityInput = document.getElementById('city')
      const addressInput = document.getElementById('address')

      const mapEmbedUrl = (query) => `https://maps.google.com/maps?q=${encodeURIComponent(query)}&output=embed`
      const mapSearchUrl = (query) => `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(query)}`

      const buildQuery = () => {
        const address = (addressInput?.value || '').trim()
        const city = (cityInput?.value || '').trim()
        if (address && city) return `${address}, ${city}`
        return ''
      }

      const showPlaceholder = (text) => {
        frame.style.display = 'none'
        frame.src = ''
        placeholder.style.display = 'flex'
        if (placeholderText && text) placeholderText.textContent = text
      }

      const showMap = (query, { persist = true } = {}) => {
        const clean = (query || '').trim()
        if (!clean) {
          showPlaceholder('Complétez l\'adresse pour afficher la carte')
          return
        }
        frame.style.display = 'block'
        placeholder.style.display = 'none'
        frame.src = mapEmbedUrl(clean)
        const nextUrl = mapSearchUrl(clean)
        if (persist && nextUrl.length <= 255) {
          mapUrlInput.value = nextUrl
        }
      }

      const refresh = () => {
        if (!exactToggle?.checked) {
          picker.style.display = 'none'
          frame.src = ''
          return
        }
        picker.style.display = ''
        showMap(buildQuery())
      }

      let debounceTimer = null
      const debouncedRefresh = () => {
        clearTimeout(debounceTimer)
        debounceTimer = setTimeout(refresh, 500)
      }

      exactToggle?.addEventListener('change', refresh)
      cityInput?.addEventListener('change', refresh)
      cityInput?.addEventListener('input', refresh)
      addressInput?.addEventListener('change', refresh)
      addressInput?.addEventListener('blur', refresh)
      addressInput?.addEventListener('input', debouncedRefresh)

      refresh()
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
