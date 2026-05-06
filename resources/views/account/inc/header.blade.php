<header id="header">
  <nav class="header-nav">
    <a href="{{ route('home') }}" class="header-logo">
      <img src="{{ asset('images/logo.svg') }}" alt="Morgates logo" width="48" height="48">
    </a>

    <a href="{{ route('home') }}" class="header-brand" aria-label="Accueil Morgates">MORGATES</a>

    <div class="header-user">
      <button type="button" id="user-menu-toggle" aria-label="Ouvrir le menu du compte" aria-expanded="false" aria-controls="user-menu">
        @if(auth()->user()->profile_picture)
          <img src="{{ asset(auth()->user()->profile_picture) }}" alt="{{ auth()->user()->name }}" class="user-avatar">
        @else
          @svg('tabler-user-circle', ['class' => 'user-avatar-placeholder'])
        @endif
        <span class="user-name">{{ auth()->user()->name }}</span>
        @svg('tabler-chevron-down', ['class' => 'user-chevron'])
      </button>

      <div id="user-menu" aria-hidden="true">
        <a href="{{ route('account') }}" class="{{ request()->routeIs('account') ? 'active' : '' }}">
          @svg('tabler-user')
          Mon espace
        </a>
        <a href="{{ route('listings.create.index') }}" class="{{ request()->routeIs('listings.create.*') ? 'active' : '' }}">
          @svg('tabler-circle-plus')
          Publier une annonce
        </a>
        <a href="{{ route('home') }}">
          @svg('tabler-home')
          Accueil
        </a>
        <div class="user-menu-divider"></div>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit">
            @svg('tabler-logout')
            Se déconnecter
          </button>
        </form>
      </div>
    </div>

  </nav>
</header>

@push('scripts')
  <script>
    const header = document.getElementById('header');
    const toggle = document.getElementById('user-menu-toggle');
    const menu = document.getElementById('user-menu');

    const openMenu = () => {
      menu.classList.add('active');
      toggle.setAttribute('aria-expanded', 'true');
      menu.setAttribute('aria-hidden', 'false');
    };

    const closeMenu = () => {
      menu.classList.remove('active');
      toggle.setAttribute('aria-expanded', 'false');
      menu.setAttribute('aria-hidden', 'true');
    };

    toggle.addEventListener('click', (e) => {
      e.stopPropagation();
      menu.classList.contains('active') ? closeMenu() : openMenu();
    });

    document.addEventListener('click', closeMenu);

    window.addEventListener('scroll', () => {
      header.classList.toggle('scrolled', window.scrollY > 10);
    }, { passive: true });
  </script>
@endpush
