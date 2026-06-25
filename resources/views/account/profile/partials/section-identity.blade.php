@php
  $isCompany = $user->isCompany();
  $hasFormError = $errors->hasAny(['account_type', 'first_name', 'last_name', 'company_name', 'host_name', 'bio']);
@endphp

<section class="account-section">
  <form
    id="profile-form"
    action="{{ route('account.profile.identity.update') }}"
    method="POST"
    class="account-profile-form"
  >
    @csrf
    @method('PUT')

    <h2 class="account-section-title">Informations</h2>

    <div class="account-type-selector">
      <label class="account-type-card{{ !$isCompany ? ' is-selected' : '' }}">
        <input type="radio" name="account_type" value="individual" {{ !$isCompany ? 'checked' : '' }}>
        @svg('tabler-user')
        <span>Particulier</span>
      </label>
      <label class="account-type-card{{ $isCompany ? ' is-selected' : '' }}">
        <input type="radio" name="account_type" value="company" {{ $isCompany ? 'checked' : '' }}>
        @svg('tabler-building')
        <span>Entreprise</span>
      </label>
    </div>

    <div id="identity-individual" {{ $isCompany ? 'hidden' : '' }}>
      <div class="account-profile-form-field">
        <label class="account-profile-form-label" for="identity-first-name">Prénom *</label>
        <input
          id="identity-first-name"
          name="first_name"
          type="text"
          value="{{ old('first_name', $user->first_name) }}"
          placeholder="Votre prénom"
          autocomplete="given-name"
        >
        @error('first_name') <small class="field-error">{{ $message }}</small> @enderror
      </div>

      <div class="account-profile-form-field">
        <label class="account-profile-form-label" for="identity-last-name">Nom</label>
        <input
          id="identity-last-name"
          name="last_name"
          type="text"
          value="{{ old('last_name', $user->last_name) }}"
          placeholder="Votre nom"
          autocomplete="family-name"
        >
        @error('last_name') <small class="field-error">{{ $message }}</small> @enderror
      </div>
    </div>

    <div id="identity-company" {{ !$isCompany ? 'hidden' : '' }}>
      <div class="account-profile-form-field">
        <label class="account-profile-form-label" for="identity-company-name">Raison sociale *</label>
        <input
          id="identity-company-name"
          name="company_name"
          type="text"
          value="{{ old('company_name', $user->company_name) }}"
          placeholder="Votre société"
          autocomplete="organization"
        >
        @error('company_name') <small class="field-error">{{ $message }}</small> @enderror
      </div>
    </div>

    <div class="account-profile-form-field">
      <label class="account-profile-form-label" for="identity-host-name">
        Nom d'hôte
        <span class="account-profile-form-label-hint">Visible par les visiteurs sur vos annonces</span>
      </label>
      <input
        id="identity-host-name"
        name="host_name"
        type="text"
        value="{{ old('host_name', $user->host_name) }}"
        placeholder="{{ $user->display_host_name ?: ($isCompany ? 'Mon entreprise' : 'Jean D.') }}"
        autocomplete="nickname"
      >
      @error('host_name') <small class="field-error">{{ $message }}</small> @enderror
    </div>

    <hr class="account-section-divider">

    <h2 class="account-section-title">Présentation</h2>

    <div class="account-profile-form-field">
      <textarea
        id="identity-bio"
        name="bio"
        placeholder="Présentez-vous en quelques lignes"
        rows="5"
      >{{ old('bio', $user->bio) }}</textarea>
      @error('bio') <small class="field-error">{{ $message }}</small> @enderror
    </div>

  </form>

  <hr class="account-section-divider">

  <div class="account-profile-fields">
    @include('account.profile.partials.value-field', [
      'name'  => 'email',
      'field' => ['label' => 'Email', 'type' => 'email', 'placeholder' => 'vous@exemple.fr', 'icon' => 'tabler-mail', 'clearable' => false],
    ])
    @include('account.profile.partials.value-field', [
      'name'  => 'phone',
      'field' => ['label' => 'Téléphone', 'type' => 'tel', 'placeholder' => '+33 6 00 00 00 00', 'icon' => 'tabler-phone'],
    ])
    @include('account.profile.partials.value-field', [
      'name'  => 'country',
      'field' => ['label' => 'Pays', 'type' => 'text', 'placeholder' => 'FR', 'icon' => 'tabler-map-pin', 'maxlength' => 2],
    ])
  </div>
</section>

@push('scripts')
  <script>
    (function() {
      const form = document.getElementById('profile-form')
      const saveBtn = document.getElementById('profile-save')
      const individualFields = document.getElementById('identity-individual')
      const companyFields = document.getElementById('identity-company')

      function enableSave() {
        saveBtn.disabled = false
      }

      form.querySelectorAll('.account-type-card').forEach((card) => {
        card.addEventListener('click', () => {
          const radio = card.querySelector('input[type="radio"]')
          if (!radio) return

          form.querySelectorAll('.account-type-card').forEach(c => c.classList.remove('is-selected'))
          card.classList.add('is-selected')

          const isCompany = radio.value === 'company'
          individualFields.hidden = isCompany
          companyFields.hidden = !isCompany

          enableSave()
        })
      })

      form.querySelectorAll('input[type="text"], textarea').forEach((el) => {
        el.addEventListener('input', enableSave)
      })
    })()
  </script>
@endpush
