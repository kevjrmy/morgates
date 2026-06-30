@extends('layouts.auth')

@section('title', 'Nouveau mot de passe - Morgates')

@section('content')
  <main class="auth-page">
    <div class="auth-card">

      <div class="auth-header">
        <a href="{{ route('home') }}">
          <img src="{{ asset('images/logo.svg') }}" alt="Morgates logo">
        </a>
        <h1>Nouveau mot de passe</h1>
        <p>Choisissez un mot de passe sécurisé pour votre compte.</p>
      </div>

      @if($errors->any())
        <div class="auth-error" role="alert">
          @svg('tabler-alert-circle', ['class' => 'icon'])
          {{ $errors->first() }}
        </div>
      @endif

      <form action="{{ route('password.update') }}" method="POST" class="auth-form">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
          <label for="email">Adresse email</label>
          <input type="email" id="email" name="email" value="{{ old('email', $email) }}"
            placeholder="votre@email.com" autocomplete="email" required>
        </div>

        <div class="form-group">
          <label for="password">Nouveau mot de passe</label>
          <div class="input-password">
            <input type="password" id="password" name="password"
              placeholder="••••••••" autocomplete="new-password" required>
            <button type="button" class="password-toggle" aria-label="Afficher le mot de passe">
              @svg('tabler-eye', ['class' => 'icon icon-show'])
              @svg('tabler-eye-off', ['class' => 'icon icon-hide'])
            </button>
          </div>
          <p class="form-hint">8 caractères min., avec majuscule, chiffre et caractère spécial.</p>
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirmer le mot de passe</label>
          <div class="input-password">
            <input type="password" id="password_confirmation" name="password_confirmation"
              placeholder="••••••••" autocomplete="new-password" required>
            <button type="button" class="password-toggle" aria-label="Afficher le mot de passe">
              @svg('tabler-eye', ['class' => 'icon icon-show'])
              @svg('tabler-eye-off', ['class' => 'icon icon-hide'])
            </button>
          </div>
        </div>

        <button type="submit" class="btn-submit" id="submit-btn" disabled>
          Mettre à jour le mot de passe
        </button>
      </form>

    </div>
  </main>
@endsection

@push('styles')
  <style>
    .form-hint {
      font-size: 0.78rem;
      color: var(--clr-text-light);
      margin-top: 0.125rem;
    }
  </style>
@endpush

@push('scripts')
  <script>
    const toggles = document.querySelectorAll('.password-toggle')
    toggles.forEach(toggle => {
      const input = toggle.closest('.input-password').querySelector('input')
      toggle.addEventListener('click', () => {
        const visible = input.type === 'text'
        input.type = visible ? 'password' : 'text'
        toggle.classList.toggle('visible', !visible)
      })
    })

    const emailInput = document.getElementById('email')
    const passwordInput = document.getElementById('password')
    const confirmInput = document.getElementById('password_confirmation')
    const submitBtn = document.getElementById('submit-btn')

    function validate() {
      const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)
      const passwordOk = passwordInput.value.length >= 8
      const confirmOk = confirmInput.value.length > 0
      submitBtn.disabled = !(emailOk && passwordOk && confirmOk)
    }

    emailInput.addEventListener('input', validate)
    passwordInput.addEventListener('input', validate)
    confirmInput.addEventListener('input', validate)
  </script>
@endpush
