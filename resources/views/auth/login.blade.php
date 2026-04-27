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
            {{-- <a href="{{ route('password.request') }}" class="form-label-link">Mot de passe oublié ?</a> --}}
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

        <div class="form-remember">
          <input type="checkbox" id="remember" name="remember">
          <label for="remember">Se souvenir de moi</label>
        </div>

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