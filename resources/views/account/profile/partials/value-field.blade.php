@php
  $value = old($name, $user->$name);
  $rawValue = $user->$name;
  $displayValue = $field['displayValue'] ?? (filled($rawValue) ? $rawValue : ($field['emptyText'] ?? 'Non renseigné'));
  $isClearable = $field['clearable'] ?? true;
  $isTextarea = ($field['type'] ?? 'text') === 'textarea';
  $isPhone = $name === 'phone';
  $isCountry = $name === 'country';
  $hasValue = filled($rawValue);
  $showDelete = $isClearable && $hasValue;
  $editModalId = 'profile-field-edit-' . $name;
  $confirmModalId = 'profile-field-confirm-' . $name;

  if ($isPhone && $hasValue) {
    if (!function_exists('formatPhoneDisplay')) {
      function formatPhoneDisplay($phone) {
        $clean = preg_replace('/[\s\(\)\-]/', '', $phone);

        if (preg_match('/^(?:\+33|0033)(\d)(\d{2})(\d{2})(\d{2})(\d{2})$/', $clean, $m)) {
          return '+33 ' . $m[1] . ' ' . $m[2] . ' ' . $m[3] . ' ' . $m[4] . ' ' . $m[5];
        }
        if (preg_match('/^0(\d)(\d{2})(\d{2})(\d{2})(\d{2})$/', $clean, $m)) {
          return '0' . $m[1] . ' ' . $m[2] . ' ' . $m[3] . ' ' . $m[4] . ' ' . $m[5];
        }
        if (preg_match('/^(?:\+34|0034)(\d{3})(\d{2})(\d{2})(\d{2})$/', $clean, $m)) {
          return '+34 ' . $m[1] . ' ' . $m[2] . ' ' . $m[3] . ' ' . $m[4];
        }
        if (preg_match('/^([679]\d{2})(\d{2})(\d{2})(\d{2})$/', $clean, $m)) {
          return $m[1] . ' ' . $m[2] . ' ' . $m[3] . ' ' . $m[4];
        }

        return $phone;
      }
    }

    $displayValue = formatPhoneDisplay($rawValue);
  }
@endphp

<div
  class="account-profile-value{{ $hasValue ? '' : ' is-empty' }}"
  data-profile-modal-open="{{ $editModalId }}"
  role="button"
  tabindex="0"
>
  @svg($field['icon'], ['class' => 'account-profile-value-icon'])

  <div class="account-profile-value-content">
    <span>{{ $field['label'] }}</span>
    <p>{{ $displayValue }}</p>
    @error($name)
      <small>{{ $message }}</small>
    @enderror
  </div>

  <span class="account-profile-value-menu">
    @svg('tabler-chevron-right')
  </span>
</div>

@include('account.profile.partials.modals.edit-field')
@if($showDelete)
  @include('account.profile.partials.modals.confirm-clear')
@endif

@if($isPhone)
  @push('scripts')
    <script>
      (function() {
        const input = document.getElementById('profile-phone')
        const modal = input?.closest('dialog')
        const saveBtn = modal?.querySelector('.account-field-save')
        const original = input?.dataset.originalValue || ''
        const countrySelect = document.getElementById('profile_phone_country_select')
        const countries = @json(config('countries'))
        const sortedCountries = countries ? [...countries].sort((a, b) => b.dial.length - a.dial.length) : []

        function normalizePhone(val) {
          return val.replace(/[\s\(\)\-]/g, '')
        }

        function isValidPhone(val) {
          const clean = normalizePhone(val)
          return /^(\+33|0033)[1-9]\d{8}$|^0[1-9]\d{8}$|^(\+34|0034)\d{9}$|^[679]\d{8}$/.test(clean)
        }

        function formatPhoneInput() {
          const val = input.value.trim()
          if (!val) return
          const clean = normalizePhone(val)
          let formatted = ''

          const frMatch = clean.match(/^(?:\+33|0033)([1-9])(\d{2})(\d{2})(\d{2})(\d{2})$/)
          if (frMatch) {
            formatted = '+33 ' + frMatch[1] + ' ' + frMatch[2] + ' ' + frMatch[3] + ' ' + frMatch[4] + ' ' + frMatch[5]
          } else if (/^0[1-9]\d{8}$/.test(clean)) {
            formatted = clean.slice(0, 2) + ' ' + clean.slice(2, 4) + ' ' + clean.slice(4, 6) + ' ' + clean.slice(6, 8) + ' ' + clean.slice(8)
          } else {
            const esMatch = clean.match(/^(?:\+34|0034)([679]\d{2})(\d{2})(\d{2})(\d{2})$/)
            if (esMatch) {
              formatted = '+34 ' + esMatch[1] + ' ' + esMatch[2] + ' ' + esMatch[3] + ' ' + esMatch[4]
            } else if (/^[679]\d{8}$/.test(clean)) {
              formatted = clean.slice(0, 3) + ' ' + clean.slice(3, 5) + ' ' + clean.slice(5, 7) + ' ' + clean.slice(7)
            }
          }

          if (formatted) input.value = formatted
        }

        function checkPhone() {
          if (!saveBtn) return
          const val = input.value.trim()
          if (!val) { saveBtn.disabled = true; return }
          saveBtn.disabled = !(isValidPhone(val) && normalizePhone(val) !== normalizePhone(original))
        }

        function syncCountryInput(code) {
          const countryInput = document.getElementById('profile-country')
          if (countryInput) countryInput.value = code
        }

        function updateSelectFromPhone() {
          let val = input.value.trim()
          if (val.startsWith('00')) val = '+' + val.substring(2)
          const clean = val.replace(/[\s\(\)\-]/g, '')
          if (!clean.startsWith('+')) return
          const matched = sortedCountries.find(c => clean.startsWith(c.dial))
          if (matched) {
            countrySelect.value = matched.dial
            syncCountryInput(matched.code)
          }
        }

        if (countrySelect) {
          countrySelect.addEventListener('change', (e) => {
            const newDial = e.target.value
            const matchedNew = sortedCountries.find(c => c.dial === newDial)
            if (matchedNew) syncCountryInput(matchedNew.code)

            let val = input.value.trim()
            if (!val) { input.value = newDial + ' '; input.focus(); return }

            let normalized = val.startsWith('00') ? '+' + val.substring(2) : val
            const clean = normalized.replace(/[\s\(\)\-]/g, '')
            if (clean.startsWith('+')) {
              const matched = sortedCountries.find(c => clean.startsWith(c.dial))
              if (matched) {
                input.value = newDial + ' ' + clean.substring(matched.dial.length)
                input.focus()
                return
              }
            }
            input.value = newDial + ' ' + (clean.startsWith('0') ? clean.substring(1) : val)
            input.focus()
          })

          updateSelectFromPhone()
        }

        input.addEventListener('input', checkPhone)
        input.addEventListener('input', updateSelectFromPhone)
        input.addEventListener('blur', formatPhoneInput)

        if (modal) {
          new MutationObserver(() => {
            if (modal.open) { checkPhone(); formatPhoneInput() }
          }).observe(modal, { attributes: true, attributeFilter: ['open'] })
        }

        checkPhone()
        formatPhoneInput()
      })()
    </script>
  @endpush
@endif
