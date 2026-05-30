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
  @endphp

  <main id="account-page" class="account-profile-page">

    <section class="account-profile-hero">
      <div class="account-profile-avatar">
        @if($user->profile_picture)
          <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->name ?: 'Photo de profil' }}">
        @else
          @svg('tabler-user', ['class' => 'account-avatar-icon'])
        @endif
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
      <h2 class="account-section-title">Je parle…</h2>

      <div class="account-languages" id="account-languages">
        @php $spoken = json_decode($user->spoken_languages ?? '[]') ?: [] @endphp

        <label class="account-language-tag" data-checked="{{ in_array('fr', $spoken) ? 'true' : 'false' }}">
          <input type="checkbox" name="spoken_languages[]" value="fr" {{ in_array('fr', $spoken) ? 'checked' : '' }}>
          <span>🇫🇷 Français</span>
        </label>

        <label class="account-language-tag" data-checked="{{ in_array('en', $spoken) ? 'true' : 'false' }}">
          <input type="checkbox" name="spoken_languages[]" value="en" {{ in_array('en', $spoken) ? 'checked' : '' }}>
          <span>🇬🇧 English</span>
        </label>

        <label class="account-language-tag" data-checked="{{ in_array('es', $spoken) ? 'true' : 'false' }}">
          <input type="checkbox" name="spoken_languages[]" value="es" {{ in_array('es', $spoken) ? 'checked' : '' }}>
          <span>🇪🇸 Español</span>
        </label>

        <label class="account-language-tag" data-checked="{{ in_array('it', $spoken) ? 'true' : 'false' }}">
          <input type="checkbox" name="spoken_languages[]" value="it" {{ in_array('it', $spoken) ? 'checked' : '' }}>
          <span>🇮🇹 Italiano</span>
        </label>
      </div>
    </section>

    <section class="account-section">
      <h2 class="account-section-title">Réseaux sociaux</h2>

      <div class="account-contact-fields">
        @php
          $socialFields = [
            'instagram' => ['label' => 'Instagram', 'icon' => 'tabler-brand-instagram', 'placeholder' => '@username'],
            'facebook'  => ['label' => 'Facebook',  'icon' => 'tabler-brand-facebook',  'placeholder' => 'URL ou pseudo'],
            'whatsapp'  => ['label' => 'WhatsApp',  'icon' => 'tabler-brand-whatsapp',  'placeholder' => 'Numéro ou lien'],
            'telegram'  => ['label' => 'Telegram',  'icon' => 'tabler-brand-telegram',  'placeholder' => '@username'],
            'linkedin'  => ['label' => 'LinkedIn',  'icon' => 'tabler-brand-linkedin',  'placeholder' => 'URL de votre profil'],
          ];
        @endphp

        @foreach($socialFields as $key => $f)
          <div class="account-contact-field" data-canal="{{ $key }}">
            <div class="account-contact-field-header">
              @svg($f['icon'], ['class' => 'account-contact-field-icon'])
              <span>{{ $f['label'] }}</span>
            </div>
            <input type="text" class="account-contact-field-input" placeholder="{{ $f['placeholder'] }}" value="{{ $user->$key ?? '' }}">
          </div>
        @endforeach
      </div>
    </section>

    <section class="account-section">
      <h2 class="account-section-title">Plateformes de location</h2>

      <div class="account-contact-fields">
        @php
          $platformFields = [
            'booking' => ['label' => 'Booking', 'icon' => 'tabler-building', 'placeholder' => 'URL de votre profil'],
            'airbnb'  => ['label' => 'Airbnb',  'icon' => 'tabler-home',     'placeholder' => 'URL de votre profil'],
          ];
        @endphp

        @foreach($platformFields as $key => $f)
          <div class="account-contact-field" data-canal="{{ $key }}">
            <div class="account-contact-field-header">
              @svg($f['icon'], ['class' => 'account-contact-field-icon'])
              <span>{{ $f['label'] }}</span>
            </div>
            <input type="text" class="account-contact-field-input" placeholder="{{ $f['placeholder'] }}" value="{{ $user->$key ?? '' }}">
          </div>
        @endforeach
      </div>
    </section>

    <section class="account-section">
      <h2 class="account-section-title">Contact principal</h2>

      <p class="account-contact-note">Remplissez d'abord les champs ci-dessus pour activer les options de contact.</p>

      <div class="account-contact-radio-group">
        @php
          $mainCanal = $user->main_contact ?? 'email';
          $canals = [
            'email'     => ['label' => 'Email',     'icon' => 'tabler-mail', 'requires' => null],
            'phone'     => ['label' => 'Téléphone', 'icon' => 'tabler-phone', 'requires' => null],
            'instagram' => ['label' => 'Instagram', 'icon' => 'tabler-brand-instagram', 'requires' => 'instagram'],
            'facebook'  => ['label' => 'Facebook',  'icon' => 'tabler-brand-facebook',  'requires' => 'facebook'],
            'whatsapp'  => ['label' => 'WhatsApp',  'icon' => 'tabler-brand-whatsapp',  'requires' => 'whatsapp'],
            'telegram'  => ['label' => 'Telegram',  'icon' => 'tabler-brand-telegram',  'requires' => 'telegram'],
            'linkedin'  => ['label' => 'LinkedIn',  'icon' => 'tabler-brand-linkedin',  'requires' => 'linkedin'],
            'booking'   => ['label' => 'Booking',   'icon' => 'tabler-building', 'requires' => 'booking'],
            'airbnb'    => ['label' => 'Airbnb',    'icon' => 'tabler-home',     'requires' => 'airbnb'],
          ];
        @endphp

        @foreach($canals as $key => $c)
          @php
            $hasInput = $c['requires'] ? filled($user->{$c['requires']}) : true;
            $available = $key === 'email' || $key === 'phone' || $hasInput;
          @endphp
          <label
            class="account-contact-radio{{ $key === $mainCanal ? ' is-selected' : '' }}{{ !$available ? ' is-unavailable' : '' }}"
            data-canal="{{ $key }}"
            @if($c['requires']) data-requires="{{ $c['requires'] }}" @endif
            @if(!$available) aria-disabled="true" @endif
          >
            <input type="radio" name="main_contact" value="{{ $key }}" {{ $key === $mainCanal ? 'checked' : '' }}>
            @svg($c['icon'], ['class' => 'account-contact-radio-icon'])
            <span>{{ $c['label'] }}</span>
          </label>
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

    // Language tag toggles
    document.querySelectorAll('.account-language-tag').forEach((tag) => {
      tag.addEventListener('click', (e) => {
        if (e.target.tagName === 'INPUT') return;
        const cb = tag.querySelector('input');
        cb.checked = !cb.checked;
        tag.dataset.checked = cb.checked ? 'true' : 'false';
      });
    });

    // Main contact radio — sync availability from social/platform inputs
    function syncMainContact() {
      const emailRadio = document.querySelector('.account-contact-radio[data-canal="email"]');
      let anyChecked = false;

      document.querySelectorAll('.account-contact-radio[data-requires]').forEach((radio) => {
        const canal = radio.dataset.requires;
        const input = document.querySelector(`.account-contact-field[data-canal="${canal}"] .account-contact-field-input`);
        const hasValue = input && input.value.trim().length > 0;

        radio.classList.toggle('is-unavailable', !hasValue);
        radio.setAttribute('aria-disabled', hasValue ? 'false' : 'true');

        if (!hasValue && radio.querySelector('input')?.checked) {
          // fallback to email
          emailRadio.querySelector('input').checked = true;
        }
        if (radio.querySelector('input')?.checked) anyChecked = true;
      });

      if (!anyChecked) {
        emailRadio.querySelector('input').checked = true;
      }

      document.querySelectorAll('.account-contact-radio').forEach((r) => {
        r.classList.toggle('is-selected', r.querySelector('input')?.checked);
      });
    }

    // Listen for input changes in social/platform fields
    document.querySelectorAll('.account-contact-field-input').forEach((input) => {
      input.addEventListener('input', syncMainContact);
    });

    // Click handler — prevent selection of unavailable radios
    document.querySelectorAll('.account-contact-radio').forEach((radio) => {
      radio.addEventListener('click', (e) => {
        if (radio.classList.contains('is-unavailable')) {
          e.preventDefault();
          return;
        }
        if (e.target.tagName === 'INPUT') return;
        const inp = radio.querySelector('input[type="radio"]');
        if (inp) inp.checked = true;
        document.querySelectorAll('.account-contact-radio').forEach((r) => {
          r.classList.toggle('is-selected', r.querySelector('input')?.checked);
        });
      });
    });

    // Initial sync on page load
    syncMainContact();
  </script>
@endpush
