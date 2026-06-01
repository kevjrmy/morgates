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
    $displayValue = formatPhoneDisplay($rawValue);
  }

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
@endphp

<div class="account-profile-value {{ empty($displayValue) || $displayValue === ($field['emptyText'] ?? 'Non renseigné') ? 'is-empty' : '' }}" data-profile-modal-open="{{ $editModalId }}" role="button" tabindex="0">
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

<dialog id="{{ $editModalId }}" class="account-bottom-sheet account-edit-sheet" aria-label="Modifier {{ $field['label'] }}">
  <div class="account-bottom-sheet-header">
    <div>
      <h3>@svg($field['icon'], ['class' => 'icon']) {{ $field['label'] }}</h3>
    </div>
    <form method="dialog">
      <button type="submit" class="account-bottom-sheet-close" aria-label="Fermer">
        @svg('tabler-x')
      </button>
    </form>
  </div>

  <div class="account-bottom-sheet-body">
    <form id="edit-form-{{ $name }}" action="{{ route('account.profile.field.update', $name) }}" method="POST" class="account-bottom-sheet-form">
      @csrf
      @method('PUT')

      @if($isTextarea)
        <textarea id="profile-{{ $name }}" name="{{ $name }}" rows="5" placeholder="{{ $field['placeholder'] }}">{{ $value }}</textarea>
      @elseif($isPhone)
        @php
          $userCountry = $user->country ?? 'FR';
        @endphp
        <div class="account-phone-input-wrapper">
          <select id="profile_phone_country_select" class="account-phone-country-select" tabindex="-1" aria-label="Indicatif pays">
            @foreach(config('countries') as $country)
              <option value="{{ $country['dial'] }}" {{ $userCountry === $country['code'] ? 'selected' : '' }}>
                {{ $country['flag'] }} {{ $country['code'] }}
              </option>
            @endforeach
          </select>
          <input
            id="profile-{{ $name }}"
            name="{{ $name }}"
            type="tel"
            value="{{ $value }}"
            placeholder="{{ $field['placeholder'] }}"
            autocomplete="tel"
            data-original-value="{{ $rawValue }}"
          >
        </div>
      @elseif($isCountry)
        <select id="profile-{{ $name }}" name="{{ $name }}" class="account-country-select">
          <option value="" disabled {{ empty($value) ? 'selected' : '' }}>Sélectionnez un pays</option>
          @foreach(config('countries') as $country)
            <option value="{{ $country['code'] }}" {{ $value === $country['code'] ? 'selected' : '' }}>
              {{ $country['flag'] }} {{ $country['label'] }}
            </option>
          @endforeach
        </select>
      @else
        <input
          id="profile-{{ $name }}"
          name="{{ $name }}"
          type="{{ $field['type'] ?? 'text' }}"
          value="{{ $value }}"
          placeholder="{{ $field['placeholder'] }}"
          @isset($field['maxlength']) maxlength="{{ $field['maxlength'] }}" @endisset
          @if(in_array($name, ['first_name', 'email'], true)) required @endif
        >
      @endif

      @if($name === 'last_name')
        <small class="field-hint">* Non visible publiquement</small>
      @endif

      @if(!empty($field['helperText']))
        <p class="field-hint">{{ $field['helperText'] }}</p>
      @endif
    </form>

    <div class="account-edit-actions">
      <button type="submit" form="edit-form-{{ $name }}" class="account-field-save" @if($isPhone) disabled @endif>Enregistrer</button>
      @if($showDelete)
        <button type="button" class="account-field-clear" data-profile-modal-open="{{ $confirmModalId }}" data-profile-modal-close="{{ $editModalId }}">
          @svg('tabler-trash')
          <span>Supprimer</span>
        </button>
      @endif
    </div>
  </div>
</dialog>

<dialog id="{{ $confirmModalId }}" class="account-bottom-sheet account-confirm-sheet" aria-label="Confirmer la suppression de {{ $field['label'] }}">
  <div class="account-bottom-sheet-header">
    <div>
      <h3>Supprimer {{ strtolower($field['label']) }}</h3>
    </div>
    <form method="dialog">
      <button type="submit" class="account-bottom-sheet-close" aria-label="Fermer">
        @svg('tabler-x')
      </button>
    </form>
  </div>

  <div class="account-bottom-sheet-body">
    <p class="account-confirm-copy">Cette information sera retirée de votre profil.</p>

    <form action="{{ route('account.profile.clear', $name) }}" method="POST" class="account-bottom-sheet-clear-form">
      @csrf
      @method('DELETE')
      <button type="submit" class="account-field-clear">Confirmer la suppression</button>
    </form>

    <form method="dialog">
      <button type="submit" class="account-field-cancel">Annuler</button>
    </form>
  </div>
</dialog>

@if($isPhone)
  @push('scripts')
    <script>
      (function() {
        const input = document.getElementById('profile-phone');
        const modal = input?.closest('dialog');
        const saveBtn = modal?.querySelector('.account-field-save');
        const original = input?.dataset.originalValue || '';

        function normalizePhone(val) {
          return val.replace(/[\s\(\)\-]/g, '');
        }

        function isValidPhone(val) {
          const clean = normalizePhone(val);
          return /^(\+33|0033)[1-9]\d{8}$|^0[1-9]\d{8}$|^(\+34|0034)\d{9}$|^[679]\d{8}$/.test(clean);
        }

        function formatPhoneInput() {
          const val = input.value.trim();
          if (!val) return;
          const clean = normalizePhone(val);
          let formatted = '';

          const frMatch = clean.match(/^(?:\+33|0033)([1-9])(\d{2})(\d{2})(\d{2})(\d{2})$/);
          if (frMatch) {
            formatted = '+33 ' + frMatch[1] + ' ' + frMatch[2] + ' ' + frMatch[3] + ' ' + frMatch[4] + ' ' + frMatch[5];
          } else if (/^0[1-9]\d{8}$/.test(clean)) {
            formatted = clean.slice(0, 2) + ' ' + clean.slice(2, 4) + ' ' + clean.slice(4, 6) + ' ' + clean.slice(6, 8) + ' ' + clean.slice(8);
          } else {
            const esMatch = clean.match(/^(?:\+34|0034)([679]\d{2})(\d{2})(\d{2})(\d{2})$/);
            if (esMatch) {
              formatted = '+34 ' + esMatch[1] + ' ' + esMatch[2] + ' ' + esMatch[3] + ' ' + esMatch[4];
            } else if (/^[679]\d{8}$/.test(clean)) {
              formatted = clean.slice(0, 3) + ' ' + clean.slice(3, 5) + ' ' + clean.slice(5, 7) + ' ' + clean.slice(7);
            }
          }

          if (formatted) {
            input.value = formatted;
          }
        }

        function checkPhone() {
          if (!saveBtn) return;
          const val = input.value.trim();
          if (!val) {
            saveBtn.disabled = true;
            return;
          }
          saveBtn.disabled = !(isValidPhone(val) && normalizePhone(val) !== normalizePhone(original));
        }

        input.addEventListener('input', checkPhone);
        input.addEventListener('blur', formatPhoneInput);

        if (modal) {
          new MutationObserver(() => {
            if (modal.open) {
              checkPhone();
              formatPhoneInput();
            }
          }).observe(modal, { attributes: true, attributeFilter: ['open'] });
        }

        checkPhone();
        formatPhoneInput();
      })();
    </script>
  @endpush
@endif
