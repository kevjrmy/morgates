<footer id="footer">
  <div class="footer-body">
    <div class="footer-col">
      <h3>Assistance</h3>
      <ul role="list">
        <li><a href="{{ route('about') }}">À propos</a></li>
        <li><a href="#">Centre d'aide</a></li>
        <li><a href="#">Annulation</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h3>Louer avec nous</h3>
      <ul role="list">
        <li><a href="#">Proposer un bien</a></li>
        <li><a href="#">Comment ça marche</a></li>
        <li><a href="#">Devenir hôte</a></li>
      </ul>
    </div>
  </div>

  <div class="footer-bar">
    <span>© {{ date('Y') }} Morgates</span>
    <span aria-hidden="true">·</span>
    <a href="{{ route('privacy') }}">Confidentialité</a>
    <span aria-hidden="true">·</span>
    <a href="{{ route('terms') }}">Conditions générales</a>
  </div>
</footer>