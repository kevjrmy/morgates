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
        <label class="lc-type-card {{ old('type', $listing->type ?? '') === 'house' ? 'selected' : '' }}">
          <input type="radio" name="type" value="house" {{ old('type', $listing->type ?? '') === 'house' ? 'checked' : '' }} required>
          @svg('tabler-home')
          <span class="lc-type-label">Maison</span>
          <span class="lc-type-desc">Villa, appartement, chalet…</span>
        </label>

        <label class="lc-type-card {{ old('type', $listing->type ?? '') === 'boat' ? 'selected' : '' }}">
          <input type="radio" name="type" value="boat" {{ old('type', $listing->type ?? '') === 'boat' ? 'checked' : '' }} required>
          @svg('tabler-sailboat')
          <span class="lc-type-label">Bateau</span>
          <span class="lc-type-desc">Voilier, catamaran, yacht…</span>
        </label>

        <label class="lc-type-card {{ old('type', $listing->type ?? '') === 'garage' ? 'selected' : '' }}">
          <input type="radio" name="type" value="garage" {{ old('type', $listing->type ?? '') === 'garage' ? 'checked' : '' }} required>
          @svg('tabler-building-warehouse')
          <span class="lc-type-label">Garage</span>
          <span class="lc-type-desc">Box, parking, entrepôt…</span>
        </label>
      </div>

      <div class="lc-actions">
        <button type="submit" class="lc-btn-next">Continuer</button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    // Auto-select card styling on radio change
    document.querySelectorAll('.lc-type-card input[type="radio"]').forEach(radio => {
      radio.addEventListener('change', () => {
        document.querySelectorAll('.lc-type-card').forEach(c => c.classList.remove('selected'))
        radio.closest('.lc-type-card').classList.add('selected')
      })
    })
  </script>
@endpush