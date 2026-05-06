{{--
  listings/create/step-5-description.blade.php
  Step 5: Free-text description
--}}
@extends('layouts.listing-create')

@section('title', 'Description — Publier une annonce')

@section('content')
  <div class="lc-step">
    <div class="lc-step-header">
      <h1 class="lc-title">Décrivez votre bien</h1>
      <p class="lc-subtitle">Donnez envie aux voyageurs de choisir votre annonce.</p>
    </div>

    <form action="{{ route('listings.create.description') }}" method="POST" class="lc-form">
      @csrf

      <div class="lc-fields">
        <div class="lc-field">
          <div class="lc-label-row">
            <label for="description" class="lc-label">Description</label>
            <span class="lc-char-count" id="desc-count">0/1000</span>
          </div>
          <textarea
            name="description"
            id="description"
            class="lc-textarea"
            placeholder="Décrivez l'espace, l'ambiance, ce qui rend votre bien unique…"
            maxlength="1000"
            rows="8"
          >{{ old('description', $listing->description ?? '') }}</textarea>
          <p class="lc-field-hint">Les descriptions entre 200 et 500 caractères obtiennent généralement les meilleurs résultats.</p>
        </div>
      </div>

      <div class="lc-actions">
        <a href="{{ route('listings.create.index', ['step' => 4]) }}" class="lc-btn-back">Retour</a>
        <button type="submit" class="lc-btn-next">Continuer</button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    const textarea = document.getElementById('description')
    const counter = document.getElementById('desc-count')
    const update = () => {
      const len = textarea.value.length
      counter.textContent = `${len}/1000`
      counter.classList.toggle('lc-char-count--warn', len > 900)
    }
    textarea.addEventListener('input', update)
    update()
  </script>
@endpush