@extends('layouts.auth')

@section('title', 'Connexion — Morgates')
@section('description', 'Connectez-vous à votre compte Morgates.')

@section('content')
  <main class="auth-page" id="login-page">
    <div class="auth-card">

      <div class="auth-header">
        <a href="{{ route('home') }}">
          <img src="{{ asset('images/logo.svg') }}" alt="Morgates logo">
        </a>
        <h1>Connexion</h1>
        <p>Bienvenue ! Connectez-vous à votre compte.</p>
      </div>

      @if ($errors->any())
        <div class="auth-error" role="alert">
          @svg('tabler-alert-circle', ['class' => 'icon'])
          {{ $errors->first() }}
        </div>
      @endif

      <form action="{{ route('login') }}" method="POST" class="auth-form">
        @csrf

        <div class="form-group">
          <label for="email">Adresse email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="votre@email.com"
            autocomplete="email" required autofocus>
        </div>

        <div class="form-group">
          <div class="form-label-row">
            <label for="password">Mot de passe</label>
          </div>
          <div class="input-password">
            <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="current-password"
              required>
            <button type="button" class="password-toggle" aria-label="Afficher le mot de passe">
              @svg('tabler-eye', ['class' => 'icon icon-show'])
              @svg('tabler-eye-off', ['class' => 'icon icon-hide'])
            </button>
          </div>
        </div>

        <label class="form-remember">
          <span class="toggle-track">
            <input type="checkbox" id="remember" name="remember">
          </span>
          <span>Se souvenir de moi</span>
        </label>

        <button type="submit" class="btn-submit">
          Connexion
        </button>

      </form>

      <p class="auth-footer">
        Pas encore de compte ?
        <a href="{{ route('register') }}">Créer un compte</a>
      </p>

    </div>
  </main>
@endsection

@push('styles')
  <style scoped>
    .form-remember {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      color: var(--clr-text-dark);
      font-size: 0.95rem;
      font-weight: 500;
      cursor: pointer;
    }

    .toggle-track {
      position: relative;
      width: 44px;
      height: 24px;
      background: #ddd;
      border-radius: 12px;
      transition: background 0.2s;
      flex-shrink: 0;
      cursor: pointer;
    }

    .toggle-track input {
      position: absolute;
      opacity: 0;
      width: 0;
      height: 0;
    }

    .toggle-track::after {
      content: '';
      position: absolute;
      top: 2px;
      left: 2px;
      width: 20px;
      height: 20px;
      background: white;
      border-radius: 50%;
      transition: transform 0.2s;
      box-shadow: 0 1px 3px rgba(0,0,0,0.15);
      pointer-events: none;
    }

    .toggle-track:has(input:checked) {
      background: var(--clr-primary);
    }

    .toggle-track:has(input:checked)::after {
      transform: translateX(20px);
    }
  </style>
@endpush

@push('scripts')
  <script>
    const toggle = document.querySelector('.password-toggle')
    const passwordInput = document.getElementById('password')
    const emailInput = document.getElementById('email')
    const submitBtn = document.querySelector('.btn-submit')
    
    submitBtn.disabled = true

    toggle.addEventListener('click', () => {
      const isVisible = passwordInput.type === 'text'
      passwordInput.type = isVisible ? 'password' : 'text'
      toggle.classList.toggle('visible', !isVisible)
    })

    function isEmailValid() {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)
    }

    function checkForm() {
      submitBtn.disabled = !(isEmailValid() && passwordInput.value.length > 0)
    }

    emailInput.addEventListener('input', checkForm)
    passwordInput.addEventListener('input', checkForm)
  </script>
@endpush