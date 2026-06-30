@extends('layouts.app')

@section('title', 'À propos - Morgates')

@section('content')
  <main class="about-page">

    <section class="about-hero">
      <h1>Morgates</h1>
      <p class="about-tagline">La location directe entre particuliers, sans intermédiaire.</p>
    </section>

    <section class="about-section">
      <h2>Ce qu'on fait</h2>
      <p>Morgates est une place de marché simple et locale pour la location de bateaux et d'hébergements. Chaque annonce affiche directement les coordonnées du propriétaire : pas de système de réservation, pas de frais de service, pas de messagerie intégrée.</p>
      <p>Le visiteur contacte l'hôte par le canal qu'il préfère : email, téléphone, WhatsApp, Instagram. La suite se passe entre eux.</p>
    </section>

    <section class="about-section">
      <h2>Pourquoi ce choix</h2>
      <p>Les grandes plateformes centralisent les échanges, prélèvent des commissions et s'interposent dans une relation qui pourrait être directe. Morgates part du principe que propriétaires et locataires n'ont pas besoin d'un tiers pour s'entendre.</p>
      <p>On publie, on trouve, on contacte. Simple.</p>
    </section>

    <section class="about-section">
      <h2>Ce qu'on propose</h2>
      <ul class="about-list">
        <li>@svg('tabler-sailboat') <span>Sorties en mer et locations de bateaux</span></li>
        <li>@svg('tabler-home-star') <span>Hébergements chez des particuliers</span></li>
        <li>@svg('tabler-map-pin') <span>Annonces locales, partout en France</span></li>
        <li>@svg('tabler-phone') <span>Contact direct avec le propriétaire</span></li>
      </ul>
    </section>

    <section class="about-section">
      <h2>Publier une annonce</h2>
      <p>Vous proposez un bateau à louer ou un logement ? La publication est gratuite et prend moins de dix minutes.</p>
      <a href="{{ route('listings.create.index') }}" class="about-cta">Publier une annonce</a>
    </section>

  </main>
@endsection

@push('styles')
  <style>
    .about-page {
      padding: 2rem 1.25rem 4rem;
      display: flex;
      flex-direction: column;
      gap: 2.5rem;
    }

    .about-hero {
      padding: 1.5rem 0 0.5rem;
      border-bottom: var(--border);
      padding-bottom: 2rem;
    }

    .about-hero h1 {
      font-size: 2rem;
      font-weight: 700;
      color: var(--clr-text-dark);
      margin-bottom: 0.5rem;
    }

    .about-tagline {
      font-size: 1.05rem;
      color: var(--clr-text-medium);
      line-height: 1.5;
    }

    .about-section {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }

    .about-section h2 {
      font-size: 1rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--clr-primary);
    }

    .about-section p {
      font-size: 0.95rem;
      color: var(--clr-text-medium);
      line-height: 1.7;
    }

    .about-list {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }

    .about-list li {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-size: 0.95rem;
      color: var(--clr-text-medium);
    }

    .about-list svg {
      width: 1.25rem;
      height: 1.25rem;
      color: var(--clr-primary);
      flex-shrink: 0;
    }

    .about-cta {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.75rem 1.5rem;
      border-radius: 0.75rem;
      background-color: var(--clr-primary);
      color: #fff;
      font-size: 0.9rem;
      font-weight: 700;
      align-self: flex-start;
      transition: opacity 0.2s ease;
    }

    .about-cta:hover {
      opacity: 0.88;
    }
  </style>
@endpush
