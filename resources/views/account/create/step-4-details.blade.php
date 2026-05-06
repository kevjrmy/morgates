{{--
  listings/create/step-4-details.blade.php
  Step 4: Min/max nights, tags
--}}
@extends('layouts.listing-create')

@section('title', 'Détails — Publier une annonce')

@section('content')
  <div class="lc-step">
    <div class="lc-step-header">
      <h1 class="lc-title">Précisez les conditions</h1>
      <p class="lc-subtitle">Ces informations aident les voyageurs à savoir si votre annonce leur convient.</p>
    </div>

    <form action="{{ route('listings.create.details') }}" method="POST" class="lc-form">
      @csrf

      <div class="lc-fields">

        {{-- Min nights --}}
        <div class="lc-field">
          <label class="lc-label">Durée minimum de séjour</label>
          <div class="lc-stepper">
            <button type="button" class="lc-stepper-btn" data-target="min_nights" data-action="dec" aria-label="Diminuer">
              @svg('tabler-minus')
            </button>
            <div class="lc-stepper-display">
              <input
                type="number"
                name="min_nights"
                id="min_nights"
                class="lc-stepper-input"
                value="{{ old('min_nights', $listing->min_nights ?? 1) }}"
                min="1"
                max="365"
                readonly
              >
              <span class="lc-stepper-unit">nuit(s)</span>
            </div>
            <button type="button" class="lc-stepper-btn" data-target="min_nights" data-action="inc" aria-label="Augmenter">
              @svg('tabler-plus')
            </button>
          </div>
        </div>

        {{-- Max nights --}}
        <div class="lc-field">
          <label class="lc-label">
            Durée maximum de séjour
            <span class="lc-label-optional">optionnel</span>
          </label>
          <div class="lc-stepper">
            <button type="button" class="lc-stepper-btn" data-target="max_nights" data-action="dec" aria-label="Diminuer">
              @svg('tabler-minus')
            </button>
            <div class="lc-stepper-display">
              <input
                type="number"
                name="max_nights"
                id="max_nights"
                class="lc-stepper-input"
                value="{{ old('max_nights', $listing->max_nights ?? '') }}"
                min="1"
                max="365"
                readonly
              >
              <span class="lc-stepper-unit" id="max-nights-label">
                {{ old('max_nights', $listing->max_nights ?? null) ? 'nuit(s)' : 'Sans limite' }}
              </span>
            </div>
            <button type="button" class="lc-stepper-btn" data-target="max_nights" data-action="inc" aria-label="Augmenter">
              @svg('tabler-plus')
            </button>
          </div>
        </div>

        {{-- Tags --}}
        <div class="lc-field">
          <label class="lc-label">
            Équipements & caractéristiques
            <span class="lc-label-optional">optionnel</span>
          </label>
          <div class="lc-tags">
            @php
              $availableTags = ['wifi', 'piscine', 'parking', 'climatisation', 'animaux', 'vue mer', 'terrasse', 'barbecue', 'jacuzzi', 'accès plage'];
              $selectedTags = old('tags', $listing->tags ?? []);
            @endphp
            @foreach($availableTags as $tag)
              <label class="lc-tag {{ in_array($tag, $selectedTags) ? 'selected' : '' }}">
                <input
                  type="checkbox"
                  name="tags[]"
                  value="{{ $tag }}"
                  {{ in_array($tag, $selectedTags) ? 'checked' : '' }}
                >
                {{ ucfirst($tag) }}
              </label>
            @endforeach
          </div>
        </div>

      </div>

      <div class="lc-actions">
        <a href="{{ route('listings.create.index', ['step' => 3]) }}" class="lc-btn-back">Retour</a>
        <button type="submit" class="lc-btn-next">Continuer</button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    // Tag toggle styling
    document.querySelectorAll('.lc-tag input[type="checkbox"]').forEach(cb => {
      cb.addEventListener('change', () => {
        cb.closest('.lc-tag').classList.toggle('selected', cb.checked)
      })
    })

    // Stepper — max_nights has a "Sans limite" zero state
    document.querySelectorAll('.lc-stepper-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.target)
        const isMaxNights = btn.dataset.target === 'max_nights'
        const min = parseInt(input.min) || 1
        const max = parseInt(input.max) || 365
        let val = parseInt(input.value) || 0

        if (btn.dataset.action === 'inc') {
          val = val === 0 ? min : Math.min(val + 1, max)
        } else {
          val = val <= min ? 0 : val - 1
        }

        input.value = val || ''

        if (isMaxNights) {
          document.getElementById('max-nights-label').textContent = val ? 'nuit(s)' : 'Sans limite'
        }
      })
    })

    // Min nights stepper (no zero state)
    // Already handled generically above — min_nights starts at 1
  </script>
@endpush