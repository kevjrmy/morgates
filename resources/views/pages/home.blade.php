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
            @svg('mdi-magnify')
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
            @svg('mdi-check-decagram-outline')
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
      background: linear-gradient(180deg, transparent, rgba(213, 229, 255, 0.35) 40%, rgba(213, 229, 255, 0.15) 70%, transparent);
      padding: 1.5rem;
      text-align: center;
    }

    .how-it-works-header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .how-it-works-header h2 {
      font-size: 1.85rem;
      font-weight: 800;
      color: var(--clr-text-dark);
      margin-bottom: 0.5rem;
    }

    .how-it-works-header p {
      color: var(--clr-text-medium);
      font-size: 1rem;
      max-width: 400px;
      margin: 0 auto;
      line-height: 1.5;
    }

    .steps-grid {
      display: grid;
      gap: 1.5rem;
      max-width: 1000px;
      margin: 0 auto;
      grid-template-columns: 1fr;
    }

    .step {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      gap: 0.75rem;
      padding: 1.5rem;
      background: white;
      border-radius: 20px;
      border: 1px solid rgba(0, 68, 170, 0.06);
      box-shadow: 0 8px 20px -6px rgba(0, 68, 170, 0.06);
      position: relative;
      transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .step-icon {
      width: 48px;
      height: 48px;
      background: var(--clr-primary);
      color: white;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform 0.3s ease, background 0.3s ease;
    }

    .step-icon svg {
      width: 24px;
      height: 24px;
    }

    .step h3 {
      font-size: 1.15rem;
      font-weight: 700;
      color: var(--clr-text-dark);
      letter-spacing: -0.01em;
    }

    .step p {
      font-size: 0.9rem;
      color: var(--clr-text-medium);
      line-height: 1.6;
      max-width: 260px;
    }

    @media (min-width: 768px) {
      .steps-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
      }

      .how-it-works {
        padding: 6rem 1.5rem;
      }
    }

    .footer-cta {
      margin-top: 1.5rem;
      display: block;
      font-size: 0.9rem;
      color: var(--clr-text-medium);
      transition: all 0.3s ease;
    }

    .footer-cta:hover {
      box-shadow: 0 8px 20px -8px rgba(0, 68, 170, 0.1);
      border-color: rgba(0, 68, 170, 0.15);
      transform: translateY(-4px);

      span {
        text-decoration: underline;
      }
    }

    .footer-cta span {
      color: var(--clr-primary);
      font-weight: 700;
    }
  </style>
@endpush