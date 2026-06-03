{{--
listings/create/step-3-basics.blade.php
Step 3: Title, price, capacity
--}}
@extends('layouts.listing-create')

@section('title', 'Informations de base — Publier une annonce')

@section('content')
  @php
    $isBoatListing = ($listing->type ?? null) === 'boats';
  @endphp

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
          <input type="text" name="title" id="title" class="lc-input" value="{{ old('title', $listing->title ?? '') }}"
            placeholder="ex. Voilier 10m à Marseille, vue mer" required maxlength="100">
          <p class="lc-field-hint">Un titre court et descriptif attire plus de visiteurs.</p>
        </div>

        {{-- Price & Unit --}}
        <div id="price_grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; align-items: start;">
          <div class="lc-field" style="margin-bottom: 0;">
            <label class="lc-label">Prix indicatif</label>
            <div class="lc-price-row">
              <input type="number" name="price_amount" id="price_amount" class="lc-input lc-input-price"
                value="{{ old('price_amount', $listing->price_amount ?? '') }}" placeholder="0" min="1" max="99999"
                step="1">
            </div>
          </div>

          <div class="lc-field" style="margin-bottom: 0;">
            <label for="price_unit" class="lc-label">Par</label>
            <div class="lc-select-wrap">
              <select name="price_unit" id="price_unit" class="lc-select">
                @if($isBoatListing)
                  <option value="hour" {{ old('price_unit', $listing->price_unit ?? '') === 'hour' ? 'selected' : '' }}>
                    heure</option>
                  <option value="half-day" {{ old('price_unit', $listing->price_unit ?? '') === 'half-day' ? 'selected' : '' }}>
                    demi-journée</option>
                @endif
                <option value="day" {{ old('price_unit', $listing->price_unit ?? 'day') === 'day' ? 'selected' : '' }}>
                  jour</option>
                <option value="week" {{ old('price_unit', $listing->price_unit ?? '') === 'week' ? 'selected' : '' }}>semaine</option>
                <option value="month" {{ old('price_unit', $listing->price_unit ?? '') === 'month' ? 'selected' : '' }}>mois</option>
                <option value="contact" hidden {{ old('price_unit', $listing->price_unit ?? '') === 'contact' ? 'selected' : '' }}>Sur demande</option>
              </select>
              @svg('tabler-chevron-down', ['class' => 'lc-select-icon'])
            </div>
          </div>
        </div>

        {{-- Sur demande toggle --}}
        <label class="lc-toggle-row" for="price_contact_toggle">
          <span class="lc-toggle-label">
            <span class="lc-toggle-title">Prix sur demande</span>
            <span class="lc-toggle-hint">Masque le prix : les visiteurs vous contactent directement.</span>
          </span>
          <span class="lc-toggle-switch">
            <input type="checkbox" id="price_contact_toggle" class="lc-toggle-input" {{ old('price_unit', $listing->price_unit ?? '') === 'contact' ? 'checked' : '' }}>
            <span class="lc-toggle-track"><span class="lc-toggle-thumb"></span></span>
          </span>
        </label>

        {{-- Capacity --}}
        <div class="lc-field">
          <label class="lc-label">Capacité maximum</label>
          <div class="lc-stepper">
            <button type="button" class="lc-stepper-btn" data-target="capacity" data-action="dec" aria-label="Diminuer">
              @svg('tabler-minus')
            </button>
            <input type="number" name="capacity" id="capacity" class="lc-stepper-input"
              value="{{ old('capacity', $listing->capacity ?? 2) }}" min="1" max="50" readonly>
            <button type="button" class="lc-stepper-btn" data-target="capacity" data-action="inc" aria-label="Augmenter">
              @svg('tabler-plus')
            </button>
          </div>
        </div>

      </div>

      <div class="lc-actions">
        <a href="{{ route('listings.create.index', ['step' => 2]) }}" class="lc-btn-back">Retour</a>
        <button type="submit" class="lc-btn-next" disabled>Continuer</button>
      </div>
    </form>
  </div>
@endsection

@push('styles')
  <style>
    /* Toggle row */
    .lc-toggle-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      padding: 0.85rem 1rem;
      background: #f8fafc;
      border: 1px solid rgba(0, 0, 0, 0.07);
      border-radius: 12px;
      cursor: pointer;
      margin-top: 0.75rem;
    }

    .lc-toggle-label {
      display: flex;
      flex-direction: column;
      gap: 0.15rem;
    }

    .lc-toggle-title {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--clr-text-dark);
    }

    .lc-toggle-hint {
      font-size: 0.78rem;
      color: var(--clr-text-light);
    }

    /* Switch */
    .lc-toggle-switch {
      flex-shrink: 0;
      position: relative;
    }

    .lc-toggle-input {
      position: absolute;
      opacity: 0;
      width: 0;
      height: 0;
    }

    .lc-toggle-track {
      display: block;
      width: 44px;
      height: 24px;
      background: #d1d5db;
      border-radius: 999px;
      position: relative;
      transition: background 0.2s ease;
    }

    .lc-toggle-thumb {
      position: absolute;
      top: 3px;
      left: 3px;
      width: 18px;
      height: 18px;
      background: #fff;
      border-radius: 50%;
      box-shadow: 0 1px 3px rgba(0,0,0,0.2);
      transition: transform 0.2s ease;
    }

    .lc-toggle-input:checked + .lc-toggle-track {
      background: var(--clr-primary);
    }

    .lc-toggle-input:checked + .lc-toggle-track .lc-toggle-thumb {
      transform: translateX(20px);
    }

    /* Greyed-out price grid when toggle is on */
    #price_grid.is-disabled {
      opacity: 0.4;
      pointer-events: none;
    }
  </style>
@endpush

@push('scripts')
  <script>
    // Char counter
    const titleInput = document.getElementById('title')
    const titleCount = document.getElementById('title-count')
    const updateCount = () => titleCount.textContent = `${titleInput.value.length}/100`
    titleInput.addEventListener('input', updateCount)
    updateCount()

    // Price on request toggle
    const priceToggle = document.getElementById('price_contact_toggle')
    const priceGrid   = document.getElementById('price_grid')
    const priceAmount = document.getElementById('price_amount')
    const priceUnit   = document.getElementById('price_unit')

    let previousUnit = priceUnit.value === 'contact' ? 'day' : priceUnit.value

    const togglePriceFields = () => {
      if (priceToggle.checked) {
        priceGrid.classList.add('is-disabled')
        priceAmount.disabled = true
        priceAmount.value = ''
        priceUnit.disabled = true

        let hiddenUnit = document.getElementById('hidden_price_unit')
        if (!hiddenUnit) {
          hiddenUnit = document.createElement('input')
          hiddenUnit.type = 'hidden'
          hiddenUnit.name = 'price_unit'
          hiddenUnit.id = 'hidden_price_unit'
          priceUnit.parentNode.appendChild(hiddenUnit)
        }
        hiddenUnit.value = 'contact'
      } else {
        priceGrid.classList.remove('is-disabled')
        priceAmount.disabled = false
        priceUnit.disabled = false
        if (priceUnit.value === 'contact') priceUnit.value = previousUnit
        const hiddenUnit = document.getElementById('hidden_price_unit')
        if (hiddenUnit) hiddenUnit.remove()
      }
    }

    priceToggle.addEventListener('change', togglePriceFields)
    togglePriceFields()

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

    // Enable/disable next button based on explicit rules
    const btnNext = document.querySelector('.lc-form .lc-btn-next')
    
    const checkFormValidity = () => {
      const isTitleValid = titleInput.value.trim() !== ''
      const isPriceValid = priceToggle.checked || priceAmount.value.trim() !== ''
      
      btnNext.disabled = !(isTitleValid && isPriceValid)
    }

    titleInput.addEventListener('input', checkFormValidity)
    priceAmount.addEventListener('input', checkFormValidity)
    priceToggle.addEventListener('change', checkFormValidity)

    checkFormValidity()
  </script>
@endpush