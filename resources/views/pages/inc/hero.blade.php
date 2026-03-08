<section id="hero">
  <h1 id="hero-title">
    Locations & réservations pour <span class="highlight">tous</span>
  </h1>
  <x-searchbar />
</section>

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const title = document.getElementById('hero-title');
      const highlight = title.querySelector('.highlight');

      // Split all text nodes into individual word spans, preserve highlight span
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

      // Reveal words one by one
      const words = title.querySelectorAll('.word');
      words.forEach((word, i) => {
        setTimeout(() => {
          word.classList.add('visible');

          // After last word, trigger underline
          if (i === words.length - 1) {
            setTimeout(() => {
              title.querySelector('.highlight')?.classList.add('underlined');
            }, 300);
          }
        }, i * 120);
      });
    });
  </script>
@endpush

@push('styles')
<style>
  #hero {
    margin: auto;
    padding: 2rem 0;
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
    position: relative;
    display: inline-block;
  }

  .highlight::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -3px;
    height: 2px;
    width: 0%;
    background: linear-gradient(90deg, var(--clr-primary), var(--clr-secondary));
    transition: width 0.5s ease;
  }

  .highlight.underlined::after {
    width: 100%;
  }
</style>
@endpush