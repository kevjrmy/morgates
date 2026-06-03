@extends('layouts.account')

@section('title', 'Mon espace — Morgates')

@section('content')
  @php
    $user = auth()->user();
    $missingFields = collect(['first_name', 'phone', 'country', 'bio'])
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
            <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->display_host_name }}">
          @else
            @svg('tabler-user', ['class' => 'account-avatar-icon'])
          @endif
        </div>
        <div>
          <h1 class="account-greeting">
            Bonjour{{ $user->greeting_name ? ', ' . $user->greeting_name : '' }} !
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
        <a href="{{ route('account.listings') }}" class="account-action">
          @svg('tabler-list-details')
          <span>Mes annonces</span>
        </a>
        <a href="{{ route('listings.create.index') }}" class="account-action">
          @svg('tabler-plus')
          <span>Publier</span>
        </a>
        <a href="{{ route('account.profile') }}" class="account-action">
          @svg('tabler-user-edit')
          <span>Mon profil</span>
        </a>
        <a href="{{ route('account.subscriptions.index') }}" class="account-action">
          @svg('tabler-credit-card-pay')
          <span>Mes abonnements</span>
        </a>
      </div>
    </section>



  </main>
@endsection
