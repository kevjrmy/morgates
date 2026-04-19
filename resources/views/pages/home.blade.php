@extends('layouts.app')

@section('content')
  <main>
    @include('pages.inc.hero')

    @if($listings->where('type', 'house')->isNotEmpty())
      <section class="listings-section">
        <h2>Maisons recommandées</h2>
        <div class="listings-scroll">
          @foreach($listings->where('type', 'house')->take(5) as $listing)
            <x-home.listing-card :listing="$listing" />
          @endforeach
          <x-home.listing-card :more="route('listings', ['type' => 'house'])" />
        </div>
      </section>
    @endif

    @if($listings->where('type', 'boat')->isNotEmpty())
      <section class="listings-section">
        <h2>Bateaux recommandés</h2>
        <div class="listings-scroll">
          @foreach($listings->where('type', 'boat')->take(5) as $listing)
            <x-home.listing-card :listing="$listing" />
          @endforeach
          <x-home.listing-card :more="route('listings', ['type' => 'boat'])" />
        </div>
      </section>
    @endif

    @if($listings->where('type', 'garage')->isNotEmpty())
      <section class="listings-section">
        <h2>Garages recommandés</h2>
        <div class="listings-scroll">
          @foreach($listings->where('type', 'garage')->take(5) as $listing)
            <x-home.listing-card :listing="$listing" />
          @endforeach
          <x-home.listing-card :more="route('listings', ['type' => 'garage'])" />
        </div>
      </section>
    @endif

    @include('pages.inc.tags')

    @include('pages.inc.destinations')
  </main>
@endsection

@push('styles')
  <style>
    main {
      display: flex;
      flex-direction: column;
      row-gap: 3rem;
      padding-bottom: 2rem;
    }
    
    section {
      padding: 0 1.5rem;
    }

    h2 {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: var(--clr-text-primary);
    }
  </style>
@endpush