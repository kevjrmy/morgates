@extends('layouts.app')

@section('content')
  <main>
    @include('pages.inc.hero')

    <section class="listings-section">
      <h2>Maisons recommandées</h2>
      <div class="listings-scroll">
        @foreach($listings->where('type', 'house') as $listing)
          <x-listing-card :listing="$listing" />
        @endforeach
      </div>
    </section>

    <section class="listings-section">
      <h2>Bateaux recommandés</h2>
      <div class="listings-scroll">
        @foreach($listings->where('type', 'boat') as $listing)
          <x-listing-card :listing="$listing" />
        @endforeach
      </div>
    </section>

    <section class="listings-section">
      <h2>Garages recommandés</h2>
      <div class="listings-scroll">
        @foreach($listings->where('type', 'garage') as $listing)
          <x-listing-card :listing="$listing" />
        @endforeach
      </div>
    </section>

    @include('pages.inc.tags')
  </main>
@endsection

@push('styles')
<style>
  main {
    display: flex;
    flex-direction: column;
    row-gap: 2rem;
  }
</style>