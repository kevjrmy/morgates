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
    // Auto-select card styling on radio change
    const nextBtn = document.querySelector('.lc-btn-next')

    const toggleNext = () => {
      nextBtn.disabled = !document.querySelector('.lc-type-card input[type="radio"]:checked')
    }

    document.querySelectorAll('.lc-type-card input[type="radio"]').forEach(radio => {
      radio.addEventListener('change', () => {
        document.querySelectorAll('.lc-type-card').forEach(c => c.classList.remove('selected'))
        radio.closest('.lc-type-card').classList.add('selected')
        toggleNext()
      })
    })

    toggleNext()
  </script>
@endpush