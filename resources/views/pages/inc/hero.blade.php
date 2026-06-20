<section id="hero">
  <div class="hero-inner">

    <h1 id="hero-title">
      Louez <span class="highlight">sans frais</span> intermédiaires
    </h1>

    <p class="hero-tagline">
      Réservez directement avec l'hôte.
    </p>

    <x-ui.searchbar />

    <ul class="hero-trust" role="list">
      <li>
        @svg('mdi-shield-check-outline', ['class' => 'hero-trust-icon'])
        <span>Contact direct</span>
      </li>
      <li>
        @svg('tabler-currency-euro-off', ['class' => 'hero-trust-icon'])
        <span>Sans surcoût</span>
      </li>
      <li>
        @svg('mdi-map-marker-outline', ['class' => 'hero-trust-icon'])
        <span>Toute l'Europe</span>
      </li>
    </ul>
  </div>

  <div class="hero-wave" aria-hidden="true">
    <svg viewBox="0 0 768 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M0,30 C180,60 588,0 768,30 L768,60 L0,60 Z" fill="var(--clr-background)" />
    </svg>
  </div>
</section>

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const title = document.getElementById('hero-title');
      const highlight = title.querySelector('.highlight');

      const wrapWords = (node) => {
        if (node.nodeType === Node.TEXT_NODE) {
          const words = node.textContent.split(/(\s+)/);
          const fragment = document.createDocumentFragment();
          words.forEach(word => {
            if (word.trim()) {
              const span = document.createElement('span');
              span.classList.add('word');
              span.textContent = word;
              fragment.appendChild(span);
              fragment.appendChild(document.createTextNode(' '));
            }
          });
          node.replaceWith(fragment);
        } else if (node.nodeType === Node.ELEMENT_NODE && node !== highlight) {
          [...node.childNodes].forEach(wrapWords);
        } else if (node === highlight) {
          const span = document.createElement('span');
          span.classList.add('word');
          span.appendChild(highlight.cloneNode(true));
          highlight.replaceWith(span);
        }
      };

      [...title.childNodes].forEach(wrapWords);

      const words = title.querySelectorAll('.word');
      words.forEach((word, i) => {
        setTimeout(() => {
          word.classList.add('visible');
          if (i === words.length - 1) {
            setTimeout(() => {
              title.querySelector('.highlight')?.classList.add('colorized');
            }, 300);
          }
        }, i * 150);
      });

      // Stagger-in tagline and trust items
      const staggerEls = document.querySelectorAll('.hero-tagline, .hero-badge, .hero-trust li');
      staggerEls.forEach((el, i) => {
        el.style.animationDelay = `${0.6 + i * 0.1}s`;
        el.classList.add('hero-fade-in');
      });
    });
  </script>
@endpush

@push('styles')
  <style>
    #hero {
      position: relative;
      background: linear-gradient(160deg, #e8f0ff 0%, #f0f5ff 45%, var(--clr-background) 100%);
      padding: 2.5rem 1.5rem 0;
      overflow: hidden;
    }

    .hero-inner {
      max-width: var(--mobile-L);
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      gap: 1.5rem;
      padding-bottom: 2.5rem;
    }

    /* Title */
    #hero h1 {
      color: var(--clr-text-dark);
      font-size: clamp(2.2rem, 8vw, 3.5rem);
      font-weight: 800;
      line-height: 1.15;
      letter-spacing: -0.02em;
    }

    #hero h1 .word {
      display: inline-block;
      opacity: 0;
      transform: translateY(14px);
      transition: opacity 0.35s ease, transform 0.35s ease;
    }

    #hero h1 .word.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .highlight {
      background: linear-gradient(90deg, var(--clr-primary), var(--clr-secondary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Tagline */
    .hero-tagline {
      font-size: 1rem;
      color: var(--clr-text-medium);
      line-height: 1.55;
      max-width: 340px;
    }

    /* Trust strip */
    .hero-trust {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1.25rem;
      flex-wrap: wrap;
    }

    .hero-trust li {
      display: flex;
      align-items: center;
      gap: 0.35rem;
      font-size: 0.8rem;
      font-weight: 600;
      color: var(--clr-text-medium);
    }

    .hero-trust-icon {
      width: 1rem;
      height: 1rem;
      color: var(--clr-primary);
      flex-shrink: 0;
    }

    /* Wave divider */
    .hero-wave {
      width: 100%;
      line-height: 0;
      margin-top: -1px;
    }

    .hero-wave svg {
      display: block;
      width: 100%;
      height: 40px;
    }

    /* Fade-in animation for staggered elements */
    @keyframes heroFadeUp {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .hero-fade-in {
      opacity: 0;
      animation: heroFadeUp 0.5s ease forwards;
    }
  </style>
@endpush