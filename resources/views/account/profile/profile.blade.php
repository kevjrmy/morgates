@extends('layouts.account')

@section('title', 'Mon profil — Morgates')

@section('content')
  @php
    $profileFields = [
      'name' => ['label' => 'Prénom', 'type' => 'text', 'placeholder' => 'Votre prénom', 'icon' => 'tabler-user'],
      'email' => ['label' => 'Email', 'type' => 'email', 'placeholder' => 'vous@exemple.fr', 'icon' => 'tabler-mail', 'clearable' => false],
      'phone' => ['label' => 'Téléphone', 'type' => 'tel', 'placeholder' => '+33 6 00 00 00 00', 'icon' => 'tabler-phone'],
      'country' => ['label' => 'Pays', 'type' => 'text', 'placeholder' => 'FR', 'icon' => 'tabler-map-pin', 'maxlength' => 2],
      'location' => ['label' => 'Localisation', 'type' => 'text', 'placeholder' => 'Ville ou région', 'icon' => 'tabler-current-location'],
    ];
    $preferenceFields = [
      'locale' => ['label' => 'Langue', 'type' => 'text', 'placeholder' => 'fr', 'maxlength' => 5, 'icon' => 'tabler-language', 'clearLabel' => 'Réinitialiser'],
    ];
  @endphp

  <main id="account-page" class="account-profile-page">

    <section class="account-profile-hero">
      <div class="account-profile-cover"></div>
      <div class="account-profile-summary">
        <div class="account-profile-avatar">
          @if($user->profile_picture)
            <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->name ?: 'Photo de profil' }}">
          @else
            @svg('tabler-user', ['class' => 'account-avatar-icon'])
          @endif
        </div>

        <div class="account-profile-title">
          <h1>{{ $user->name ?: 'Votre profil' }}</h1>
          <p>{{ $user->email }}</p>
        </div>
      </div>
    </section>

    <section class="account-section">
      <h2 class="account-section-title">Informations personnelles</h2>

      <div class="account-profile-fields">
        @foreach($profileFields as $name => $field)
          @include('account.profile.partials.value-field', ['name' => $name, 'field' => $field])
        @endforeach
      </div>
    </section>

    <section class="account-section">
      <h2 class="account-section-title">Présentation</h2>

      @include('account.profile.partials.value-field', [
        'name' => 'bio',
        'field' => [
          'label' => 'Bio',
          'type' => 'textarea',
          'placeholder' => 'Présentez-vous en quelques lignes',
          'icon' => 'tabler-quote',
          'emptyText' => 'Aucune présentation pour le moment.',
        ],
      ])
    </section>

    <section class="account-section">
      <h2 class="account-section-title">Préférences</h2>

      <div class="account-profile-fields account-profile-preference-fields">
        @foreach($preferenceFields as $name => $field)
          @include('account.profile.partials.value-field', ['name' => $name, 'field' => $field])
        @endforeach
      </div>
    </section>

  </main>
@endsection

@push('scripts')
  <script>
    document.querySelectorAll('[data-profile-modal-open]').forEach((trigger) => {
      trigger.addEventListener('click', () => {
        const modal = document.getElementById(trigger.dataset.profileModalOpen);

        if (modal && typeof modal.showModal === 'function') {
          modal.showModal();
        }
      });
    });

    document.querySelectorAll('.account-bottom-sheet').forEach((modal) => {
      modal.addEventListener('click', (event) => {
        if (event.target === modal) {
          modal.close();
        }
      });
    });
  </script>
@endpush
