@extends('layouts.auth')

@section('title', 'Connexion — Morgates')
@section('description', 'Connectez-vous à votre compte Morgates.')

@section('content')
  <main id="login-page">
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
    const toggle = document.querySelector('.password-toggle');
    const passwordInput = document.getElementById('password');

    toggle.addEventListener('click', () => {
      const isVisible = passwordInput.type === 'text';
      passwordInput.type = isVisible ? 'password' : 'text';
      toggle.classList.toggle('visible', !isVisible);
    });
  </script>
@endpush

@push('styles')
  <style>
    #login-page {
      min-height: calc(100dvh - var(--header-height, 0px));
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }

    .auth-card {
      width: 100%;
      max-width: 420px;
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .auth-header {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.5rem;
      text-align: center;
    }

    .auth-header img {
      height: 3rem;
      border: 2px solid var(--clr-primary);
      border-radius: 50%;
      margin-bottom: 0.5rem;
    }

    .auth-header h1 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--clr-text-primary);
    }

    .auth-header p {
      font-size: 0.9rem;
      color: var(--clr-text-secondary);
    }

    .auth-error {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;
      background-color: rgba(220, 38, 38, 0.08);
      color: #dc2626;
      font-size: 0.9rem;
    }

    .auth-form {
      display: flex;
      flex-direction: column;
      gap: 1.25rem;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.4rem;
    }

    .form-group label {
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--clr-text-primary);
    }

    .form-group input {
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;
      border: var(--border);
      background-color: var(--clr-background);
      color: var(--clr-text-primary);
      font-size: 1rem;
      transition: border-color 0.2s ease;
      width: 100%;
    }

    .form-group input:focus {
      outline: none;
      border-color: var(--clr-primary);
    }

    .form-label-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .form-label-link {
      font-size: 0.8rem;
      color: var(--clr-primary);
    }

    .input-password {
      position: relative;
    }

    .input-password input {
      padding-right: 3rem;
    }

    .password-toggle {
      position: absolute;
      right: 0.75rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: var(--clr-text-secondary);
      display: flex;
      align-items: center;
      padding: 0;
    }

    .password-toggle .icon-hide {
      display: none;
    }

    .password-toggle.visible .icon-show {
      display: none;
    }

    .password-toggle.visible .icon-hide {
      display: block;
    }

    .form-remember {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.875rem;
      color: var(--clr-text-secondary);
    }

    .form-remember input[type="checkbox"] {
      accent-color: var(--clr-primary);
      width: 1rem;
      height: 1rem;
      cursor: pointer;
    }

    .form-remember label {
      cursor: pointer;
    }

    .btn-submit {
      padding: 0.85rem;
      border-radius: 0.5rem;
      background-color: var(--clr-primary);
      color: #fff;
      font-size: 1rem;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: opacity 0.2s ease;
      width: 100%;
    }

    .btn-submit:hover {
      opacity: 0.9;
    }

    .auth-footer {
      text-align: center;
      font-size: 0.875rem;
      color: var(--clr-text-secondary);
    }

    .auth-footer a {
      color: var(--clr-primary);
      font-weight: 600;
    }
  </style>
@endpush