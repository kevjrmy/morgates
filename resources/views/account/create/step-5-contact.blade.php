{{--
  listings/create/step-5-contact.blade.php
  Step 5: Contact details
--}}
@extends('layouts.listing-create')

@section('title', 'Contact — Publier une annonce')

@section('content')
  <div class="lc-step">
    <div class="lc-step-header">
      <h1 class="lc-title">Coordonnées de contact</h1>
      <p class="lc-subtitle">Ces informations seront publiques sur votre annonce.</p>
    </div>

    <form action="{{ route('listings.create.contact') }}" method="POST" class="lc-form">
      @csrf

      @php
        $socialLinks = (array) ($listing->contact_social_links ?? []);
      @endphp

      <div class="lc-fields">

        @error('contact_email')
          <p class="lc-field-error">{{ $message }}</p>
        @enderror

        <div class="lc-field">
          <label for="contact_email" class="lc-label">Email de contact</label>
          <input type="email" name="contact_email" id="contact_email" class="lc-input"
            value="{{ old('contact_email', $listing->contact_email ?? '') }}"
            placeholder="ex. contact@mon-domaine.com">
          <p class="lc-field-error" id="err-email" hidden>Adresse email invalide.</p>
        </div>

        <div class="lc-field">
          <label for="contact_phone" class="lc-label">Téléphone</label>
          <div class="lc-tel-wrap">
            <span class="lc-tel-flag" id="flag-phone" aria-hidden="true"></span>
            <input type="tel" name="contact_phone" id="contact_phone" class="lc-input"
              value="{{ old('contact_phone', $listing->contact_phone ?? '') }}"
              placeholder="ex. 06 12 34 56 78 ou +33 6 12 34 56 78">
          </div>
          <p class="lc-field-error" id="err-phone" hidden>Numéro invalide. Seuls les numéros français (+33) et espagnols (+34) sont acceptés.</p>
        </div>

        <div class="lc-field">
          <label for="contact_whatsapp" class="lc-label">WhatsApp</label>
          <div class="lc-tel-wrap">
            <span class="lc-tel-flag" id="flag-whatsapp" aria-hidden="true"></span>
            <input type="tel" name="contact_whatsapp" id="contact_whatsapp" class="lc-input"
              value="{{ old('contact_whatsapp', $listing->contact_whatsapp ?? '') }}"
              placeholder="ex. 06 12 34 56 78 ou +33 6 12 34 56 78">
          </div>
          <p class="lc-field-error" id="err-whatsapp" hidden>Numéro invalide. Seuls les numéros français (+33) et espagnols (+34) sont acceptés.</p>
        </div>

        <label class="lc-toggle-row" for="whatsapp_same_toggle" style="margin-top: -0.25rem;">
          <span class="lc-toggle-title">Même numéro que le téléphone</span>
          <span class="lc-toggle-switch">
            <input type="checkbox" id="whatsapp_same_toggle" class="lc-toggle-input">
            <span class="lc-toggle-track"><span class="lc-toggle-thumb"></span></span>
          </span>
        </label>

        <div class="lc-field">
          <label for="contact_website" class="lc-label">Site web</label>
          <input type="text" name="contact_website" id="contact_website" class="lc-input"
            value="{{ old('contact_website', $listing->contact_website ?? '') }}"
            placeholder="ex. monsite.com">
          <p class="lc-field-error" id="err-website" hidden>URL invalide (ex. monsite.com).</p>
        </div>

        <div class="lc-field">
          <label for="contact_instagram" class="lc-label">Instagram</label>
          <input type="url" name="contact_instagram" id="contact_instagram" class="lc-input"
            value="{{ old('contact_instagram', $socialLinks['instagram'] ?? '') }}"
            placeholder="ex. https://instagram.com/moncompte">
          <p class="lc-field-error" id="err-instagram" hidden>URL invalide (ex. https://instagram.com/compte).</p>
        </div>

        <div class="lc-field">
          <label for="contact_messenger" class="lc-label">Messenger</label>
          <input type="url" name="contact_messenger" id="contact_messenger" class="lc-input"
            value="{{ old('contact_messenger', $socialLinks['messenger'] ?? '') }}"
            placeholder="ex. https://m.me/moncompte">
          <p class="lc-field-error" id="err-messenger" hidden>URL invalide (ex. https://m.me/compte).</p>
        </div>

        {{-- Preferred contact --}}
        @php $preferredSelected = old('preferred_contact', $listing->preferred_contact ?? '') @endphp
        <div class="lc-field" style="margin-top: 0.5rem;">
          <label class="lc-label">Canal de contact préféré</label>
          <p class="lc-field-hint">Ce canal sera mis en avant sur votre annonce.</p>
          @error('preferred_contact')
            <p class="lc-field-error">{{ $message }}</p>
          @enderror
          <div class="lc-preferred-grid">
            @foreach([
              'email'     => ['icon' => 'mail',            'label' => 'Email'],
              'phone'     => ['icon' => 'phone',           'label' => 'Téléphone'],
              'whatsapp'  => ['icon' => 'brand-whatsapp',  'label' => 'WhatsApp'],
              'website'   => ['icon' => 'world',           'label' => 'Site web'],
              'instagram' => ['icon' => 'brand-instagram', 'label' => 'Instagram'],
              'messenger' => ['icon' => 'brand-messenger', 'label' => 'Messenger'],
            ] as $value => $opt)
              <label class="lc-preferred-opt {{ $preferredSelected === $value ? 'selected' : '' }}"
                     data-channel="{{ $value }}">
                <input type="radio" name="preferred_contact" value="{{ $value }}"
                  {{ $preferredSelected === $value ? 'checked' : '' }}>
                @svg('tabler-' . $opt['icon'])
                {{ $opt['label'] }}
              </label>
            @endforeach
          </div>
        </div>

      </div>

      <div class="lc-actions">
        <a href="{{ route('listings.create.index', ['step' => 4]) }}" class="lc-btn-back">@svg('tabler-arrow-left') Retour</a>
        <button type="submit" class="lc-btn-next" disabled>Continuer</button>
      </div>
    </form>
  </div>
@endsection

@push('styles')
  <style>
    .lc-preferred-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.5rem;
      margin-top: 0.5rem;
    }

    @media (min-width: 480px) {
      .lc-preferred-grid {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    .lc-preferred-opt {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.6rem 0.875rem;
      border: 0.5px solid #EBEBEB;
      border-radius: 10px;
      font-size: 0.875rem;
      font-weight: 500;
      color: var(--clr-text-dark);
      background: var(--clr-background);
      cursor: pointer;
      transition: border-color 0.15s, background 0.15s, color 0.15s, opacity 0.15s;
      user-select: none;
    }

    .lc-preferred-opt input[type="radio"] { display: none; }

    .lc-preferred-opt svg {
      width: 1.1rem;
      height: 1.1rem;
      flex-shrink: 0;
    }

    .lc-preferred-opt:hover:not(.is-disabled) { border-color: var(--clr-secondary); }

    .lc-preferred-opt.selected {
      border-color: var(--clr-primary);
      background: rgba(0, 68, 170, 0.06);
      color: var(--clr-primary);
      font-weight: 600;
    }

    .lc-preferred-opt.is-disabled {
      opacity: 0.35;
      pointer-events: none;
    }

    .lc-field-error {
      font-size: 0.8rem;
      color: #dc2626;
      margin-top: 0.25rem;
    }

    .lc-input--error {
      border-color: #dc2626 !important;
    }

    .lc-toggle-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      padding: 0.65rem 1rem;
      background: #f8fafc;
      border: 1px solid rgba(0,0,0,0.07);
      border-radius: 12px;
      cursor: pointer;
    }

    .lc-toggle-title {
      font-size: 0.875rem;
      font-weight: 500;
      color: var(--clr-text-dark);
    }

    .lc-toggle-switch { flex-shrink: 0; position: relative; }

    .lc-toggle-input {
      position: absolute;
      opacity: 0;
      width: 0;
      height: 0;
    }

    .lc-toggle-track {
      display: block;
      width: 44px;
      height: 24px;
      background: #d1d5db;
      border-radius: 999px;
      position: relative;
      transition: background 0.2s ease;
    }

    .lc-toggle-thumb {
      position: absolute;
      top: 3px;
      left: 3px;
      width: 18px;
      height: 18px;
      background: #fff;
      border-radius: 50%;
      box-shadow: 0 1px 3px rgba(0,0,0,0.2);
      transition: transform 0.2s ease;
    }

    .lc-toggle-input:checked + .lc-toggle-track { background: var(--clr-primary); }
    .lc-toggle-input:checked + .lc-toggle-track .lc-toggle-thumb { transform: translateX(20px); }

    .lc-input.is-synced {
      opacity: 0.5;
      cursor: default;
    }

    .lc-tel-wrap {
      position: relative;
    }

    .lc-tel-flag {
      position: absolute;
      left: 0.75rem;
      top: 50%;
      transform: translateY(-50%);
      font-size: 1.15rem;
      line-height: 1;
      pointer-events: none;
      opacity: 0;
      transition: opacity 0.15s ease;
    }

    .lc-tel-flag.visible {
      opacity: 1;
    }

    .lc-tel-wrap .lc-input {
      padding-left: 0.875rem;
      transition: padding-left 0.15s ease;
    }

    .lc-tel-wrap .lc-input.has-flag {
      padding-left: 2.5rem;
    }
  </style>
@endpush

@push('scripts')
  <script>
    const channels = {
      email:     document.getElementById('contact_email'),
      phone:     document.getElementById('contact_phone'),
      whatsapp:  document.getElementById('contact_whatsapp'),
      website:   document.getElementById('contact_website'),
      instagram: document.getElementById('contact_instagram'),
      messenger: document.getElementById('contact_messenger'),
    }

    const errors = {
      email:     document.getElementById('err-email'),
      phone:     document.getElementById('err-phone'),
      whatsapp:  document.getElementById('err-whatsapp'),
      website:   document.getElementById('err-website'),
      instagram: document.getElementById('err-instagram'),
      messenger: document.getElementById('err-messenger'),
    }

    const validators = {
      email:     v => /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v),
      phone:     v => isValidPhone(v),
      whatsapp:  v => isValidPhone(v),
      website:   v => /^(https?:\/\/)?.+\..+/.test(v),
      instagram: v => /^https?:\/\/.+\..+/.test(v),
      messenger: v => /^https?:\/\/.+\..+/.test(v),
    }

    const flagEmoji = { fr: '🇫🇷', es: '🇪🇸' }

    const detectCountry = value => {
      const clean = value.replace(/[\s\-().]/g, '')
      if (/^\+33/.test(clean) || /^0033/.test(clean)) return 'fr'
      if (/^\+34/.test(clean) || /^0034/.test(clean)) return 'es'
      if (/^0[^0]/.test(clean)) return 'fr'
      if (/^[6789]\d{2,}/.test(clean)) return 'es'
      return null
    }

    const isValidPhone = v => {
      const country = detectCountry(v)
      if (!country) return false
      const noSpace = v.replace(/[\s\-().]/g, '')
      const digits  = v.replace(/\D/g, '')
      if (country === 'fr') {
        if (noSpace.startsWith('+33'))  return digits.length === 11 && /^[1-9]/.test(digits.slice(2))
        if (noSpace.startsWith('0033')) return digits.length === 13 && /^[1-9]/.test(digits.slice(4))
        return digits.length === 10 && /^0[1-9]/.test(digits)
      }
      if (country === 'es') {
        if (noSpace.startsWith('+34'))  return digits.length === 11 && /^[6789]/.test(digits.slice(2))
        if (noSpace.startsWith('0034')) return digits.length === 13 && /^[6789]/.test(digits.slice(4))
        return digits.length === 9 && /^[6789]/.test(digits)
      }
      return false
    }

    const formatPhone = (raw, country) => {
      if (!country) return raw
      const noSpace = raw.replace(/ /g, '')
      const digits  = raw.replace(/\D/g, '')

      if (country === 'fr') {
        if (noSpace.startsWith('+33')) {
          const nat    = digits.slice(2)
          const groups = nat.length ? [nat[0], ...(nat.slice(1).match(/.{1,2}/g) || [])] : []
          return '+33' + (groups.length ? ' ' + groups.join(' ') : '')
        }
        if (noSpace.startsWith('0033')) {
          const nat    = digits.slice(4)
          const groups = nat.length ? [nat[0], ...(nat.slice(1).match(/.{1,2}/g) || [])] : []
          return '0033' + (groups.length ? ' ' + groups.join(' ') : '')
        }
        // Local: XX XX XX XX XX
        return (digits.match(/.{1,2}/g) || []).join(' ')
      }

      if (country === 'es') {
        if (noSpace.startsWith('+34')) {
          const nat    = digits.slice(2)
          const groups = nat.match(/.{1,3}/g) || []
          return '+34' + (groups.length ? ' ' + groups.join(' ') : '')
        }
        if (noSpace.startsWith('0034')) {
          const nat    = digits.slice(4)
          const groups = nat.match(/.{1,3}/g) || []
          return '0034' + (groups.length ? ' ' + groups.join(' ') : '')
        }
        // Local: XXX XXX XXX
        return (digits.match(/.{1,3}/g) || []).join(' ')
      }

      return raw
    }

    const applyFormat = (input) => {
      const country = detectCountry(input.value)
      if (!country) return

      const cursor    = input.selectionStart
      const before    = input.value
      const nonSpaceBeforeCursor = before.slice(0, cursor).replace(/ /g, '').length

      const formatted = formatPhone(before, country)
      if (formatted === before) return

      input.value = formatted

      // Restore cursor: walk formatted string counting non-space chars
      let count  = 0
      let newPos = formatted.length
      for (let i = 0; i < formatted.length; i++) {
        if (formatted[i] !== ' ') count++
        if (count === nonSpaceBeforeCursor) {
          newPos = i + 1
          // Skip any space immediately after so cursor lands on next digit
          while (newPos < formatted.length && formatted[newPos] === ' ') newPos++
          break
        }
      }
      input.setSelectionRange(newPos, newPos)
    }

    const flagEls = {
      phone:    document.getElementById('flag-phone'),
      whatsapp: document.getElementById('flag-whatsapp'),
    }

    const updateFlag = (key, value) => {
      const country = detectCountry(value)
      const el      = flagEls[key]
      const input   = channels[key]
      if (country) {
        el.textContent = flagEmoji[country]
        el.classList.add('visible')
        input.classList.add('has-flag')
      } else {
        el.textContent = ''
        el.classList.remove('visible')
        input.classList.remove('has-flag')
      }
    }

    const sameToggle = document.getElementById('whatsapp_same_toggle')

    const isValidFilled = key => {
      const v = channels[key].value.trim()
      return v !== '' && validators[key](v)
    }

    const syncWhatsapp = () => {
      if (sameToggle.checked) {
        channels.whatsapp.value    = channels.phone.value
        channels.whatsapp.readOnly = true
        channels.whatsapp.classList.add('is-synced')
        errors.whatsapp.hidden = true
        channels.whatsapp.classList.remove('lc-input--error')
        updateFlag('whatsapp', channels.phone.value)
      } else {
        channels.whatsapp.readOnly = false
        channels.whatsapp.classList.remove('is-synced')
        updateFlag('whatsapp', channels.whatsapp.value)
      }
      update()
    }

    sameToggle.addEventListener('change', syncWhatsapp)

    channels.phone.addEventListener('input', () => {
      applyFormat(channels.phone)
      updateFlag('phone', channels.phone.value)
      if (sameToggle.checked) {
        channels.whatsapp.value = channels.phone.value
        updateFlag('whatsapp', channels.phone.value)
      }
    })

    channels.whatsapp.addEventListener('input', () => {
      applyFormat(channels.whatsapp)
      updateFlag('whatsapp', channels.whatsapp.value)
    })

    const preferredOpts = {}
    document.querySelectorAll('.lc-preferred-opt').forEach(opt => {
      const radio = opt.querySelector('input[type="radio"]')
      preferredOpts[radio.value] = { opt, radio }
    })

    const btnNext = document.querySelector('.lc-form .lc-btn-next')

    const update = () => {
      let anyValid   = false
      let hasPreferred = false

      Object.entries(channels).forEach(([key, input]) => {
        const value  = input.value.trim()
        const filled = value !== ''
        const valid  = filled && validators[key](value)
        const { opt, radio } = preferredOpts[key]

        // Error display (only when synced whatsapp inherits phone's error via phone field)
        if (filled && !valid && !(key === 'whatsapp' && sameToggle.checked)) {
          input.classList.add('lc-input--error')
          errors[key].hidden = false
        } else {
          input.classList.remove('lc-input--error')
          errors[key].hidden = true
        }

        if (valid) {
          anyValid = true
          opt.classList.remove('is-disabled')
        } else {
          opt.classList.add('is-disabled')
          if (radio.checked) {
            radio.checked = false
            opt.classList.remove('selected')
          }
        }

        if (radio.checked) hasPreferred = true
      })

      // Auto-select first valid channel if none selected
      if (anyValid && !hasPreferred) {
        const firstValid = Object.keys(channels).find(k => isValidFilled(k))
        if (firstValid) {
          const { opt, radio } = preferredOpts[firstValid]
          radio.checked = true
          opt.classList.add('selected')
          hasPreferred = true
        }
      }

      btnNext.disabled = !anyValid || !hasPreferred
    }

    document.querySelectorAll('.lc-preferred-opt').forEach(opt => {
      opt.addEventListener('click', () => {
        document.querySelectorAll('.lc-preferred-opt').forEach(o => o.classList.remove('selected'))
        opt.classList.add('selected')
        update()
      })
    })

    Object.values(channels).forEach(input => input.addEventListener('input', update))

    applyFormat(channels.phone)
    applyFormat(channels.whatsapp)
    updateFlag('phone',    channels.phone.value)
    updateFlag('whatsapp', channels.whatsapp.value)

    if (channels.phone.value && channels.phone.value === channels.whatsapp.value) {
      sameToggle.checked = true
      syncWhatsapp()
    } else {
      update()
    }
  </script>
@endpush
