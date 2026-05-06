@extends('layouts.account')

@section('title', 'Mon espace — Morgates')

@section('content')
  @php
    $user = auth()->user();
    $missingFields = collect(['name', 'phone', 'country', 'bio'])
      ->filter(fn($field) => empty($user->$field))
      ->count();
    $profileCompletion = (int) round((4 - $missingFields) / 4 * 100);
  @endphp

  <main id="account-page">

    {{-- Hero --}}
    <section class="account-hero">
      <div class="account-hero-identity">
        <div class="account-avatar">
          @if($user->profile_picture)
            <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->name }}">
          @else
            @svg('tabler-user', ['class' => 'account-avatar-icon'])
          @endif
        </div>
        <div>
          <h1 class="account-greeting">
            Bonjour{{ $user->name ? ', ' . $user->name : '' }} !
          </h1>
          <p class="account-subtitle">Bienvenue sur votre espace.</p>
        </div>
      </div>

      @if($profileCompletion < 100)
        <a href="{{ route('onboarding.index') }}" class="account-completion-bar">
          <div class="account-completion-labels">
            <span>Profil complété</span>
            <span>{{ $profileCompletion }}%</span>
          </div>
          <div class="account-completion-track">
            <div class="account-completion-fill" style="width: {{ $profileCompletion }}%"></div>
          </div>
          <p class="account-completion-hint">Complétez votre profil pour aller plus loin →</p>
        </a>
      @endif
    </section>

    {{-- Quick actions --}}
    <section class="account-section">
      <h2 class="account-section-title">Actions rapides</h2>
      <div class="account-actions">
        <a href="{{ route('account') }}" class="account-action">
          @svg('tabler-list-details')
          <span>Mes annonces</span>
        </a>
        <a href="{{ route('listings.create.index') }}" class="account-action">
          @svg('tabler-plus')
          <span>Publier</span>
        </a>
        <a href="{{ route('onboarding.index') }}" class="account-action">
          @svg('tabler-user-edit')
          <span>Mon profil</span>
        </a>
        <a href="#" class="account-action account-action--disabled" aria-disabled="true">
          @svg('tabler-calendar')
          <span>Réservations</span>
        </a>
      </div>
    </section>

    {{-- Listings --}}
    <section class="account-section">
      <div class="account-section-header">
        <h2 class="account-section-title">Mes annonces</h2>
        @if($listings->isNotEmpty())
          <a href="#" class="account-section-link">Voir tout</a>
        @endif
      </div>

      @if($listings->isEmpty())
        <div class="account-empty">
          @svg('tabler-building-store')
          <p>Vous n'avez pas encore d'annonce.</p>
          <a href="{{ route('listings.create.index') }}" class="btn-primary">Publier ma première annonce</a>
        </div>
      @else
        <ul class="account-listings">
          @foreach($listings->take(5) as $listing)
            <li class="account-listing">
              <div class="account-listing-info">
                <span class="account-listing-type">{{ $listing->type }}</span>
                <span class="account-listing-title">{{ $listing->title }}</span>
                <span class="account-listing-location">{{ $listing->city }}</span>
              </div>
              <div class="account-listing-meta">
                <span class="account-listing-price">{{ number_format($listing->price_per_night, 0, ',', ' ') }}
                  {{ $listing->currency }}<small>/nuit</small></span>
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