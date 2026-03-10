<section id="hero">
  <h1 id="hero-title">
    Locations <span class="highlight">&amp;</span> réservations pour tous
  </h1>
  <x-searchbar />
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
        }, i * 160); // slightly slower than 120
      });
    });
  </script>
@endpush

@push('styles')
  <style>
    #hero {
      margin: auto;
      padding: 2rem 1.5rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      row-gap: 2rem;
      max-width: var(--mobile-L);
    }

    #hero h1 {
      color: var(--clr-text-medium);
      font-size: clamp(2.5rem, 6vw, 4rem);
      font-weight: 700;
      line-height: 1.2;
    }

    #hero h1 .word {
      display: inline-block;
      opacity: 0;
      transform: translateY(12px);
      transition: opacity 0.3s ease, transform 0.3s ease;
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
  </style>
@endpush