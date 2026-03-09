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
  </main>
@endsection

@push('styles')
<style>
  
</style>