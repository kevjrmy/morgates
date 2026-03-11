@extends('layouts.app')

@section('content')
  <main id="search-page">

    {{-- Filters --}}
    <div class="search-filters">
      <div class="filter-scroll">
        <a href="{{ route('search', array_merge(request()->except('type'), [])) }}"
          class="filter-pill {{ !request('type') ? 'active' : '' }}">
          @svg('tabler-layout-grid')
          Tout
        </a>
        <a href="{{ route('search', array_merge(request()->query(), ['type' => 'house'])) }}"
          class="filter-pill {{ request('type') === 'house' ? 'active' : '' }}">
          @svg('tabler-home')
          Maisons
        </a>
        <a href="{{ route('search', array_merge(request()->query(), ['type' => 'boat'])) }}"
          class="filter-pill {{ request('type') === 'boat' ? 'active' : '' }}">
          @svg('tabler-sailboat')
          Bateaux
        </a>
        <a href="{{ route('search', array_merge(request()->query(), ['type' => 'garage'])) }}"
          class="filter-pill {{ request('type') === 'garage' ? 'active' : '' }}">
          @svg('tabler-car-garage')
          Garages
        </a>
      </div>
    </div>

    {{-- Active tag filter indicator --}}
    @if(request('tag'))
      <div class="search-active-tag">
        @svg('tabler-tag')
        {{ request('tag') }}
        <a href="{{ route('search', request()->except('tag')) }}" aria-label="Retirer le filtre">
          @svg('tabler-x')
        </a>
      </div>
    @endif

    {{-- Results --}}
    <div class="search-results">
      @forelse($listings as $listing)
        <x-listing-row :listing="$listing" />
      @empty
        <div class="search-empty">
          @svg('tabler-mood-sad')
          <p>Aucun résultat trouvé.</p>
          <a href="{{ route('search') }}">Effacer les filtres</a>
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
      gap: 1rem;
    }

    /* Filters */
    .search-filters {
      position: sticky;
      top: 0;
      background-color: var(--clr-background);
      z-index: 10;
      border-bottom: 1px solid var(--clr-primary);
      padding: 0.75rem 0;
    }

    .filter-scroll {
      display: flex;
      gap: 0.5rem;
      overflow-x: auto;
      padding: 0 1rem;
      scrollbar-width: none;
    }

    .filter-scroll::-webkit-scrollbar {
      display: none;
    }

    .filter-pill {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      padding: 0.4rem 0.85rem;
      border-radius: 120px;
      border: 1px solid var(--clr-primary);
      font-size: 0.85rem;
      color: var(--clr-text-primary);
      white-space: nowrap;
      transition: background-color 0.2s ease, color 0.2s ease;
      flex-shrink: 0;
    }

    .filter-pill:hover,
    .filter-pill.active {
      background-color: var(--clr-primary);
      color: #fff;
    }

    /* Active tag */
    .search-active-tag {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      margin: 0 1rem;
      padding: 0.4rem 0.85rem;
      border-radius: 120px;
      background-color: var(--clr-primary);
      color: #fff;
      font-size: 0.85rem;
    }

    .search-active-tag a {
      color: #fff;
      display: flex;
      align-items: center;
    }

    /* Results */
    .search-results {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      padding: 0 1rem 2rem;
    }

    /* Empty */
    .search-empty {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.75rem;
      padding: 3rem 1rem;
      color: var(--clr-text-secondary);
      text-align: center;
    }

    .search-empty a {
      color: var(--clr-primary);
      text-decoration: underline;
    }
  </style>
@endpush