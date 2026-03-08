<header id="header">
  <nav class="header-nav">
    @if (request()->routeIs('home'))
      <div class="header-logo">
        <img src="{{ asset('images/logo.svg') }}" alt="Morgates logo">
      </div>
    @else
      <a href="{{ route('home') }}" class="header-logo">
        <img src="{{ asset('images/logo.svg') }}" alt="Morgates logo">
      </a>
    @endif

    <button type="button" id="drawer-toggle" aria-label="Open menu" aria-expanded="false" aria-controls="drawer">
      @svg('tabler-menu', ['color' => 'var(--clr-primary)'])
    </button>
  </nav>
</header>