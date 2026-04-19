@extends('layouts.auth')

@section('title', 'Bienvenue — Morgates')
@section('description', 'Complétez votre profil Morgates.')

@section('content')
  <main class="auth-page" id="onboarding-page">
    <div class="auth-card onboarding-card">

      <div class="auth-header">
        <a href="{{ route('home') }}">
          <img src="{{ asset('images/logo.svg') }}" alt="Morgates logo">
        </a>
        <h1>Bienvenue 👋</h1>
        <p>Complétez votre profil en quelques étapes.</p>
      </div>

      {{-- Progress bar --}}
      <div class="onboarding-progress">
        <div class="progress-bar">
          <div class="progress-fill" id="progress-fill"></div>
        </div>
        <span class="progress-label" id="progress-label">Étape 1 sur 5</span>
      </div>

      {{-- Steps wrapper --}}
      <div class="steps-wrapper" id="steps-wrapper">

        {{-- Step 1: Name --}}
        <div class="step" data-step="1">
          <form action="{{ route('onboarding.name') }}" method="POST" class="auth-form">
            @csrf
            <div class="form-group">
              <label for="name">Votre prénom</label>
              <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" placeholder="Prénom"
                autocomplete="given-name" autofocus>
            </div>
            <div class="onboarding-actions">
              <button type="submit" class="btn-submit">Continuer</button>
              <button type="button" class="btn-skip" data-next="2">Passer cette étape</button>
            </div>
          </form>
        </div>

        {{-- Step 2: Profile picture --}}
        <div class="step" data-step="2">
          <form action="{{ route('onboarding.picture') }}" method="POST" enctype="multipart/form-data" class="auth-form">
            @csrf
            <div class="form-group">
              <label>Photo de profil</label>
              <div class="avatar-upload">
                <div class="avatar-preview" id="avatar-preview">
                  @if (auth()->user()->profile_picture)
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Photo de profil">
                  @else
                    @svg('tabler-user', ['class' => 'icon avatar-placeholder'])
                  @endif
                </div>
                <label for="profile_picture" class="btn-upload">
                  @svg('tabler-upload', ['class' => 'icon'])
                  Choisir une photo
                </label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="visually-hidden">
              </div>
            </div>
            <div class="onboarding-actions">
              <button type="submit" class="btn-submit">Continuer</button>
              <button type="button" class="btn-skip" data-next="3">Passer cette étape</button>
            </div>
          </form>
        </div>

        {{-- Step 3: Phone --}}
        <div class="step" data-step="3">
          <form action="{{ route('onboarding.phone') }}" method="POST" class="auth-form">
            @csrf
            <div class="form-group">
              <label for="phone">Numéro de téléphone</label>
              <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                placeholder="+33 6 00 00 00 00" autocomplete="tel">
            </div>
            <div class="onboarding-actions">
              <button type="submit" class="btn-submit">Continuer</button>
              <button type="button" class="btn-skip" data-next="4">Passer cette étape</button>
            </div>
          </form>
        </div>

        {{-- Step 4: Country --}}
        <div class="step" data-step="4">
          <form action="{{ route('onboarding.country') }}" method="POST" class="auth-form">
            @csrf
            <div class="form-group">
              <label for="country">Votre pays</label>
              <select id="country" name="country">
                <option value="" disabled selected>Sélectionnez un pays</option>
                <option value="FR" {{ auth()->user()->country === 'FR' ? 'selected' : '' }}>France</option>
                <option value="BE" {{ auth()->user()->country === 'BE' ? 'selected' : '' }}>Belgique</option>
                <option value="CH" {{ auth()->user()->country === 'CH' ? 'selected' : '' }}>Suisse</option>
                <option value="LU" {{ auth()->user()->country === 'LU' ? 'selected' : '' }}>Luxembourg</option>
                <option value="CA" {{ auth()->user()->country === 'CA' ? 'selected' : '' }}>Canada</option>
                <option value="MA" {{ auth()->user()->country === 'MA' ? 'selected' : '' }}>Maroc</option>
                <option value="TN" {{ auth()->user()->country === 'TN' ? 'selected' : '' }}>Tunisie</option>
                <option value="DZ" {{ auth()->user()->country === 'DZ' ? 'selected' : '' }}>Algérie</option>
                <option value="ES" {{ auth()->user()->country === 'ES' ? 'selected' : '' }}>Espagne</option>
                <option value="IT" {{ auth()->user()->country === 'IT' ? 'selected' : '' }}>Italie</option>
                <option value="DE" {{ auth()->user()->country === 'DE' ? 'selected' : '' }}>Allemagne</option>
                <option value="PT" {{ auth()->user()->country === 'PT' ? 'selected' : '' }}>Portugal</option>
                <option value="GB" {{ auth()->user()->country === 'GB' ? 'selected' : '' }}>Royaume-Uni</option>
                <option value="US" {{ auth()->user()->country === 'US' ? 'selected' : '' }}>États-Unis</option>
              </select>
            </div>
            <div class="onboarding-actions">
              <button type="submit" class="btn-submit">Continuer</button>
              <button type="button" class="btn-skip" data-next="5">Passer cette étape</button>
            </div>
          </form>
        </div>

        {{-- Step 5: Bio --}}
        <div class="step" data-step="5">
          <form action="{{ route('onboarding.bio') }}" method="POST" class="auth-form">
            @csrf
            <div class="form-group">
              <label for="bio">Parlez-nous de vous</label>
              <textarea id="bio" name="bio" rows="4"
                placeholder="Je suis passionné de voyages...">{{ old('bio', auth()->user()->bio) }}</textarea>
              <span class="field-hint">Cette description sera visible sur votre profil public.</span>
            </div>
            <div class="onboarding-actions">
              <button type="submit" class="btn-submit">Terminer</button>
              <a href="{{ route('account') }}" class="btn-skip">Passer cette étape</a>
            </div>
          </form>
        </div>

      </div>
      {{-- end steps-wrapper --}}

    </div>
  </main>
@endsection

@push('scripts')
  <script>
    const totalSteps = 5
    let currentStep = 1

    const wrapper = document.getElementById('steps-wrapper')
    const progressFill = document.getElementById('progress-fill')
    const progressLabel = document.getElementById('progress-label')

    function goToStep(step) {
      currentStep = step
      wrapper.style.transform = `translateX(-${(step - 1) * 100}%)`
      progressFill.style.width = `${(step / totalSteps) * 100}%`
      progressLabel.textContent = `Étape ${step} sur ${totalSteps}`
    }

    // Skip buttons
    document.querySelectorAll('.btn-skip[data-next]').forEach(btn => {
      btn.addEventListener('click', () => goToStep(parseInt(btn.dataset.next)))
    })

    // Profile picture preview
    const pictureInput = document.getElementById('profile_picture')
    const avatarPreview = document.getElementById('avatar-preview')

    pictureInput?.addEventListener('change', () => {
      const file = pictureInput.files[0]
      if (!file) return
      const reader = new FileReader()
      reader.onload = e => {
        avatarPreview.innerHTML = `<img src="${e.target.result}" alt="Aperçu">`
      }
      reader.readAsDataURL(file)
    })

    // After form submit, go to next step (on validation error, Laravel will reload)
    // Steps advance on successful POST via redirect back with step param
    const urlStep = new URLSearchParams(window.location.search).get('step')
    if (urlStep) goToStep(parseInt(urlStep))
  </script>
@endpush

@push('styles')
  <style>
    .onboarding-card {
      max-width: 480px;
      overflow: hidden;
    }

    /* Progress */
    .onboarding-progress {
      display: flex;
      flex-direction: column;
      gap: 0.4rem;
    }

    .progress-bar {
      height: 4px;
      background-color: var(--clr-tertiary);
      border-radius: 99px;
      overflow: hidden;
    }

    .progress-fill {
      height: 100%;
      width: 20%;
      background-color: var(--clr-primary);
      border-radius: 99px;
      transition: width 0.4s ease;
    }

    .progress-label {
      font-size: 0.8rem;
      color: var(--clr-text-light);
      text-align: right;
    }

    /* Steps */
    .steps-wrapper {
      display: flex;
      transition: transform 0.4s ease;
      width: 100%;
    }

    .step {
      min-width: 100%;
    }

    /* Avatar */
    .avatar-upload {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }

    .avatar-preview {
      width: 6rem;
      height: 6rem;
      border-radius: 50%;
      border: 2px solid var(--clr-tertiary);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      background-color: var(--clr-tertiary);
    }

    .avatar-preview img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .avatar-placeholder {
      width: 2rem;
      height: 2rem;
      color: var(--clr-text-light);
    }

    .btn-upload {
      display: flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0.6rem 1.25rem;
      border: var(--border);
      border-radius: 0.5rem;
      font-size: 0.875rem;
      font-weight: 600;
      cursor: pointer;
      color: var(--clr-text-medium);
      transition: border-color 0.2s ease;
    }

    .btn-upload:hover {
      border-color: var(--clr-primary);
      color: var(--clr-primary);
    }

    .visually-hidden {
      position: absolute;
      width: 1px;
      height: 1px;
      overflow: hidden;
      clip: rect(0 0 0 0);
      white-space: nowrap;
    }

    /* Select */
    .form-group select {
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;
      border: var(--border);
      background-color: var(--clr-background);
      color: var(--clr-text-dark);
      font-size: 1rem;
      width: 100%;
      cursor: pointer;
    }

    .form-group select:focus {
      outline: none;
      border-color: var(--clr-primary);
    }

    /* Textarea */
    .form-group textarea {
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;
      border: var(--border);
      background-color: var(--clr-background);
      color: var(--clr-text-dark);
      font-size: 1rem;
      width: 100%;
      resize: vertical;
      transition: border-color 0.2s ease;
    }

    .form-group textarea:focus {
      outline: none;
      border-color: var(--clr-primary);
    }

    .field-hint {
      font-size: 0.8rem;
      color: var(--clr-text-light);
    }

    /* Actions */
    .onboarding-actions {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.75rem;
      margin-top: 0.5rem;
    }

    .btn-skip {
      font-size: 0.875rem;
      color: var(--clr-text-light);
      text-decoration: underline;
      cursor: pointer;
      background: none;
      border: none;
    }

    .btn-skip:hover {
      color: var(--clr-text-medium);
    }
  </style>
@endpush