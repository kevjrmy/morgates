<!DOCTYPE html>
<html lang="fr">

<head>
  <title>@yield('title', 'Morgates - réservation location maison & bateaux')</title>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="google" content="notranslate">
  <meta name="robots"
    content="@yield('robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
  <meta name="title" content="@yield('title', 'Morgates - réservation location maison & bateaux')">
  <meta name="description" content="@yield('description', 'Réservez votre location sur Morgates')">
  <meta name="author" content="Morgates">
  <meta name="keywords" content="@yield('keywords', 'location, bateau, maison')">
  <link rel="canonical" href="@yield('canonical', url()->current())">

  <!-- Language & Locale -->
  <meta property="og:locale" content="fr_FR">
  <meta http-equiv="content-language" content="fr">
  <link rel="alternate" hreflang="fr" href="{{ url()->current() }}">

  <!-- OpenGraph -->
  <meta property="og:type" content="@yield('og_type', 'website')">
  <meta property="og:site_name" content="Morgages">
  <meta property="og:title" content="@yield('og_title', 'Morgates - réservation & location')">
  <meta property="og:description" content="@yield('og_description', 'Morgates - réservation & location')">
  <meta property="og:image" content="@yield('og_image', asset('images/Morgates.png'))">
  <meta property="og:image:width" content="512">
  <meta property="og:image:height" content="512">
  <meta property="og:image:alt" content="@yield('og_image_alt', 'Morgates - réservation & location')">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="@yield('twitter_title', 'Morgates - réservation & location')">
  <meta name="twitter:description" content="@yield('twitter_description', 'Morgates - réservation & location')">
  <meta name="twitter:image" content="@yield('twitter_image', asset('images/Morgates.png'))">
  <meta name="twitter:image:alt" content="@yield('twitter_image_alt', 'Morgates - réservation & location')">

  <!-- DNS Prefetch & Preconnect -->
  <link rel="dns-prefetch" href="https://fonts.bunny.net">
  <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

  <!-- CSS & JS -->
  @vite(['resources/css/app.css', 'resources/css/header.css', 'resources/css/footer.css'])
  @vite(['resources/js/app.js'])
  @stack('styles')
</head>

<body>
  <div id="laravel">
    @include('pages.inc.header')
    @include('partials.flash')
    @yield('content')
    @include('pages.inc.footer')
  </div>

  @stack('scripts')
</body>

</html>