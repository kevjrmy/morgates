@php
  $value = old($name, $user->$name);
  $displayValue = filled($user->$name) ? $user->$name : ($field['emptyText'] ?? 'Non renseigné');
  $isClearable = $field['clearable'] ?? true;
  $isTextarea = ($field['type'] ?? 'text') === 'textarea';
  $modalId = 'profile-field-modal-' . $name;
@endphp

<div class="account-profile-value {{ empty($user->$name) ? 'is-empty' : '' }}">
  @svg($field['icon'], ['class' => 'account-profile-value-icon'])

  <div class="account-profile-value-content">
    <span>{{ $field['label'] }}</span>
    <p>{{ $displayValue }}</p>
    @error($name)
      <small>{{ $message }}</small>
    @enderror
  </div>

  <button type="button" class="account-profile-value-menu" data-profile-modal-open="{{ $modalId }}" aria-label="Modifier {{ strtolower($field['label']) }}">
    @svg('tabler-dots-vertical')
  </button>
</div>

<dialog id="{{ $modalId }}" class="account-bottom-sheet" aria-label="{{ $field['label'] }}">
  <div class="account-bottom-sheet-header">
    <div>
      <span>{{ $field['label'] }}</span>
    </div>
    <form method="dialog">
      <button type="submit" class="account-bottom-sheet-close" aria-label="Fermer">
        @svg('tabler-x')
      </button>
    </form>
  </div>

  <div class="account-bottom-sheet-body">
    <form action="{{ route('account.profile.field.update', $name) }}" method="POST" class="account-bottom-sheet-form">
      @csrf
      @method('PUT')

      @if($isTextarea)
        <textarea id="profile-{{ $name }}" name="{{ $name }}" rows="5" placeholder="{{ $field['placeholder'] }}">{{ $value }}</textarea>
      @else
        <input
          id="profile-{{ $name }}"
          name="{{ $name }}"
          type="{{ $field['type'] ?? 'text' }}"
          value="{{ $value }}"
          placeholder="{{ $field['placeholder'] }}"
          @isset($field['maxlength']) maxlength="{{ $field['maxlength'] }}" @endisset
          @if($name === 'email') required @endif
        >
      @endif

      <button type="submit" class="account-field-save">Enregistrer</button>
    </form>

    @if($isClearable && filled($user->$name))
      <form action="{{ route('account.profile.clear', $name) }}" method="POST" class="account-bottom-sheet-clear-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="account-field-clear">{{ $field['clearLabel'] ?? 'Supprimer' }}</button>
      </form>
    @endif
  </div>
</dialog>
