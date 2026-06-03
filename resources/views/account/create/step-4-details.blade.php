{{--
  listings/create/step-4-details.blade.php
  Step 4: Min/max duration, tags
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

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 250px), 1fr)); gap: 1rem;">
          {{-- Min duration --}}
          <div class="lc-field">
            <label class="lc-label">Durée minimum</label>
            <div class="lc-stepper">
              <button type="button" class="lc-stepper-btn" data-target="min_duration" data-action="dec" aria-label="Diminuer">
                @svg('tabler-minus')
              </button>
              <div class="lc-stepper-display">
                <input
                  type="number"
                  name="min_duration"
                  id="min_duration"
                  class="lc-stepper-input"
                  value="{{ old('min_duration', $listing->min_duration ?? 1) }}"
                  min="1"
                  max="365"
                >
                <span class="lc-stepper-unit">jour(s)</span>
              </div>
              <button type="button" class="lc-stepper-btn" data-target="min_duration" data-action="inc" aria-label="Augmenter">
                @svg('tabler-plus')
              </button>
            </div>
          </div>

          {{-- Max duration --}}
          <div class="lc-field">
            <label class="lc-label">
              Durée maximum
              <span class="lc-label-optional">optionnel</span>
            </label>
            <div class="lc-stepper">
              <button type="button" class="lc-stepper-btn" data-target="max_duration" data-action="dec" aria-label="Diminuer">
                @svg('tabler-minus')
              </button>
              <div class="lc-stepper-display">
                <input
                  type="number"
                  name="max_duration"
                  id="max_duration"
                  class="lc-stepper-input"
                  value="{{ old('max_duration', $listing->max_duration ?? '') }}"
                  min="1"
                  max="365"
                >
                <span class="lc-stepper-unit" id="max-duration-label">
                  {{ old('max_duration', $listing->max_duration ?? null) ? 'jour(s)' : 'Sans limite' }}
                </span>
              </div>
              <button type="button" class="lc-stepper-btn" data-target="max_duration" data-action="inc" aria-label="Augmenter">
                @svg('tabler-plus')
              </button>
            </div>
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

      <div class="lc-fields" style="margin-top: 2rem;">
        <h2 class="lc-label" style="font-size: 1.125rem; font-weight: 600;">Coordonnées de contact</h2>
        <p class="lc-field-hint">Comment les voyageurs peuvent-ils vous joindre ? (Ces informations seront publiques)</p>

        <div class="lc-field">
          <label for="contact_email" class="lc-label">Email de contact</label>
          <input type="email" name="contact_email" id="contact_email" class="lc-input" value="{{ old('contact_email', $listing->contact_email ?? '') }}" placeholder="ex. contact@mon-domaine.com">
        </div>

        <div class="lc-field">
          <label for="contact_phone" class="lc-label">Téléphone</label>
          <input type="tel" name="contact_phone" id="contact_phone" class="lc-input" value="{{ old('contact_phone', $listing->contact_phone ?? '') }}" placeholder="ex. +33 6 12 34 56 78">
        </div>

        <div class="lc-field">
          <label for="contact_whatsapp" class="lc-label">WhatsApp</label>
          <input type="tel" name="contact_whatsapp" id="contact_whatsapp" class="lc-input" value="{{ old('contact_whatsapp', $listing->contact_whatsapp ?? '') }}" placeholder="ex. +33 6 12 34 56 78">
        </div>

        <div class="lc-field">
          <label for="contact_website" class="lc-label">Site web personnel</label>
          <input type="url" name="contact_website" id="contact_website" class="lc-input" value="{{ old('contact_website', $listing->contact_website ?? '') }}" placeholder="ex. https://monsite.com">
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

    // Stepper — max_duration has a "Sans limite" zero state
    document.querySelectorAll('.lc-stepper-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.target)
        const isMaxDuration = btn.dataset.target === 'max_duration'
        const min = parseInt(input.min) || 1
        const max = parseInt(input.max) || 365
        let val = parseInt(input.value) || 0

        if (btn.dataset.action === 'inc') {
          val = val === 0 ? min : Math.min(val + 1, max)
        } else {
          val = val <= min ? 0 : val - 1
        }

        input.value = val || ''

        if (isMaxDuration) {
          document.getElementById('max-duration-label').textContent = val ? 'jour(s)' : 'Sans limite'
        }
      })
    })

    document.getElementById('max_duration').addEventListener('input', (e) => {
      const val = parseInt(e.target.value) || 0
      document.getElementById('max-duration-label').textContent = val ? 'jour(s)' : 'Sans limite'
    })
  </script>
@endpush
