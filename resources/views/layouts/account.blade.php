<!DOCTYPE html>
<html lang="fr">

<head>
  <title>@yield('title', 'Mon espace — Morgates')</title>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="robots" content="noindex, nofollow">

  <!-- DNS Prefetch & Preconnect -->
  <link rel="dns-prefetch" href="https://fonts.bunny.net">
  <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

  <!-- CSS & JS -->
  @vite(['resources/css/app.css', 'resources/css/header.css', 'resources/css/account.css'])
  @vite(['resources/js/app.js'])
  @stack('styles')
</head>

<body id="account-layout">
  <div id="laravel">
    @include('account.inc.header')
    @include('partials.flash')
    @yield('content')
  </div>

  @stack('scripts')
</body>

</html>