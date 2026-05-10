<div id="filter-panel" class="filter-panel" aria-hidden="true">
  <div class="filter-panel-content">

    <div class="filter-panel-header">
      <h2 class="filter-panel-title">Filtres</h2>
      <button type="button" class="fp-close-btn" onclick="closeFilterPanel()" aria-label="Fermer">
        @svg('mdi-close')
      </button>
    </div>

    <form id="filter-form" action="{{ route('listings') }}" method="GET" class="filter-panel-body">

      {{-- Preserve active search params --}}
      @if(request('type'))   <input type="hidden" name="type"  value="{{ request('type') }}">  @endif
      @if(request('city'))   <input type="hidden" name="city"  value="{{ request('city') }}">  @endif
      @if(request('region')) <input type="hidden" name="region" value="{{ request('region') }}"> @endif
      @if(request('q'))      <input type="hidden" name="q"     value="{{ request('q') }}">     @endif
      @if(request('tag'))    <input type="hidden" name="tag"   value="{{ request('tag') }}">   @endif

      {{-- Sort --}}
      <div class="filter-section">
        <h3 class="filter-section-label">Trier par</h3>
        <div class="sort-options">
          <label class="sort-option">
            <input type="radio" name="sort" value="latest" {{ !request('sort') || request('sort') === 'latest' ? 'checked' : '' }}>
            <span>Plus récent</span>
          </label>
          <label class="sort-option">
            <input type="radio" name="sort" value="price_asc" {{ request('sort') === 'price_asc' ? 'checked' : '' }}>
            <span>Prix croissant</span>
          </label>
          <label class="sort-option">
            <input type="radio" name="sort" value="price_desc" {{ request('sort') === 'price_desc' ? 'checked' : '' }}>
            <span>Prix décroissant</span>
          </label>
        </div>
      </div>

      {{-- Region --}}
      <div class="filter-section">
        <h3 class="filter-section-label">Région</h3>
        <div class="region-options">
          <select name="region" class="filter-select">
            <option value="">Toutes les régions</option>
            <option value="Bretagne" {{ request('region') === 'Bretagne' ? 'selected' : '' }}>Bretagne</option>
            <option value="Auvergne-Rhône-Alpes" {{ request('region') === 'Auvergne-Rhône-Alpes' ? 'selected' : '' }}>Auvergne-Rhône-Alpes</option>
            <option value="Provence-Alpes-Côte d'Azur" {{ request('region') === "Provence-Alpes-Côte d'Azur" ? 'selected' : '' }}>Provence-Alpes-Côte d'Azur</option>
          </select>
        </div>
      </div>

      {{-- Price range --}}
      <div class="filter-section">
        <h3 class="filter-section-label">Prix</h3>
        <div class="price-range">
          <div class="price-input-group">
            <label for="filter-price-min">Minimum</label>
            <div class="price-field">
              <input type="number" name="price_min" id="filter-price-min"
                placeholder="0" value="{{ request('price_min') }}" min="0" step="10">
              <span class="price-unit">€</span>
            </div>
          </div>
          <div class="price-dash">—</div>
          <div class="price-input-group">
            <label for="filter-price-max">Maximum</label>
            <div class="price-field">
              <input type="number" name="price_max" id="filter-price-max"
                placeholder="∞" value="{{ request('price_max') }}" min="0" step="10">
              <span class="price-unit">€</span>
            </div>
          </div>
        </div>
      </div>

      {{-- Capacity stepper --}}
      <div class="filter-section">
        <h3 class="filter-section-label">Capacité minimale</h3>
        <div class="capacity-stepper">
          <button type="button" class="stepper-btn" id="capacity-decrement" aria-label="Diminuer">
            @svg('mdi-minus')
          </button>
          <span class="stepper-value" id="capacity-display">
            {{ request('capacity') ?: 'Tous' }}
          </span>
          <input type="hidden" name="capacity" id="capacity-input" value="{{ request('capacity') ?: '' }}">
          <button type="button" class="stepper-btn" id="capacity-increment" aria-label="Augmenter">
            @svg('mdi-plus')
          </button>
        </div>
      </div>

    </form>

    <div class="filter-panel-footer">
      <a href="{{ route('listings', array_filter(request()->only(['type', 'city', 'q', 'tag']))) }}"
        class="filter-clear-btn">
        Effacer
      </a>
      <button type="submit" form="filter-form" class="filter-submit-btn">
        @svg('mdi-magnify')
        Voir les annonces
      </button>
    </div>

  </div>
</div>

@push('styles')
  <style>
    .filter-panel {
      position: fixed;
      inset: 0;
      z-index: 1000;
      display: none;
      background-color: white;
    }

    .filter-panel.active {
      display: block;
      overflow-y: auto;
    }

    .filter-panel-content {
      width: 100%;
      max-width: var(--max-width);
      margin: 0 auto;
      min-height: 100dvh;
      display: flex;
      flex-direction: column;
      animation: fpSlideUp 0.25s ease-out;
    }

    @keyframes fpSlideUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .filter-panel-header {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.25rem 1.5rem;
      border-bottom: 1px solid #f0f0f0;
      position: sticky;
      top: 0;
      background: white;
      z-index: 10;
    }

    .filter-panel-title {
      font-size: 1rem;
      font-weight: 700;
      color: var(--clr-text-dark);
    }

    .fp-close-btn {
      position: absolute;
      left: 1.25rem;
      padding: 0.5rem;
      border-radius: 50%;
      background-color: #f5f5f7;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background-color 0.2s;
    }

    .fp-close-btn:hover { background-color: #e5e5e7; }

    .filter-panel-body {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 2rem;
      padding: 1.75rem 1.5rem;
    }

    .filter-section {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .filter-section-label {
      font-size: 0.95rem;
      font-weight: 700;
      color: var(--clr-text-dark);
    }

    /* Sort pills */
    .sort-options {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .sort-option {
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    .sort-option input[type="radio"] {
      display: none;
    }

    .sort-option span {
      display: inline-block;
      padding: 0.5rem 1rem;
      border-radius: 120px;
      font-size: 0.85rem;
      font-weight: 500;
      border: 1.5px solid #e5e5e7;
      background-color: #fafafa;
      color: var(--clr-text-dark);
      transition: all 0.15s;
      white-space: nowrap;
    }

    .sort-option:has(input:checked) span {
      background-color: rgba(0, 68, 170, 0.06);
      border-color: var(--clr-primary);
      color: var(--clr-primary);
      box-shadow: 0 0 0 1px var(--clr-primary);
    }

    /* Select */
    .filter-select {
      width: 100%;
      padding: 0.9rem 1rem;
      border: 1.5px solid #eee;
      border-radius: 14px;
      font-size: 1rem;
      outline: none;
      background-color: #fafafa;
      transition: all 0.2s;
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 1.2rem;
    }

    .filter-select:focus {
      border-color: var(--clr-primary);
      background-color: white;
      box-shadow: 0 0 0 4px rgba(0, 68, 170, 0.1);
    }

    /* Price range */
    .price-range {
      display: flex;
      align-items: flex-end;
      gap: 0.75rem;
    }

    .price-input-group {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .price-input-group label {
      font-size: 0.8rem;
      font-weight: 600;
      color: var(--clr-text-medium);
    }

    .price-field {
      position: relative;
    }

    .price-field input {
      width: 100%;
      padding: 0.9rem 2rem 0.9rem 1rem;
      border: 1.5px solid #eee;
      border-radius: 14px;
      font-size: 1rem;
      outline: none;
      background-color: #fafafa;
      transition: all 0.2s;
    }

    .price-field input:focus {
      border-color: var(--clr-primary);
      background-color: white;
      box-shadow: 0 0 0 4px rgba(0, 68, 170, 0.1);
    }

    .price-unit {
      position: absolute;
      right: 0.85rem;
      top: 50%;
      transform: translateY(-50%);
      font-size: 0.85rem;
      color: var(--clr-text-medium);
      pointer-events: none;
    }

    .price-dash {
      padding-bottom: 0.85rem;
      color: var(--clr-text-medium);
      font-weight: 300;
      flex-shrink: 0;
    }

    /* Capacity stepper */
    .capacity-stepper {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border: 1.5px solid #eee;
      border-radius: 16px;
      padding: 0.75rem 1.25rem;
      background-color: #fafafa;
    }

    .stepper-btn {
      width: 2.25rem;
      height: 2.25rem;
      border-radius: 50%;
      border: 1.5px solid #e5e5e7;
      background-color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.15s;
      flex-shrink: 0;
    }

    .stepper-btn svg {
      width: 1.1rem;
      height: 1.1rem;
    }

    .stepper-btn:hover {
      border-color: var(--clr-primary);
      color: var(--clr-primary);
    }

    .stepper-value {
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--clr-text-dark);
      min-width: 4rem;
      text-align: center;
    }

    /* Footer */
    .filter-panel-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      padding: 1.25rem 1.5rem;
      border-top: 1px solid #f0f0f0;
      position: sticky;
      bottom: 0;
      background: white;
    }

    .filter-clear-btn {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--clr-text-dark);
      text-decoration: underline;
      padding: 0.5rem;
    }

    .filter-submit-btn {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      background-color: var(--clr-primary);
      color: white;
      padding: 0.9rem 1.5rem;
      border-radius: 14px;
      font-weight: 700;
      font-size: 1rem;
      box-shadow: 0 6px 14px rgba(0, 68, 170, 0.28);
      transition: transform 0.2s;
    }

    .filter-submit-btn svg {
      width: 1.2rem;
      height: 1.2rem;
    }

    .filter-submit-btn:active { transform: scale(0.98); }
  </style>
@endpush

@push('scripts')
  <script>
    function openFilterPanel() {
      document.getElementById('filter-panel').classList.add('active')
      document.getElementById('filter-panel').setAttribute('aria-hidden', 'false')
      document.body.style.overflow = 'hidden'
    }

    function closeFilterPanel() {
      document.getElementById('filter-panel').classList.remove('active')
      document.getElementById('filter-panel').setAttribute('aria-hidden', 'true')
      document.body.style.overflow = ''
    }

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeFilterPanel()
    })

    // Capacity stepper
    let capacityValue = parseInt(document.getElementById('capacity-input').value) || 0

    function updateCapacityDisplay() {
      const display = document.getElementById('capacity-display')
      const input = document.getElementById('capacity-input')
      if (capacityValue <= 0) {
        display.textContent = 'Tous'
        input.value = ''
      } else {
        display.textContent = capacityValue + ' pers.'
        input.value = capacityValue
      }
    }

    document.getElementById('capacity-increment').addEventListener('click', () => {
      capacityValue = Math.min(capacityValue + 1, 30)
      updateCapacityDisplay()
    })

    document.getElementById('capacity-decrement').addEventListener('click', () => {
      capacityValue = Math.max(capacityValue - 1, 0)
      updateCapacityDisplay()
    })
  </script>
@endpush
