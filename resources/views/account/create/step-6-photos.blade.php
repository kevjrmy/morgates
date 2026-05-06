{{--
  listings/create/step-6-photos.blade.php
  Step 6: Photos — placeholder for MVP
--}}
@extends('layouts.listing-create')

@section('title', 'Photos — Publier une annonce')

@section('content')
  <div class="lc-step">
    <div class="lc-step-header">
      <h1 class="lc-title">Ajoutez des photos</h1>
      <p class="lc-subtitle">Les annonces avec photos reçoivent beaucoup plus de demandes.</p>
    </div>

    <form action="{{ route('listings.create.photos') }}" method="POST" class="lc-form">
      @csrf

      <div class="lc-photos-placeholder">
        @svg('tabler-camera')
        <p class="lc-photos-placeholder-title">Bientôt disponible</p>
        <p class="lc-photos-placeholder-desc">L'ajout de photos sera disponible prochainement. Vous pourrez en ajouter depuis votre espace après publication.</p>
      </div>

      <div class="lc-actions">
        <a href="{{ route('listings.create.index', ['step' => 5]) }}" class="lc-btn-back">Retour</a>
        <button type="submit" class="lc-btn-next lc-btn-publish">
          @svg('tabler-check')
          Publier l'annonce
        </button>
      </div>
    </form>
  </div>
@endsection