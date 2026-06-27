{{--
listings/create/step-1-type.blade.php
Step 1: Choose listing type, then title (two-phase JS flow)
--}}
@extends('layouts.listing-create')

@section('title', 'Type de bien — Publier une annonce')

@push('styles')
<style>
  button.lc-type-card {
    width: 100%;
    text-align: left;
    font: inherit;
  }

  .lc-phase {
    display: flex;
    flex-direction: column;
    gap: 2rem;
  }

  .lc-phase-hidden {
    display: none;
  }

  .lc-phase:not(.lc-phase-hidden) {
    animation: lc-phase-in 0.2s ease;
  }

  @keyframes lc-phase-in {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .lc-phase-back {
    background: none;
    border: none;
    padding: 0;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.875rem;
    color: var(--clr-text-light);
    cursor: pointer;
    transition: color 0.15s;
  }

  .lc-phase-back:hover {
    color: var(--clr-text-medium);
  }

  .lc-phase-back svg {
    width: 1rem;
    height: 1rem;
  }
</style>
@endpush

@section('content')
  <div class="lc-step">

    {{-- Phase 1: Type selection --}}
    <div id="phase-type" class="lc-phase">
      <div class="lc-step-header">
        <h1 class="lc-title">Quel type de bien proposez-vous ?</h1>
        <p class="lc-subtitle">Choisissez la catégorie qui correspond le mieux à votre annonce.</p>
      </div>

      <div class="lc-type-grid">
        <button type="button" class="lc-type-card {{ old('type', $listing->type ?? '') === 'stays' ? 'selected' : '' }}" data-type="stays">
          @svg('tabler-home-star')
          <span>
            <span class="lc-type-label">Hébergement</span>
            <span class="lc-type-desc">Maison, appartement, chambre, lieu insolite…</span>
          </span>
        </button>

        <button type="button" class="lc-type-card {{ old('type', $listing->type ?? '') === 'boats' ? 'selected' : '' }}" data-type="boats">
          @svg('tabler-sailboat')
          <span>
            <span class="lc-type-label">Bateau</span>
            <span class="lc-type-desc">Voilier, catamaran, bateau moteur, balade nautique…</span>
          </span>
        </button>
      </div>
    </div>

    {{-- Phase 2: Title --}}
    <form action="{{ route('listings.create.type') }}" method="POST" class="lc-form">
      @csrf
      <input type="hidden" name="type" id="type-value" value="{{ old('type', $listing->type ?? '') }}">

      <div id="phase-title" class="lc-phase lc-phase-hidden">
        <button type="button" id="btn-back" class="lc-phase-back">
          @svg('tabler-arrow-left')
          Retour
        </button>

        <div class="lc-step-header">
          <h1 class="lc-title">Donnez un titre à votre annonce</h1>
          <p class="lc-subtitle">Un bon titre attire plus de visiteurs.</p>
        </div>

        <div class="lc-field">
          <div class="lc-label-row">
            <label for="title" class="lc-label">Titre de l'annonce</label>
            <span class="lc-char-count" id="title-count">0/100</span>
          </div>
          <input type="text" name="title" id="title" class="lc-input"
            value="{{ old('title', $listing->title ?? '') }}"
            maxlength="100" required>
        </div>

        <div class="lc-actions">
          <button type="submit" class="lc-btn-next" id="btn-next" disabled>Continuer</button>
        </div>
      </div>
    </form>

  </div>
@endsection

@push('scripts')
  <script>
    const phaseType  = document.getElementById('phase-type')
    const phaseTitle = document.getElementById('phase-title')
    const typeInput  = document.getElementById('type-value')
    const titleInput = document.getElementById('title')
    const titleCount = document.getElementById('title-count')
    const btnNext    = document.getElementById('btn-next')
    const btnBack    = document.getElementById('btn-back')

    const placeholders = {
      stays: 'ex. Maison avec vue mer à Nice, 4 personnes',
      boats: 'ex. Voilier 10m à Marseille, croisière en famille',
    }

    const showPhaseTitle = (type) => {
      typeInput.value = type
      titleInput.placeholder = placeholders[type] ?? ''
      phaseType.classList.add('lc-phase-hidden')
      phaseTitle.classList.remove('lc-phase-hidden')
      titleInput.focus()
      checkValidity()
    }

    const showPhaseType = () => {
      phaseTitle.classList.add('lc-phase-hidden')
      phaseType.classList.remove('lc-phase-hidden')
    }

    const checkValidity = () => {
      btnNext.disabled = titleInput.value.trim() === ''
    }

    const updateCount = () => {
      titleCount.textContent = `${titleInput.value.length}/100`
    }

    document.querySelectorAll('.lc-type-card').forEach(card => {
      card.addEventListener('click', () => {
        document.querySelectorAll('.lc-type-card').forEach(c => c.classList.remove('selected'))
        card.classList.add('selected')
        showPhaseTitle(card.dataset.type)
      })
    })

    btnBack.addEventListener('click', showPhaseType)

    titleInput.addEventListener('input', () => {
      updateCount()
      checkValidity()
    })

    updateCount()
    checkValidity()
  </script>
@endpush
