{{--
listings/create/step-1-type.blade.php
Step 1: Choose listing type
--}}
@extends('layouts.listing-create')

@section('title', 'Type de bien — Publier une annonce')

@section('content')
  <div class="lc-step">
    <div class="lc-step-header">
      <h1 class="lc-title">Quel type de bien proposez-vous ?</h1>
      <p class="lc-subtitle">Choisissez la catégorie qui correspond le mieux à votre annonce.</p>
    </div>

    <form action="{{ route('listings.create.type') }}" method="POST" class="lc-form">
      @csrf

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

      <div class="lc-type-grid">
        <label class="lc-type-card {{ old('type', $listing->type ?? '') === 'stays' ? 'selected' : '' }}">
          <input type="radio" name="type" value="stays" {{ old('type', $listing->type ?? '') === 'stays' ? 'checked' : '' }}
            required>
          @svg('tabler-home-star')
          <span class="lc-type-label">Hébergement</span>
          <span class="lc-type-desc">Maison, appartement, chambre, lieu insolite…</span>
        </label>

        <label class="lc-type-card {{ old('type', $listing->type ?? '') === 'boats' ? 'selected' : '' }}">
          <input type="radio" name="type" value="boats" {{ old('type', $listing->type ?? '') === 'boats' ? 'checked' : '' }}
            required>
          @svg('tabler-sailboat')
          <span class="lc-type-label">Bateau</span>
          <span class="lc-type-desc">Voilier, catamaran, bateau moteur, balade nautique…</span>
        </label>
      </div>

      <div class="lc-actions">
        <button type="submit" class="lc-btn-next" disabled>Continuer</button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    const nextBtn   = document.querySelector('.lc-btn-next')
    const titleInput = document.getElementById('title')
    const titleCount = document.getElementById('title-count')

    const checkValidity = () => {
      const hasTitle = titleInput.value.trim() !== ''
      const hasType  = !!document.querySelector('.lc-type-card input[type="radio"]:checked')
      nextBtn.disabled = !(hasTitle && hasType)
    }

    // Char counter
    const updateCount = () => titleCount.textContent = `${titleInput.value.length}/100`
    titleInput.addEventListener('input', () => { updateCount(); checkValidity() })
    updateCount()

    // Type card selection
    document.querySelectorAll('.lc-type-card input[type="radio"]').forEach(radio => {
      radio.addEventListener('change', () => {
        document.querySelectorAll('.lc-type-card').forEach(c => c.classList.remove('selected'))
        radio.closest('.lc-type-card').classList.add('selected')
        checkValidity()
      })
    })

    checkValidity()
  </script>
@endpush