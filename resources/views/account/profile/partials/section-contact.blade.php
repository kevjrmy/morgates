@php
  $socialFields = [
    'instagram' => ['label' => 'Instagram', 'icon' => 'tabler-brand-instagram', 'placeholder' => '@username'],
    'facebook'  => ['label' => 'Facebook',  'icon' => 'tabler-brand-facebook',  'placeholder' => 'URL ou pseudo'],
    'whatsapp'  => ['label' => 'WhatsApp',  'icon' => 'tabler-brand-whatsapp',  'placeholder' => 'Numéro ou lien'],
    'telegram'  => ['label' => 'Telegram',  'icon' => 'tabler-brand-telegram',  'placeholder' => '@username'],
    'linkedin'  => ['label' => 'LinkedIn',  'icon' => 'tabler-brand-linkedin',  'placeholder' => 'URL de votre profil'],
  ];

  $platformFields = [
    'booking' => ['label' => 'Booking', 'icon' => 'tabler-building', 'placeholder' => 'URL de votre profil'],
    'airbnb'  => ['label' => 'Airbnb',  'icon' => 'tabler-home',     'placeholder' => 'URL de votre profil'],
  ];

  $mainCanal = $user->main_contact ?? 'email';
  $canals = [
    'email'     => ['label' => 'Email',     'icon' => 'tabler-mail',             'requires' => null],
    'phone'     => ['label' => 'Téléphone', 'icon' => 'tabler-phone',            'requires' => null],
    'instagram' => ['label' => 'Instagram', 'icon' => 'tabler-brand-instagram',  'requires' => 'instagram'],
    'facebook'  => ['label' => 'Facebook',  'icon' => 'tabler-brand-facebook',   'requires' => 'facebook'],
    'whatsapp'  => ['label' => 'WhatsApp',  'icon' => 'tabler-brand-whatsapp',   'requires' => 'whatsapp'],
    'telegram'  => ['label' => 'Telegram',  'icon' => 'tabler-brand-telegram',   'requires' => 'telegram'],
    'linkedin'  => ['label' => 'LinkedIn',  'icon' => 'tabler-brand-linkedin',   'requires' => 'linkedin'],
    'booking'   => ['label' => 'Booking',   'icon' => 'tabler-building',         'requires' => 'booking'],
    'airbnb'    => ['label' => 'Airbnb',    'icon' => 'tabler-home',             'requires' => 'airbnb'],
  ];
@endphp

<section class="account-section">
  <h2 class="account-section-title">Réseaux sociaux</h2>

  <div class="account-contact-fields">
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

@push('scripts')
  <script>
    function syncMainContact() {
      const emailRadio = document.querySelector('.account-contact-radio[data-canal="email"]')
      let anyChecked = false

      document.querySelectorAll('.account-contact-radio[data-requires]').forEach((radio) => {
        const canal = radio.dataset.requires
        const input = document.querySelector(`.account-contact-field[data-canal="${canal}"] .account-contact-field-input`)
        const hasValue = input && input.value.trim().length > 0

        radio.classList.toggle('is-unavailable', !hasValue)
        radio.setAttribute('aria-disabled', hasValue ? 'false' : 'true')

        if (!hasValue && radio.querySelector('input')?.checked) {
          emailRadio.querySelector('input').checked = true
        }
        if (radio.querySelector('input')?.checked) anyChecked = true
      })

      if (!anyChecked) {
        emailRadio.querySelector('input').checked = true
      }

      document.querySelectorAll('.account-contact-radio').forEach((r) => {
        r.classList.toggle('is-selected', r.querySelector('input')?.checked)
      })
    }

    document.querySelectorAll('.account-contact-field-input').forEach((input) => {
      input.addEventListener('input', syncMainContact)
    })

    document.querySelectorAll('.account-contact-radio').forEach((radio) => {
      radio.addEventListener('click', (e) => {
        if (radio.classList.contains('is-unavailable')) {
          e.preventDefault()
          return
        }
        if (e.target.tagName === 'INPUT') return
        const inp = radio.querySelector('input[type="radio"]')
        if (inp) inp.checked = true
        document.querySelectorAll('.account-contact-radio').forEach((r) => {
          r.classList.toggle('is-selected', r.querySelector('input')?.checked)
        })
      })
    })

    syncMainContact()
  </script>
@endpush
