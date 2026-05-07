@extends('layouts.account')

@section('title', 'Mes abonnements — Morgates')

@section('content')
  @php
    $activeListings = $listings->filter(fn($listing) => (bool) $listing->is_active)->count();
    $inactiveListings = $listings->count() - $activeListings;
    $remainingPublications = max($plan['publication_limit'] - $listings->count(), 0);
  @endphp

  <main id="account-page" class="account-subscriptions-page">

    <section class="account-hero">
      <div>
        <h1 class="account-greeting">Mes abonnements</h1>
        <p class="account-subtitle">Suivez votre formule et vos publications Morgates.</p>
      </div>
    </section>

    <section class="account-section">
      <h2 class="account-section-title">Formule actuelle</h2>

      <div class="account-plan-card">
        <div class="account-plan-header">
          <div>
            <span class="account-plan-label">Abonnement</span>
            <h3>{{ $plan['name'] }}</h3>
          </div>
          <span class="account-listing-status active">{{ $plan['status'] }}</span>
        </div>

        <dl class="account-plan-details">
          <div>
            <dt>Annonces publiées</dt>
            <dd>{{ $listings->count() }} / {{ $plan['publication_limit'] }}</dd>
          </div>
          <div>
            <dt>Fin de période</dt>
            <dd>{{ $plan['ends_at'] }}</dd>
          </div>
          <div>
            <dt>Publications restantes</dt>
            <dd>{{ $remainingPublications }}</dd>
          </div>
        </dl>
      </div>
    </section>

    <section class="account-section">
      <h2 class="account-section-title">Utilisation</h2>

      <div class="account-stats-grid">
        <div class="account-stat">
          @svg('tabler-list-details')
          <span>{{ $listings->count() }}</span>
          <p>Annonces au total</p>
        </div>
        <div class="account-stat">
          @svg('tabler-circle-check')
          <span>{{ $activeListings }}</span>
          <p>Annonces actives</p>
        </div>
        <div class="account-stat">
          @svg('tabler-circle-dashed')
          <span>{{ $inactiveListings }}</span>
          <p>Annonces inactives</p>
        </div>
      </div>
    </section>

    <section class="account-section">
      <div class="account-section-header">
        <h2 class="account-section-title">Publications liées</h2>
        <a href="{{ route('listings.create.index') }}" class="account-section-link">Publier</a>
      </div>

      @if($listings->isEmpty())
        <div class="account-empty">
          @svg('tabler-building-store')
          <p>Vous n'avez pas encore d'annonce liée à votre abonnement.</p>
          <a href="{{ route('listings.create.index') }}" class="btn-primary">Publier une annonce</a>
        </div>
      @else
        <ul class="account-listings">
          @foreach($listings as $listing)
            <li class="account-listing">
              <div class="account-listing-info">
                <span class="account-listing-type">{{ $listing->typeLabel() }}</span>
                <span class="account-listing-title">{{ $listing->title }}</span>
                <span class="account-listing-location">{{ $listing->city }}</span>
              </div>
              <div class="account-listing-meta">
                <span class="account-listing-status {{ $listing->is_active ? 'active' : 'inactive' }}">
                  {{ $listing->is_active ? 'Active' : 'Inactive' }}
                </span>
              </div>
            </li>
          @endforeach
        </ul>
      @endif
    </section>

  </main>
@endsection
