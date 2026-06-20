{{--
  listings/create/step-4-details.blade.php
  Step 4: Tags, contact
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

      {{-- Tags --}}
      <div class="lc-field">
        <label class="lc-label">
          Équipements & caractéristiques
          <span class="lc-label-optional">optionnel</span>
        </label>
        <div class="lc-tags">
          @php
            $listingType  = $listing->type ?? 'stays';
            $availableTags = collect(config('tags'))->filter(fn($tag) => $tag['group'] === $listingType)->all();
            $selectedTags  = old('tags', $listing->tags ?? []);
          @endphp
          @foreach($availableTags as $slug => $tag)
            <label class="lc-tag {{ in_array($slug, $selectedTags) ? 'selected' : '' }}">
              <input type="checkbox" name="tags[]" value="{{ $slug }}" {{ in_array($slug, $selectedTags) ? 'checked' : '' }}>
              @svg('tabler-' . $tag['icon'])
              {{ $tag['label'] }}
            </label>
          @endforeach
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

        {{-- Preferred contact --}}
        @php $preferredSelected = old('preferred_contact', $listing->preferred_contact ?? 'email') @endphp
        <div class="lc-field" style="margin-top: 0.5rem;">
          <label class="lc-label">Canal de contact préféré</label>
          <p class="lc-field-hint">Ce canal sera mis en avant sur votre annonce.</p>
          <div class="lc-preferred-grid">
            @foreach([
              'email'    => ['icon' => 'mail',            'label' => 'Email'],
              'phone'    => ['icon' => 'phone',           'label' => 'Téléphone'],
              'whatsapp' => ['icon' => 'brand-whatsapp',  'label' => 'WhatsApp'],
              'website'  => ['icon' => 'world',           'label' => 'Site web'],
            ] as $value => $opt)
              <label class="lc-preferred-opt {{ $preferredSelected === $value ? 'selected' : '' }}">
                <input type="radio" name="preferred_contact" value="{{ $value }}" {{ $preferredSelected === $value ? 'checked' : '' }}>
                @svg('tabler-' . $opt['icon'])
                {{ $opt['label'] }}
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

@push('styles')
  <style>
    .lc-tag {
      gap: 0.35rem;
    }
    .lc-tag svg {
      width: 1rem;
      height: 1rem;
      flex-shrink: 0;
    }

    .lc-preferred-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.5rem;
      margin-top: 0.5rem;
    }

    .lc-preferred-opt {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.6rem 0.875rem;
      border: 0.5px solid #EBEBEB;
      border-radius: 10px;
      font-size: 0.875rem;
      font-weight: 500;
      color: var(--clr-text-dark);
      background: var(--clr-background);
      cursor: pointer;
      transition: border-color 0.15s, background 0.15s, color 0.15s;
      user-select: none;
    }

    .lc-preferred-opt input[type="radio"] {
      display: none;
    }

    .lc-preferred-opt svg {
      width: 1.1rem;
      height: 1.1rem;
      flex-shrink: 0;
    }

    .lc-preferred-opt:hover {
      border-color: var(--clr-secondary);
    }

    .lc-preferred-opt.selected {
      border-color: var(--clr-primary);
      background: rgba(0, 68, 170, 0.06);
      color: var(--clr-primary);
      font-weight: 600;
    }
  </style>
@endpush

@push('scripts')
  <script>
    document.querySelectorAll('.lc-tag input[type="checkbox"]').forEach(cb => {
      cb.addEventListener('change', () => {
        cb.closest('.lc-tag').classList.toggle('selected', cb.checked)
      })
    })

    document.querySelectorAll('.lc-preferred-opt input[type="radio"]').forEach(radio => {
      radio.addEventListener('change', () => {
        document.querySelectorAll('.lc-preferred-opt').forEach(opt => opt.classList.remove('selected'))
        radio.closest('.lc-preferred-opt').classList.add('selected')
      })
    })
  </script>
@endpush
