{{--
  listings/create/step-3-basics.blade.php
  Step 3: Title, price, currency, capacity
--}}
@extends('layouts.listing-create')

@section('title', 'Informations de base — Publier une annonce')

@section('content')
  <div class="lc-step">
    <div class="lc-step-header">
      <h1 class="lc-title">Les informations essentielles</h1>
      <p class="lc-subtitle">Ces détails apparaissent en premier dans les résultats de recherche.</p>
    </div>

    <form action="{{ route('listings.create.basics') }}" method="POST" class="lc-form">
      @csrf

      <div class="lc-fields">

        {{-- Title --}}
        <div class="lc-field">
          <div class="lc-label-row">
            <label for="title" class="lc-label">Titre de l'annonce</label>
            <span class="lc-char-count" id="title-count">0/100</span>
          </div>
          <input
            type="text"
            name="title"
            id="title"
            class="lc-input"
            value="{{ old('title', $listing->title ?? '') }}"
            placeholder="ex. Voilier 10m à Marseille, vue mer"
            required
            maxlength="100"
          >
          <p class="lc-field-hint">Un titre court et descriptif attire plus de visiteurs.</p>
        </div>

        {{-- Price + Currency --}}
        <div class="lc-field">
          <label class="lc-label">Prix indicatif</label>
          <div class="lc-price-row">
            <input
              type="number"
              name="price_amount"
              id="price_amount"
              class="lc-input lc-input-price"
              value="{{ old('price_amount', $listing->price_amount ?? '') }}"
              placeholder="0"
              min="1"
              max="99999"
              step="1"
            >
            <div class="lc-select-wrap lc-currency-wrap">
              <select name="currency" id="currency" class="lc-select lc-select-currency">
                <option value="EUR" {{ old('currency', $listing->currency ?? 'EUR') === 'EUR' ? 'selected' : '' }}>EUR €</option>
                <option value="USD" {{ old('currency', $listing->currency ?? '') === 'USD' ? 'selected' : '' }}>USD $</option>
                <option value="GBP" {{ old('currency', $listing->currency ?? '') === 'GBP' ? 'selected' : '' }}>GBP £</option>
                <option value="CHF" {{ old('currency', $listing->currency ?? '') === 'CHF' ? 'selected' : '' }}>CHF</option>
              </select>
              @svg('tabler-chevron-down', ['class' => 'lc-select-icon'])
            </div>
          </div>
          <p class="lc-field-hint">Le prix reste indicatif : les visiteurs vous contactent directement.</p>
        </div>

        <div class="lc-field">
          <label for="price_unit" class="lc-label">Unité de prix</label>
          <div class="lc-select-wrap">
            <select name="price_unit" id="price_unit" class="lc-select">
              <option value="night" {{ old('price_unit', $listing->price_unit ?? 'night') === 'night' ? 'selected' : '' }}>Par nuit</option>
              <option value="day" {{ old('price_unit', $listing->price_unit ?? '') === 'day' ? 'selected' : '' }}>Par jour</option>
              <option value="trip" {{ old('price_unit', $listing->price_unit ?? '') === 'trip' ? 'selected' : '' }}>Par sortie</option>
              <option value="week" {{ old('price_unit', $listing->price_unit ?? '') === 'week' ? 'selected' : '' }}>Par semaine</option>
              <option value="month" {{ old('price_unit', $listing->price_unit ?? '') === 'month' ? 'selected' : '' }}>Par mois</option>
              <option value="contact" {{ old('price_unit', $listing->price_unit ?? '') === 'contact' ? 'selected' : '' }}>Sur demande</option>
            </select>
            @svg('tabler-chevron-down', ['class' => 'lc-select-icon'])
          </div>
        </div>

        {{-- Capacity --}}
        <div class="lc-field">
          <label class="lc-label">Capacité maximum</label>
          <div class="lc-stepper">
            <button type="button" class="lc-stepper-btn" data-target="capacity" data-action="dec" aria-label="Diminuer">
              @svg('tabler-minus')
            </button>
            <input
              type="number"
              name="capacity"
              id="capacity"
              class="lc-stepper-input"
              value="{{ old('capacity', $listing->capacity ?? 2) }}"
              min="1"
              max="50"
              readonly
            >
            <button type="button" class="lc-stepper-btn" data-target="capacity" data-action="inc" aria-label="Augmenter">
              @svg('tabler-plus')
            </button>
          </div>
        </div>

      </div>

      <div class="lc-actions">
        <a href="{{ route('listings.create.index', ['step' => 2]) }}" class="lc-btn-back">Retour</a>
        <button type="submit" class="lc-btn-next">Continuer</button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    // Char counter
    const titleInput = document.getElementById('title')
    const titleCount = document.getElementById('title-count')
    const updateCount = () => titleCount.textContent = `${titleInput.value.length}/100`
    titleInput.addEventListener('input', updateCount)
    updateCount()

    // Stepper buttons
    document.querySelectorAll('.lc-stepper-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.target)
        const min = parseInt(input.min) || 1
        const max = parseInt(input.max) || 99
        let val = parseInt(input.value) || min
        val = btn.dataset.action === 'inc' ? Math.min(val + 1, max) : Math.max(val - 1, min)
        input.value = val
      })
    })
  </script>
@endpush
