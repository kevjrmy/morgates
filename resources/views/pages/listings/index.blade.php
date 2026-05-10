@extends('layouts.app')

@section('content')
  <main id="search-page">

    {{-- Search + filter bar --}}
    @php
      $initialTab      = request('q') ? 'name' : (request('type') ?: 'stays');
      $hasSearchParams = request()->hasAny(['type', 'city', 'region', 'q', 'tag']);
      $hasFilterParams = request()->hasAny(['price_min', 'price_max', 'capacity'])
                         || (request('sort') && request('sort') !== 'latest');
      $searchPlaceholder = $hasSearchParams ? 'Modifier la recherche' : 'Rechercher';
    @endphp

    <div class="search-trigger-bar">
      <x-searchbar
        :placeholder="$searchPlaceholder"
        :initial-tab="$initialTab"
      />
      <button
        type="button"
        id="filter-icon-btn"
        class="filter-icon-btn {{ $hasFilterParams ? 'is-active' : '' }}"
        onclick="openFilterPanel()"
        aria-label="Ouvrir les filtres"
      >
        @svg('tabler-adjustments-horizontal')
      </button>
    </div>

    <x-filter-panel />

    {{-- Active filter chips --}}
    @if($hasSearchParams || $hasFilterParams)
      <div class="search-active-filters">

        @if(request('type'))
          <div class="filter-chip filter-chip--type">
            @if(request('type') === 'stays') @svg('tabler-home-star') <span>Séjours</span>
            @else @svg('tabler-sailboat') <span>Bateaux</span>
            @endif
            <a href="{{ route('listings', request()->except('type')) }}" aria-label="Retirer">@svg('tabler-x')</a>
          </div>
        @endif

        @if(request('city'))
          <div class="filter-chip filter-chip--search">
            @svg('tabler-map-pin') <span>{{ request('city') }}</span>
            <a href="{{ route('listings', request()->except('city')) }}" aria-label="Retirer">@svg('tabler-x')</a>
          </div>
        @endif

        @if(request('region'))
          <div class="filter-chip filter-chip--search">
            @svg('tabler-map') <span>{{ request('region') }}</span>
            <a href="{{ route('listings', request()->except('region')) }}" aria-label="Retirer">@svg('tabler-x')</a>
          </div>
        @endif

        @if(request('tag'))
          <div class="filter-chip filter-chip--search">
            @svg('tabler-tag') <span>{{ request('tag') }}</span>
            <a href="{{ route('listings', request()->except('tag')) }}" aria-label="Retirer">@svg('tabler-x')</a>
          </div>
        @endif

        @if(request('q'))
          <div class="filter-chip filter-chip--q">
            @svg('tabler-search') <span>« {{ request('q') }} »</span>
            <a href="{{ route('listings', request()->except('q')) }}" aria-label="Retirer">@svg('tabler-x')</a>
          </div>
        @endif

        @if(request('price_min'))
          <div class="filter-chip filter-chip--filter">
            @svg('tabler-currency-euro') <span>Min {{ number_format(request('price_min'), 0, ',', ' ') }} €</span>
            <a href="{{ route('listings', request()->except('price_min')) }}" aria-label="Retirer">@svg('tabler-x')</a>
          </div>
        @endif

        @if(request('price_max'))
          <div class="filter-chip filter-chip--filter">
            @svg('tabler-currency-euro') <span>Max {{ number_format(request('price_max'), 0, ',', ' ') }} €</span>
            <a href="{{ route('listings', request()->except('price_max')) }}" aria-label="Retirer">@svg('tabler-x')</a>
          </div>
        @endif

        @if(request('capacity'))
          <div class="filter-chip filter-chip--filter">
            @svg('tabler-users') <span>{{ request('capacity') }} pers. min.</span>
            <a href="{{ route('listings', request()->except('capacity')) }}" aria-label="Retirer">@svg('tabler-x')</a>
          </div>
        @endif

        @if(request('sort') && request('sort') !== 'latest')
          <div class="filter-chip filter-chip--filter">
            @svg('tabler-arrows-sort')
            <span>{{ request('sort') === 'price_asc' ? 'Prix croissant' : 'Prix décroissant' }}</span>
            <a href="{{ route('listings', request()->except('sort')) }}" aria-label="Retirer">@svg('tabler-x')</a>
          </div>
        @endif

      </div>
    @endif

    {{-- Results --}}
    <div class="search-results">
      @forelse($listings as $listing)
        <x-listings.listing-card :listing="$listing" />
      @empty
        <div class="search-empty">
          @svg('tabler-mood-sad')
          <p>Aucun résultat trouvé.</p>
          <a href="{{ route('listings') }}">Effacer les filtres</a>
        </div>
      @endforelse
    </div>

  </main>
@endsection

@push('styles')
  <style>
    #search-page {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }

    /* Search + filter row */
    .search-trigger-bar {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      padding: 1rem 1rem 0.25rem;
    }

    .search-trigger-bar .search-bar-container {
      flex: 1;
    }

    .filter-icon-btn {
      flex-shrink: 0;
      width: 46px;
      height: 46px;
      border-radius: 50%;
      background-color: white;
      border: var(--border);
      box-shadow: var(--box-shadow);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--clr-text-medium);
      transition: all 0.2s;
    }

    .filter-icon-btn svg {
      width: 1.2rem;
      height: 1.2rem;
    }

    .filter-icon-btn:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .filter-icon-btn.is-active {
      background-color: var(--clr-primary);
      border-color: var(--clr-primary);
      color: white;
      box-shadow: 0 4px 12px rgba(0, 68, 170, 0.3);
    }

    /* Active filter chips */
    .search-active-filters {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      padding: 0 1rem;
    }

    .filter-chip {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0.35rem 0.75rem;
      border-radius: 120px;
      font-size: 0.82rem;
      font-weight: 500;
      white-space: nowrap;
    }

    .filter-chip svg {
      width: 0.9rem;
      height: 0.9rem;
      flex-shrink: 0;
    }

    .filter-chip a {
      display: flex;
      align-items: center;
      margin-left: 0.1rem;
      opacity: 0.7;
      transition: opacity 0.15s;
    }

    .filter-chip a:hover { opacity: 1; }

    .filter-chip--type {
      background-color: var(--clr-primary);
      color: #fff;
    }

    .filter-chip--type a { color: #fff; }

    .filter-chip--search {
      background-color: var(--clr-softblue);
      color: var(--clr-primary);
      border: 1px solid rgba(0, 68, 170, 0.15);
    }

    .filter-chip--search a { color: var(--clr-primary); }

    .filter-chip--q {
      background-color: var(--clr-text-dark);
      color: #fff;
    }

    .filter-chip--q a { color: #fff; }

    .filter-chip--filter {
      background-color: #f0f4ff;
      color: var(--clr-primary);
      border: 1px solid rgba(0, 68, 170, 0.2);
    }

    .filter-chip--filter a { color: var(--clr-primary); }

    /* Results */
    .search-results {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      padding: 0.25rem 1rem 2rem;
    }

    /* Empty */
    .search-empty {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.75rem;
      padding: 3rem 1rem;
      color: var(--clr-text-medium);
      text-align: center;
    }

    .search-empty a {
      color: var(--clr-primary);
      text-decoration: underline;
    }
  </style>
@endpush
