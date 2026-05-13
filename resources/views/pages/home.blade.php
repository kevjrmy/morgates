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
      <div class="how-it-works-header">
        <h2>Comment ça marche ?</h2>
        <p>Morgates simplifie la mise en relation directe entre voyageurs et hôtes.</p>
      </div>

      <div class="steps-grid">
        <div class="step">
          <div class="step-icon">
            @svg('mdi-magnify')
          </div>
          <h3>Explorez</h3>
          <p>Parcourez une sélection d'annonces authentiques de bateaux et de séjours.</p>
        </div>

        <div class="step">
          <div class="step-icon">
            @svg('mdi-account-voice')
          </div>
          <h3>Contactez</h3>
          <p>Échangez directement avec les hôtes via leurs canaux de contact préférés.</p>
        </div>

        <div class="step">
          <div class="step-icon">
            @svg('mdi-check-decagram-outline')
          </div>
          <h3>Profitez</h3>
          <p>Réservez en direct, sans commission ni frais de service intermédiaires.</p>
        </div>
      <div class="how-it-works-footer">
        <p>Vous voulez en savoir plus ? <a href="{{ route('contact') }}">Contactez-nous</a></p>
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

    /* How it works section */
    .how-it-works {
      background: linear-gradient(180deg, transparent, var(--clr-softblue) 50%, transparent);
      padding: 4rem 1.5rem;
      margin: 1rem 0;
    }

    .how-it-works-header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .how-it-works-header h2 {
      font-size: 1.75rem;
      font-weight: 800;
      color: var(--clr-text-dark);
      margin-bottom: 0.75rem;
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
      gap: 2rem;
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
      padding: 2rem 1.5rem;
      background: white;
      border-radius: 28px;
      border: 1px solid rgba(0, 68, 170, 0.05);
      box-shadow: 0 10px 25px -5px rgba(0, 68, 170, 0.05);
      transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .step:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 40px -10px rgba(0, 68, 170, 0.12);
      border-color: rgba(0, 68, 170, 0.1);
    }

    .step-icon {
      width: 64px;
      height: 64px;
      background: var(--clr-softblue);
      color: var(--clr-primary);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 0.75rem;
      transition: transform 0.3s ease;
    }

    .step:hover .step-icon {
      transform: scale(1.05) rotate(5deg);
    }

    .step-icon svg {
      width: 32px;
      height: 32px;
    }

    .step h3 {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--clr-text-dark);
      letter-spacing: -0.01em;
    }

    .step p {
      font-size: 0.95rem;
      color: var(--clr-text-medium);
      line-height: 1.6;
    }

    @media (min-width: 768px) {
      .steps-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
      }

      .how-it-works {
        padding: 6rem 1.5rem;
      }
    }

    .how-it-works-footer {
      text-align: center;
      margin-top: 3.5rem;
      font-size: 1rem;
      color: var(--clr-text-medium);
    }

    .how-it-works-footer a {
      color: var(--clr-primary);
      font-weight: 700;
      text-decoration: underline;
      text-underline-offset: 4px;
      transition: color 0.3s ease;
    }

    .how-it-works-footer a:hover {
      color: var(--clr-marine);
    }
  </style>
@endpush
