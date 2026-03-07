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

    <form action="{{ route('search') }}" method="GET" role="search" class="header-search">
      <button type="submit" aria-label="Submit search">
        <x-mdi-magnify color="var(--clr-primary)" />
      </button>
      <input type="search" name="q" placeholder="Chercher..." value="{{ request('q') }}" aria-label="Search">
    </form>

    <button type="button" id="drawer-toggle" aria-label="Open menu" aria-expanded="false" aria-controls="drawer">
      <x-mdi-menu />
    </button>

  </nav>
</header>