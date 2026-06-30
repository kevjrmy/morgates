<footer id="footer">
  <div class="footer-body">
    <div class="footer-col">
      <h3>Explorer</h3>
      <ul role="list">
        <li><a href="{{ route('listings') }}">Toutes les annonces</a></li>
        <li><a href="{{ route('listings', ['type' => 'boats']) }}">Bateaux</a></li>
        <li><a href="{{ route('listings', ['type' => 'stays']) }}">Hébergements</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h3>Propriétaires</h3>
      <ul role="list">
        <li><a href="{{ route('listings.create.index') }}">Publier une annonce</a></li>
        <li><a href="{{ route('account') }}">Mon espace</a></li>
        <li><a href="{{ route('about') }}">À propos de Morgates</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h3>Assistance</h3>
      <ul role="list">
        <li><a href="{{ route('contact') }}">Nous contacter</a></li>
        <li><a href="{{ route('privacy') }}">Confidentialité</a></li>
        <li><a href="{{ route('terms') }}">Conditions d'utilisation</a></li>
      </ul>
    </div>
  </div>

  <div class="footer-bar">
    <a href="{{ route('home') }}" class="footer-brand" aria-label="Accueil Morgates">
      <img src="{{ asset('images/logo.svg') }}" alt="" width="20" height="20">
      <span>MORGATES</span>
    </a>
    <span class="footer-bar-sep" aria-hidden="true">·</span>
    <span>© {{ date('Y') }}</span>
  </div>
</footer>