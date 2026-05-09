@extends('layouts.app')

@section('content')
  <main>
    @include('pages.inc.hero')

    @if($listings->where('type', 'stays')->isNotEmpty())
      <section class="listings-section">
        <h2>Logements récemment ajoutés</h2>
        <div class="listings-scroll">
          @foreach($listings->where('type', 'stays')->take(5) as $listing)
            <x-home.listing-card :listing="$listing" />
          @endforeach
          <x-home.listing-card :more="route('listings', ['type' => 'stays'])" />
        </div>
      </section>
    @endif

    @if($listings->where('type', 'boats')->isNotEmpty())
      <section class="listings-section">
      <h2>Bateaux récemment ajoutés</h2>
        <div class="listings-scroll">
          @foreach($listings->where('type', 'boats')->take(5) as $listing)
            <x-home.listing-card :listing="$listing" />
          @endforeach
          <x-home.listing-card :more="route('listings', ['type' => 'boats'])" />
        </div>
      </section>
    @endif

    <section class="how-it-works">
      <div class="how-it-works-content">
        <div class="icon-wrapper">
          @svg('mdi-lightbulb-outline')
        </div>
        <h2>Comment Morgates fonctionne</h2>
        <p>
          Trouvez ce que vous cherchez en contactant directement les hôtes de façon traditionnelle 
          ou redirigés vers leurs différents liens d'annonces (site web, réseaux sociaux, plateforme de réservation).
        </p>
      </div>
    </section>

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

    .how-it-works {
      padding: 1rem 1.5rem;
    }

    .how-it-works-content {
      background: linear-gradient(145deg, #ffffff, var(--clr-softblue));
      padding: 2.5rem 1.5rem;
      text-align: center;
      border-radius: 24px;
      border: 1px solid rgba(0, 68, 170, 0.1);
      box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }

    .icon-wrapper {
      background-color: white;
      width: 48px;
      height: 48px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(0, 68, 170, 0.1);
      margin-bottom: 0.5rem;
    }

    .icon-wrapper svg {
      color: var(--clr-primary);
      width: 24px;
      height: 24px;
    }

    .how-it-works h2 {
      font-size: 1.35rem;
      font-weight: 700;
      margin-bottom: 0;
      color: var(--clr-text-dark);
    }

    .how-it-works p {
      color: var(--clr-text-medium);
      line-height: 1.6;
      max-width: 500px;
      font-size: 1rem;
    }
  </style>
@endpush
