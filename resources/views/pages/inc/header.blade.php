<header id="header">
  <nav class="header-nav">
    @if (request()->routeIs('home'))
      <div class="header-logo">
        <img src="{{ asset('images/logo.svg') }}" alt="Morgates logo" width="48" height="48">
      </div>
    @else
      <a href="{{ route('home') }}" class="header-logo">
        <img src="{{ asset('images/logo.svg') }}" alt="Morgates logo" width="48" height="48">
      </a>
    @endif

    <button type="button" id="drawer-toggle" aria-label="Open menu" aria-expanded="false" aria-controls="drawer">
      @svg('tabler-menu', ['color' => 'var(--clr-primary)'])
    </button>
  </nav>
</header>

{{-- Overlay --}}
<div id="drawer-overlay" aria-hidden="true"></div>

{{-- Drawer --}}
<aside id="drawer" aria-label="Menu de navigation" aria-hidden="true">
  <div class="drawer-header">
    <img src="{{ asset('images/logo.svg') }}" alt="Morgates logo" height="40" width="40">
    <button type="button" id="drawer-close" aria-label="Fermer le menu">
      @svg('tabler-x')
    </button>
  </div>

  <nav class="drawer-nav">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
      @svg('tabler-home')
      Accueil
    </a>
    <a href="{{ route('account') }}" class="{{ request()->routeIs('account') ? 'active' : '' }}">
      @svg('tabler-user')
      Mon espace
    </a>
    <a href="{{ route('listings') }}" class="{{ request()->routeIs('search') ? 'active' : '' }}">
      @svg('tabler-search')
      Annonces
    </a>
  </nav>

  <div class="drawer-footer">
    <a href="{{ route('login') }}" class="btn-login">Connexion</a>
    <a href="{{ route('register') }}" class="btn-signup">Inscription</a>
  </div>
</aside>

@push('scripts')
  <script>
    const drawer = document.getElementById('drawer')
    const overlay = document.getElementById('drawer-overlay')
    const toggle = document.getElementById('drawer-toggle')
    const close = document.getElementById('drawer-close')
    const header = document.getElementById('header')

    const openDrawer = () => {
      drawer.classList.add('active')
      overlay.classList.add('active')
      toggle.setAttribute('aria-expanded', 'true')
      drawer.setAttribute('aria-hidden', 'false')
      document.body.classList.add('drawer-open')
    }

    const closeDrawer = () => {
      drawer.classList.remove('active')
      overlay.classList.remove('active')
      toggle.setAttribute('aria-expanded', 'false')
      drawer.setAttribute('aria-hidden', 'true')
      document.body.classList.remove('drawer-open')
    }

    toggle.addEventListener('click', openDrawer)
    close.addEventListener('click', closeDrawer)
    overlay.addEventListener('click', closeDrawer)
  </script>
@endpush