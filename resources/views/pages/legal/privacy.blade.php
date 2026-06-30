@extends('layouts.app')

@section('title', 'Politique de confidentialité - Morgates')
@section('robots', 'noindex, follow')

@section('content')
  <main class="legal-page">

    <section class="legal-hero">
      <h1>Politique de confidentialité</h1>
      <p class="legal-meta">Dernière mise à jour : juin 2025</p>
    </section>

    <section class="legal-section">
      <h2>1. Responsable du traitement</h2>
      <p>Le responsable du traitement des données personnelles collectées sur Morgates est :</p>
      <p><strong>Morgates</strong><br>
        Contact : <a href="mailto:contact@morgates.com">contact@morgates.com</a>
      </p>
    </section>

    <section class="legal-section">
      <h2>2. Données collectées</h2>
      <p>Morgates collecte uniquement les données nécessaires au fonctionnement du service :</p>
      <ul class="legal-list">
        <li><strong>Lors de l'inscription :</strong> adresse email, mot de passe (chiffré).</li>
        <li><strong>Lors de la complétion du profil :</strong> prénom, nom, numéro de téléphone, pays, biographie, photo de profil, langues parlées.</li>
        <li><strong>Lors de la publication d'une annonce :</strong> informations sur le bien loué (titre, description, localisation, prix, photos), coordonnées de contact choisies par le propriétaire (email, téléphone, WhatsApp, site web, Instagram, Messenger).</li>
        <li><strong>Lors de la navigation :</strong> données techniques standard (adresse IP, type de navigateur, pages visitées) à des fins de sécurité et de statistiques.</li>
      </ul>
      <p>Morgates ne collecte pas de données bancaires. Aucun paiement n'est traité directement sur la plateforme.</p>
    </section>

    <section class="legal-section">
      <h2>3. Finalités du traitement</h2>
      <ul class="legal-list">
        <li>Création et gestion des comptes propriétaires.</li>
        <li>Publication et affichage des annonces de location.</li>
        <li>Mise en relation directe entre visiteurs et propriétaires via les coordonnées fournies.</li>
        <li>Sécurité et prévention des abus sur la plateforme.</li>
        <li>Amélioration du service (statistiques anonymisées).</li>
      </ul>
    </section>

    <section class="legal-section">
      <h2>4. Base légale</h2>
      <ul class="legal-list">
        <li><strong>Exécution du contrat</strong> : traitement nécessaire à la fourniture du service (compte, annonces).</li>
        <li><strong>Intérêt légitime</strong> : sécurité de la plateforme, prévention des fraudes.</li>
        <li><strong>Consentement</strong> : pour toute donnée optionnelle (photo de profil, bio, langues).</li>
      </ul>
    </section>

    <section class="legal-section">
      <h2>5. Sous-traitants et hébergement</h2>
      <p>Morgates fait appel aux prestataires suivants :</p>
      <ul class="legal-list">
        <li><strong>Hostinger</strong> (hébergement) : les données sont stockées sur des serveurs situés dans l'Union européenne.</li>
        <li><strong>Bunny Fonts</strong> (polices de caractères) : chargement de polices via un CDN, sans collecte de données personnelles.</li>
      </ul>
      <p>Aucune donnée personnelle n'est vendue ni partagée avec des tiers à des fins commerciales.</p>
    </section>

    <section class="legal-section">
      <h2>6. Cookies</h2>
      <p>Morgates utilise uniquement des cookies techniques essentiels au fonctionnement du site : cookies de session et protection CSRF. Aucun cookie publicitaire ou de traçage tiers n'est déposé.</p>
    </section>

    <section class="legal-section">
      <h2>7. Durée de conservation</h2>
      <ul class="legal-list">
        <li><strong>Données de compte :</strong> conservées pendant toute la durée d'activité du compte, puis supprimées dans un délai de 30 jours suivant la clôture.</li>
        <li><strong>Données de navigation :</strong> conservées 12 mois maximum.</li>
        <li><strong>Obligations légales :</strong> certaines données peuvent être conservées plus longtemps pour répondre aux obligations légales en vigueur.</li>
      </ul>
    </section>

    <section class="legal-section">
      <h2>8. Vos droits</h2>
      <p>Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez des droits suivants :</p>
      <ul class="legal-list">
        <li><strong>Droit d'accès :</strong> obtenir une copie de vos données personnelles.</li>
        <li><strong>Droit de rectification :</strong> corriger des données inexactes ou incomplètes.</li>
        <li><strong>Droit à l'effacement :</strong> demander la suppression de vos données.</li>
        <li><strong>Droit à la portabilité :</strong> recevoir vos données dans un format structuré.</li>
        <li><strong>Droit d'opposition :</strong> vous opposer à certains traitements basés sur l'intérêt légitime.</li>
      </ul>
      <p>Pour exercer ces droits, contactez-nous à : <a href="mailto:contact@morgates.com">contact@morgates.com</a>.</p>
      <p>En cas de désaccord, vous pouvez introduire une réclamation auprès de la <strong>CNIL</strong> (<a href="https://www.cnil.fr" target="_blank" rel="noopener noreferrer">www.cnil.fr</a>).</p>
    </section>

    <section class="legal-section">
      <h2>9. Contact</h2>
      <p>Pour toute question relative à cette politique : <a href="mailto:contact@morgates.com">contact@morgates.com</a></p>
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
