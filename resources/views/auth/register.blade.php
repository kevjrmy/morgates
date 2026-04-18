@extends('layouts.auth')

@section('title', 'Inscription — Morgates')
@section('description', 'Créez votre compte Morgates.')

@section('content')
  <main class="auth-page" id="register-page">
    <div class="auth-card">

      <div class="auth-header">
        <a href="{{ route('home') }}">
          <img src="{{ asset('images/logo.svg') }}" alt="Morgates logo">
        </a>
        <h1>Inscription</h1>
        <p>Créez votre compte en quelques secondes.</p>
      </div>

      @if ($errors->any())
        <div class="auth-error" role="alert">
          @svg('tabler-alert-circle', ['class' => 'icon'])
          {{ $errors->first() }}
        </div>
      @endif

      <form action="{{ route('register') }}" method="POST" class="auth-form">
        @csrf

        <div class="form-group">
          <label for="email">Adresse email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="votre@email.com"
            autocomplete="email" required autofocus>
        </div>

        <div class="form-group">
          <label for="password">Mot de passe</label>
          <div class="input-password">
            <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="new-password"
              required>
            <button type="button" class="password-toggle" aria-label="Afficher le mot de passe">
              @svg('tabler-eye', ['class' => 'icon icon-show'])
              @svg('tabler-eye-off', ['class' => 'icon icon-hide'])
            </button>
          </div>
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirmer le mot de passe</label>
          <div class="input-password">
            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••"
              autocomplete="new-password" required>
            <button type="button" class="password-toggle" aria-label="Afficher le mot de passe">
              @svg('tabler-eye', ['class' => 'icon icon-show'])
              @svg('tabler-eye-off', ['class' => 'icon icon-hide'])
            </button>
          </div>
        </div>

        <button type="submit" class="btn-submit">
          Créer mon compte
        </button>

      </form>

      <p class="auth-footer">
        Déjà un compte ?
        <a href="{{ route('login') }}">Se connecter</a>
      </p>

    </div>
  </main>
@endsection

@push('scripts')
  <script>
    document.querySelectorAll('.password-toggle').forEach(toggle => {
      const input = toggle.closest('.input-password').querySelector('input');

      toggle.addEventListener('click', () => {
        const isVisible = input.type === 'text';
        input.type = isVisible ? 'password' : 'text';
        toggle.classList.toggle('visible', !isVisible);
      });
    });
  </script>
@endpush