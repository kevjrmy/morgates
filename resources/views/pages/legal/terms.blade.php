@extends('layouts.app')

@section('title', "Conditions d'utilisation - Morgates")
@section('robots', 'noindex, follow')

@section('content')
  <main class="legal-page">

    <section class="legal-hero">
      <h1>Conditions d'utilisation</h1>
      <p class="legal-meta">Dernière mise à jour : juin 2025</p>
    </section>

    <section class="legal-section">
      <h2>1. Objet</h2>
      <p>Les présentes conditions d'utilisation régissent l'accès et l'usage de la plateforme Morgates, accessible à l'adresse <strong>morgates.com</strong>. En accédant au site, vous acceptez ces conditions sans réserve.</p>
    </section>

    <section class="legal-section">
      <h2>2. Description du service</h2>
      <p>Morgates est une place de marché de mise en relation directe entre propriétaires et visiteurs pour la location de bateaux et d'hébergements. Morgates n'est pas une agence de location, un intermédiaire de réservation ou une plateforme de paiement.</p>
      <p>Le rôle de Morgates se limite à permettre aux propriétaires de publier des annonces visibles du public, et aux visiteurs de les consulter et de contacter les propriétaires directement via les coordonnées affichées. Morgates ne prend aucune commission sur les transactions et ne s'interpose pas dans les échanges entre les parties.</p>
    </section>

    <section class="legal-section">
      <h2>3. Création de compte</h2>
      <p>La publication d'une annonce nécessite la création d'un compte propriétaire. Vous vous engagez à fournir des informations exactes lors de l'inscription et à les maintenir à jour. Un compte est personnel et ne peut pas être cédé à un tiers.</p>
      <p>Morgates se réserve le droit de suspendre ou supprimer tout compte dont les informations seraient inexactes, frauduleuses ou contraires aux présentes conditions.</p>
    </section>

    <section class="legal-section">
      <h2>4. Publication d'annonces</h2>
      <p>En publiant une annonce, le propriétaire s'engage à :</p>
      <ul class="legal-list">
        <li>Décrire le bien de manière honnête et exacte (titre, description, localisation, tarifs, photos).</li>
        <li>Fournir des coordonnées de contact réelles et fonctionnelles.</li>
        <li>S'assurer que la location proposée est légalement autorisée (réglementation locale, assurances, permis de navigation le cas échéant).</li>
        <li>Mettre à jour ou retirer son annonce si le bien n'est plus disponible.</li>
      </ul>
      <p>Le nombre d'annonces simultanément publiables est limité selon la formule d'abonnement souscrite.</p>
    </section>

    <section class="legal-section">
      <h2>5. Ce que Morgates ne fait pas</h2>
      <ul class="legal-list">
        <li>Morgates ne vérifie pas l'état des biens, leur conformité réglementaire, ni les identités des propriétaires.</li>
        <li>Morgates ne garantit pas la disponibilité d'un bien, ni la conclusion d'une location.</li>
        <li>Morgates ne traite aucun paiement entre les parties.</li>
        <li>Morgates n'assure pas de service de médiation ou de résolution de litiges entre propriétaires et visiteurs.</li>
      </ul>
      <p>Tout accord conclu entre un propriétaire et un visiteur est de leur seule responsabilité.</p>
    </section>

    <section class="legal-section">
      <h2>6. Contenus interdits</h2>
      <p>Il est interdit de publier sur Morgates :</p>
      <ul class="legal-list">
        <li>Des annonces frauduleuses, trompeuses ou portant sur des biens inexistants.</li>
        <li>Du contenu illicite, diffamatoire, discriminatoire ou portant atteinte aux droits de tiers.</li>
        <li>Des offres de location contraires à la législation en vigueur (absence d'autorisation requise, location illégale, etc.).</li>
        <li>Des coordonnées de contact appartenant à un tiers sans son consentement.</li>
      </ul>
      <p>Tout contenu signalé comme non-conforme pourra être retiré sans préavis.</p>
    </section>

    <section class="legal-section">
      <h2>7. Abonnement</h2>
      <p>La publication d'annonces est actuellement gratuite pendant la phase de lancement. Un abonnement payant sera introduit ultérieurement. Les modalités tarifaires seront communiquées avant toute mise en place, et les utilisateurs existants seront informés dans un délai raisonnable.</p>
    </section>

    <section class="legal-section">
      <h2>8. Limitation de responsabilité</h2>
      <p>Morgates met à disposition la plateforme en l'état et ne peut être tenu responsable :</p>
      <ul class="legal-list">
        <li>Des dommages résultant d'une relation contractuelle entre un propriétaire et un visiteur.</li>
        <li>De l'inexactitude des informations publiées dans les annonces.</li>
        <li>D'une interruption temporaire du service pour maintenance ou incident technique.</li>
        <li>Des actes frauduleux commis par des tiers utilisant la plateforme.</li>
      </ul>
    </section>

    <section class="legal-section">
      <h2>9. Modification des conditions</h2>
      <p>Morgates peut modifier les présentes conditions à tout moment. Les utilisateurs enregistrés seront informés par email de toute modification substantielle. La poursuite de l'utilisation du service après notification vaut acceptation des nouvelles conditions.</p>
    </section>

    <section class="legal-section">
      <h2>10. Droit applicable</h2>
      <p>Les présentes conditions sont soumises au droit français. En cas de litige, les parties s'engagent à rechercher une solution amiable avant tout recours judiciaire. À défaut, les tribunaux compétents sont ceux du ressort du siège de Morgates.</p>
    </section>

    <section class="legal-section">
      <h2>Contact</h2>
      <p>Pour toute question relative aux présentes conditions : <a href="mailto:contact@morgates.com">contact@morgates.com</a></p>
    </section>

  </main>
@endsection

@push('styles')
  <style>
    .legal-page {
      padding: 2rem 1.25rem 4rem;
      display: flex;
      flex-direction: column;
      gap: 2rem;
      max-width: 680px;
    }

    .legal-hero {
      padding-top: 1.5rem;
      border-bottom: var(--border);
      padding-bottom: 1.5rem;
    }

    .legal-hero h1 {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--clr-text-dark);
      margin-bottom: 0.375rem;
    }

    .legal-meta {
      font-size: 0.78rem;
      color: var(--clr-text-light);
    }

    .legal-section {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }

    .legal-section h2 {
      font-size: 0.875rem;
      font-weight: 700;
      color: var(--clr-text-dark);
    }

    .legal-section p {
      font-size: 0.875rem;
      color: var(--clr-text-medium);
      line-height: 1.75;
    }

    .legal-section a {
      color: var(--clr-primary);
      text-decoration: underline;
      text-underline-offset: 2px;
    }

    .legal-list {
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      padding-left: 1.125rem;
    }

    .legal-list li {
      font-size: 0.875rem;
      color: var(--clr-text-medium);
      line-height: 1.65;
    }
  </style>
@endpush
