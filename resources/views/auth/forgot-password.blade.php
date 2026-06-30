@extends('layouts.auth')

@section('title', 'Mot de passe oublié - Morgates')

@section('content')
  <main class="auth-page">
    <div class="auth-card">

      <div class="auth-header">
        <a href="{{ route('home') }}">
          <img src="{{ asset('images/logo.svg') }}" alt="Morgates logo">
        </a>
        <h1>Mot de passe oublié</h1>
        <p>Renseignez votre email et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
      </div>

      @if(session('status'))
        <div class="auth-success" role="status">
          @svg('tabler-circle-check', ['class' => 'icon'])
          {{ session('status') }}
        </div>
      @endif

      @if($errors->any())
        <div class="auth-error" role="alert">
          @svg('tabler-alert-circle', ['class' => 'icon'])
          {{ $errors->first() }}
        </div>
      @endif

      @unless(session('status'))
        <form action="{{ route('password.email') }}" method="POST" class="auth-form">
          @csrf
          <div class="form-group">
            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"
              placeholder="votre@email.com" autocomplete="email" required autofocus>
          </div>

          <button type="submit" class="btn-submit" id="submit-btn" disabled>
            Envoyer le lien
          </button>
        </form>
      @endunless

      <p class="auth-footer">
        <a href="{{ route('login') }}">Retour à la connexion</a>
      </p>

    </div>
  </main>
@endsection

@push('scripts')
  <script>
    const emailInput = document.getElementById('email')
    const submitBtn = document.getElementById('submit-btn')

    if (emailInput && submitBtn) {
      emailInput.addEventListener('input', () => {
        submitBtn.disabled = !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)
      })
    }
  </script>
@endpush

@push('styles')
  <style>
    .auth-success {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;
      background-color: rgba(22, 163, 74, 0.08);
      color: #15803d;
      font-size: 0.9rem;
      line-height: 1.5;
    }
  </style>
@endpush
