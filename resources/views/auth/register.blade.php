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

      <form action="{{ route('register') }}" method="POST" class="auth-form" id="register-form" novalidate>
        @csrf

        <div class="form-group">
          <label for="email">Adresse email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="votre@email.com"
            autocomplete="email" required autofocus>
          <span class="field-error" id="email-error"></span>
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
          <div class="password-strength">
            <div class="strength-bars">
              <span class="strength-bar"></span>
              <span class="strength-bar"></span>
              <span class="strength-bar"></span>
              <span class="strength-bar"></span>
            </div>
            <span class="strength-label"></span>
          </div>
          <ul class="password-rules">
            <li class="rule" data-rule="length">
              @svg('tabler-circle-x', ['class' => 'icon rule-icon-fail'])
              @svg('tabler-circle-check', ['class' => 'icon rule-icon-pass'])
              8 caractères minimum
            </li>
            <li class="rule" data-rule="uppercase">
              @svg('tabler-circle-x', ['class' => 'icon rule-icon-fail'])
              @svg('tabler-circle-check', ['class' => 'icon rule-icon-pass'])
              1 majuscule
            </li>
            <li class="rule" data-rule="lowercase">
              @svg('tabler-circle-x', ['class' => 'icon rule-icon-fail'])
              @svg('tabler-circle-check', ['class' => 'icon rule-icon-pass'])
              1 minuscule
            </li>
            <li class="rule" data-rule="number">
              @svg('tabler-circle-x', ['class' => 'icon rule-icon-fail'])
              @svg('tabler-circle-check', ['class' => 'icon rule-icon-pass'])
              1 chiffre
            </li>
            <li class="rule" data-rule="special">
              @svg('tabler-circle-x', ['class' => 'icon rule-icon-fail'])
              @svg('tabler-circle-check', ['class' => 'icon rule-icon-pass'])
              1 caractère spécial (!@#$%...)
            </li>
          </ul>
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
          <span class="field-error" id="confirm-error"></span>
        </div>

        <button type="submit" class="btn-submit" id="btn-submit" disabled>
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
    // Password toggle
    document.querySelectorAll('.password-toggle').forEach(toggle => {
      const input = toggle.closest('.input-password').querySelector('input')
      toggle.addEventListener('click', () => {
        const isVisible = input.type === 'text'
        input.type = isVisible ? 'password' : 'text'
        toggle.classList.toggle('visible', !isVisible)
      })
    })

    // Elements
    const emailInput = document.getElementById('email')
    const passwordInput = document.getElementById('password')
    const confirmInput = document.getElementById('password_confirmation')
    const submitBtn = document.getElementById('btn-submit')
    const emailError = document.getElementById('email-error')
    const confirmError = document.getElementById('confirm-error')
    const bars = document.querySelectorAll('.strength-bar')
    const strengthLabel = document.querySelector('.strength-label')

    // Rules
    const rules = {
      length: v => v.length >= 8,
      uppercase: v => /[A-Z]/.test(v),
      lowercase: v => /[a-z]/.test(v),
      number: v => /[0-9]/.test(v),
      special: v => /[^A-Za-z0-9]/.test(v),
    }

    const strengthLevels = [
      { label: '', color: '' },
      { label: 'Faible', color: '#dc2626' },
      { label: 'Moyen', color: '#f59e0b' },
      { label: 'Bon', color: '#3b82f6' },
      { label: 'Bon', color: '#3b82f6' },
      { label: 'Excellent', color: '#16a34a' },
    ];

    function validateEmail() {
      const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)
      emailError.textContent = emailInput.value && !valid ? 'Adresse email invalide.' : ''
      return valid
    }

    function validatePassword() {
      const val = passwordInput.value
      let score = 0

      document.querySelectorAll('.rule').forEach(el => {
        const passes = rules[el.dataset.rule](val)
        el.classList.toggle('passed', passes)
        if (passes) score++
      })

      // Strength bars
      bars.forEach((bar, i) => {
        bar.style.backgroundColor = i < score ? strengthLevels[score].color : ''
        bar.classList.toggle('active', i < score)
      })
      strengthLabel.textContent = val ? strengthLevels[score].label : ''
      strengthLabel.style.color = strengthLevels[score].color

      return score === 5
    }

    function validateConfirm() {
      const match = confirmInput.value === passwordInput.value
      confirmError.textContent = confirmInput.value && !match ? 'Les mots de passe ne correspondent pas.' : ''
      return match && confirmInput.value !== ''
    }

    function checkForm() {
      const valid = validateEmail() && validatePassword() && validateConfirm()
      submitBtn.disabled = !valid
    }

    emailInput.addEventListener('input', checkForm)
    passwordInput.addEventListener('input', checkForm)
    confirmInput.addEventListener('input', checkForm)
  </script>
@endpush

@push('styles')
  <style>
    .field-error {
      font-size: 0.8rem;
      color: #dc2626;
      min-height: 1rem;
    }

    .password-strength {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-top: 0.5rem;
    }

    .strength-bars {
      display: flex;
      gap: 0.25rem;
      flex: 1;
    }

    .strength-bar {
      height: 4px;
      flex: 1;
      border-radius: 99px;
      background-color: var(--clr-tertiary);
      transition: background-color 0.3s ease;
    }

    .strength-label {
      font-size: 0.8rem;
      font-weight: 600;
      min-width: 4rem;
      text-align: right;
      transition: color 0.3s ease;
    }

    .password-rules {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 0.35rem;
      margin-top: 0.5rem;
    }

    .rule {
      display: flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.8rem;
      color: var(--clr-text-light);
      transition: color 0.2s ease;
    }

    .rule .rule-icon-pass {
      display: none;
      color: #16a34a;
    }

    .rule .rule-icon-fail {
      display: block;
      color: var(--clr-text-light);
    }

    .rule.passed {
      color: #16a34a;
    }

    .rule.passed .rule-icon-pass {
      display: block;
    }

    .rule.passed .rule-icon-fail {
      display: none;
    }

    .btn-submit:disabled {
      opacity: 0.4;
      cursor: not-allowed;
    }
  </style>
@endpush