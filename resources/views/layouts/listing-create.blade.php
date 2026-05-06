{{--
layouts/listing-create.blade.php
Shared layout for the listing creation multi-step form
--}}
<!DOCTYPE html>
<html lang="fr">

<head>
  <title>@yield('title', 'Publier une annonce — Morgates')</title>
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
      <a href="{{ route('account') }}" class="lc-cancel" aria-label="Annuler">
        @svg('tabler-x')
      </a>
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

  @stack('scripts')
</body>

</html>