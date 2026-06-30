{{--
layouts/listing-create.blade.php
Shared layout for the listing creation multi-step form
--}}
<!DOCTYPE html>
<html lang="fr">

<head>
  <title>@yield('title', 'Publier une annonce - Morgates')</title>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">

  <link rel="dns-prefetch" href="https://fonts.bunny.net">
  <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

  @vite(['resources/css/app.css', 'resources/css/listing-create.css'])
  @vite(['resources/js/app.js'])
  @stack('styles')
</head>

<body id="listing-create-layout">
  <div id="laravel">

    {{-- Top bar --}}
    <header class="lc-header">
      <button type="button" class="lc-cancel" aria-label="Annuler"
        onclick="document.getElementById('lc-cancel-modal').classList.remove('lc-modal-closed')">
        @svg('tabler-x')
      </button>
      <div class="lc-progress">
        <div class="lc-progress-fill" style="width: {{ ($step / $totalSteps) * 100 }}%"></div>
      </div>
      <span class="lc-step-count">{{ $step }}/{{ $totalSteps }}</span>
    </header>

    @include('partials.flash')

    <main class="lc-main">
      @yield('content')
    </main>

  </div>

  {{-- Cancel confirmation modal --}}
  <div id="lc-cancel-modal" class="lc-modal-overlay lc-modal-closed">
    <div class="lc-modal-backdrop"
      onclick="document.getElementById('lc-cancel-modal').classList.add('lc-modal-closed')"></div>
    <div class="lc-modal-card" role="dialog" aria-modal="true" aria-labelledby="lc-modal-title">
      <p class="lc-modal-title" id="lc-modal-title">Quitter la création ?</p>
      <p class="lc-modal-body">Votre progression sera perdue.</p>
      <div class="lc-modal-actions">
        <button type="button" class="lc-modal-btn lc-modal-btn--stay"
          onclick="document.getElementById('lc-cancel-modal').classList.add('lc-modal-closed')">Continuer</button>
        <form action="{{ route('listings.create.cancel') }}" method="POST">
          @csrf
          <button type="submit" class="lc-modal-btn lc-modal-btn--leave">Quitter</button>
        </form>
      </div>
    </div>
  </div>

  @stack('scripts')
</body>

</html>