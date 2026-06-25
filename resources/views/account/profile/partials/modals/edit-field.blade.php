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

      @if($isPhone)
        @php $userCountry = $user->country ?? 'FR' @endphp
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
        <select
          id="profile-{{ $name }}"
          name="{{ $name }}"
          class="account-country-select"
          onchange="this.closest('form').submit()"
        >
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
          @if(!empty($field['required']) || $name === 'email') required @endif
        >
        @if($name === 'email')
          <p class="field-hint">Appuyez sur Entrée pour enregistrer</p>
        @endif
      @endif

      @if(!empty($field['helperText']))
        <p class="field-hint">{{ $field['helperText'] }}</p>
      @endif
    </form>

    @if($isPhone || $showDelete)
      <div class="account-edit-actions">
        @if($isPhone)
          <button type="submit" form="edit-form-{{ $name }}" class="account-field-save" disabled>Enregistrer</button>
        @endif
        @if($showDelete)
          <button type="button" class="account-field-clear" data-profile-modal-open="{{ $confirmModalId }}" data-profile-modal-close="{{ $editModalId }}">
            @svg('tabler-trash')
            <span>Supprimer</span>
          </button>
        @endif
      </div>
    @endif
  </div>
</dialog>
