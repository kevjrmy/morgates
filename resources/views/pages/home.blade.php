@extends('layouts.app')

@section('content')
  <main>
    @include('pages.inc.hero')

    @if ($listings->where('type', 'stays')->isNotEmpty())
      <section class="listings-section">
        <h2>Logements récemment ajoutés</h2>
        <div class="listings-scroll">
          @foreach ($listings->where('type', 'stays')->take(5) as $listing)
            <x-home.listing-card :listing="$listing" />
          @endforeach
          <x-home.listing-card :more="route('listings', ['type' => 'stays'])" />
        </div>
      </section>
    @endif

    @if ($listings->where('type', 'boats')->isNotEmpty())
      <section class="listings-section">
        <h2>Bateaux récemment ajoutés</h2>
        <div class="listings-scroll">
          @foreach ($listings->where('type', 'boats')->take(5) as $listing)
            <x-home.listing-card :listing="$listing" />
          @endforeach
          <x-home.listing-card :more="route('listings', ['type' => 'boats'])" />
        </div>
      </section>
    @endif

    <section class="how-it-works">
      <div class="how-it-works-header">
        <h2>Comment ça marche ?</h2>
        <p>Trouvez un logement ou un bateau, contactez l'hôte directement et réservez à votre façon.</p>

      </div>

      <div class="steps-grid">
        <div class="step">
          <div class="step-icon">
            @svg('tabler-search')
          </div>
          <h3>Explorez</h3>
          <p>Parcourez simplement les differentes offres.</p>
        </div>

        <div class="step">
          <div class="step-icon">
            @svg('tabler-messages')
          </div>
          <h3>Choisissez</h3>
          <p>Contactez l'hôte directement via le canal de votre choix.
          </p>
        </div>


        <div class="step">
          <div class="step-icon">
            @svg('tabler-circle-check')
          </div>
          <h3>Profitez</h3>
          <p>Réservez en direct avec l'hôte, sans commission ni frais intermédiaires.</p>
        </div>
      </div>

      <a href="{{ route('contact') }}" class="footer-cta">
        Vous voulez en savoir plus ?
        <span>Contactez-nous</span>
      </a>
    </section>

    @include('pages.inc.destinations')
  </main>
@endsection

@push('styles')
  <style>
    main {
      display: flex;
      flex-direction: column;
      row-gap: 3.5rem;
      padding-bottom: 3rem;
    }

    section {
      padding: 0 1.5rem;
    }

    h2 {
      font-size: 1.25rem;
      font-weight: 600;
      margin-bottom: 1.25rem;
      color: var(--clr-text-primary);
    }

    .how-it-works {
      background: color-mix(in srgb, var(--clr-tertiary) 18%, var(--clr-background));
      padding: 2.5rem 1.25rem;
      text-align: center;
    }

    .how-it-works-header {
      margin-bottom: 2rem;
    }

    .how-it-works-header h2 {
      font-size: 1.375rem;
      font-weight: 700;
      color: var(--clr-text-dark);
      margin-bottom: 0.5rem;
    }

    .how-it-works-header p {
      color: var(--clr-text-medium);
      font-size: 0.9rem;
      max-width: 26rem;
      margin: 0 auto;
      line-height: 1.6;
    }

    .steps-grid {
      display: grid;
      gap: 0.875rem;
      grid-template-columns: 1fr;
    }

    .step {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      gap: 0.625rem;
      padding: 1.375rem 1.25rem;
      background: var(--clr-background);
      border-radius: 0.875rem;
      border: 0.5px solid #EBEBEB;
      box-shadow: var(--box-shadow);
    }

    .step-icon {
      width: 2.75rem;
      height: 2.75rem;
      background: color-mix(in srgb, var(--clr-primary) 10%, transparent);
      color: var(--clr-primary);
      border-radius: 0.625rem;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 0.25rem;
    }

    .step-icon svg {
      width: 1.35rem;
      height: 1.35rem;
    }

    .step h3 {
      font-size: 0.975rem;
      font-weight: 700;
      color: var(--clr-text-dark);
    }

    .step p {
      font-size: 0.85rem;
      color: var(--clr-text-medium);
      line-height: 1.6;
      max-width: 18rem;
    }

    @media (min-width: 560px) {
      .steps-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 0.875rem;
      }

      .step p {
        max-width: none;
      }
    }

    .footer-cta {
      display: inline-block;
      margin-top: 1.75rem;
      font-size: 0.875rem;
      color: var(--clr-text-medium);
    }

    .footer-cta span {
      color: var(--clr-primary);
      font-weight: 600;
    }

    .footer-cta:hover span {
      text-decoration: underline;
      text-underline-offset: 2px;
    }
  </style>
@endpush