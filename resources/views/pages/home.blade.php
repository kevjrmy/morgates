@extends('layouts.app')

@section('content')
  <main>
    @include('pages.inc.hero')

    @if($listings->where('type', 'stays')->isNotEmpty())
      <section class="listings-section">
        <h2>Hébergements récemment ajoutés</h2>
        <div class="listings-scroll">
          @foreach($listings->where('type', 'stays')->take(5) as $listing)
            <x-home.listing-card :listing="$listing" />
          @endforeach
          <x-home.listing-card :more="route('listings', ['type' => 'stays'])" />
        </div>
      </section>
    @endif

    @if($listings->where('type', 'sailing')->isNotEmpty())
      <section class="listings-section">
      <h2>Sorties en mer récemment ajoutées</h2>
        <div class="listings-scroll">
          @foreach($listings->where('type', 'sailing')->take(5) as $listing)
            <x-home.listing-card :listing="$listing" />
          @endforeach
          <x-home.listing-card :more="route('listings', ['type' => 'sailing'])" />
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
