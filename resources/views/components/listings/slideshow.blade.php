@props([
  'listing',
  'photos' => null,
  'showPreview' => true,
])

@php
  $photos = collect($photos ?? $listing->photos ?? [])->filter()->values();
@endphp

<section class="listing-gallery">
  @if($showPreview)
    @if($photos->isEmpty())
      <div class="listing-gallery-hero" aria-label="Aucune photo disponible">
        @svg('tabler-photo-off', ['class' => 'listing-gallery-empty-icon'])
      </div>
    @else
      <div class="listing-gallery-hero">
        <img
          src="{{ Str::startsWith($photos[0], 'http') ? $photos[0] : asset('storage/' . $photos[0]) }}"
          alt="{{ $listing->title }}"
        >
        <button type="button" class="gallery-hero-btn" id="btn-open-gallery">
          @svg('tabler-photo', ['class' => 'gallery-hero-btn-icon'])
          <span>Voir les photos</span>
        </button>
      </div>
    @endif
  @endif

  @if($photos->isNotEmpty())
    <div id="gallery-modal" class="gallery-modal" hidden aria-hidden="true">
      <div class="gallery-modal-backdrop"></div>
      <div class="gallery-modal-content">
        <button type="button" class="gallery-modal-close" id="gallery-modal-close" aria-label="Fermer">
          @svg('tabler-x')
        </button>

        <div class="gallery-modal-carousel">
          <button type="button" class="gallery-arrow gallery-arrow-prev" id="gallery-prev" aria-label="Photo précédente">
            @svg('tabler-chevron-left')
          </button>

          <div class="gallery-modal-track" id="gallery-track">
            @foreach($photos as $index => $photo)
              <div class="gallery-modal-slide">
                <img
                  src="{{ Str::startsWith($photo, 'http') ? $photo : asset('storage/' . $photo) }}"
                  alt="{{ $listing->title }} {{ $index + 1 }}"
                >
              </div>
            @endforeach
          </div>

          <button type="button" class="gallery-arrow gallery-arrow-next" id="gallery-next" aria-label="Photo suivante">
            @svg('tabler-chevron-right')
          </button>
        </div>

        <div class="gallery-modal-counter">
          <span id="gallery-current">1</span> / {{ $photos->count() }}
        </div>
      </div>
    </div>
  @endif
</section>

@once
  @push('styles')
    <style>
      .listing-gallery {
        width: 100%;
        background-color: var(--clr-tertiary);
      }

      .listing-gallery-hero {
        width: 100%;
        height: 320px;
        position: relative;
      }

      .listing-gallery-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
      }

      .listing-gallery-empty-icon {
        width: 3rem;
        height: 3rem;
        stroke-width: 1.5;
        color: var(--clr-text-light);
      }

      .listing-gallery-hero:has(.listing-gallery-empty-icon) {
        display: grid;
        place-items: center;
      }

      .gallery-hero-btn {
        position: absolute;
        bottom: 0.75rem;
        right: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 0.85rem;
        border-radius: 0.5rem;
        background-color: #fff;
        border: none;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--clr-text-dark);
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
        transition: background-color 0.2s ease;
      }

      .gallery-hero-btn:hover {
        background-color: var(--clr-tertiary);
      }

      .gallery-hero-btn-icon {
        width: 1.1rem;
        height: 1.1rem;
      }

      .gallery-modal {
        position: fixed;
        inset: 0;
        z-index: 300;
      }

      .gallery-modal:not([hidden]) {
        display: block;
      }

      .gallery-modal-backdrop {
        position: absolute;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.92);
      }

      .gallery-modal-content {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
      }

      .gallery-modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        z-index: 10;
        transition: background-color 0.2s ease;
      }

      .gallery-modal-close:hover {
        background: rgba(255, 255, 255, 0.2);
      }

      .gallery-modal-close svg {
        width: 1.5rem;
        height: 1.5rem;
      }

      .gallery-modal-carousel {
        flex: 1;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
      }

      .gallery-modal-track {
        display: flex;
        width: 100%;
        height: 100%;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        scrollbar-width: none;
      }

      .gallery-modal-track::-webkit-scrollbar {
        display: none;
      }

      .gallery-modal-slide {
        flex: 0 0 100%;
        min-width: 100%;
        height: 100%;
        scroll-snap-align: start;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
      }

      .gallery-modal-slide img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
      }

      .gallery-arrow {
        position: absolute;
        top: 50%;
        translate: 0 -50%;
        width: 2.75rem;
        height: 2.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.2s ease;
        z-index: 5;
      }

      .gallery-arrow:hover {
        background: rgba(255, 255, 255, 0.25);
      }

      .gallery-arrow svg {
        width: 1.75rem;
        height: 1.75rem;
      }

      .gallery-arrow-prev {
        left: 1rem;
      }

      .gallery-arrow-next {
        right: 1rem;
      }

      .gallery-modal-counter {
        position: absolute;
        bottom: 1rem;
        left: 50%;
        translate: -50% 0;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
        font-weight: 500;
      }

      @media (min-width: 720px) {
        .listing-gallery-hero {
          height: 420px;
        }

        .gallery-modal-slide {
          padding: 2rem;
        }
      }
    </style>
  @endpush

  @push('scripts')
    <script>
      (function() {
        const modal = document.getElementById('gallery-modal')
        if (!modal) return

        const openBtn = document.getElementById('btn-open-gallery')
        const closeBtn = document.getElementById('gallery-modal-close')
        const backdrop = modal.querySelector('.gallery-modal-backdrop')
        const track = document.getElementById('gallery-track')
        const prevBtn = document.getElementById('gallery-prev')
        const nextBtn = document.getElementById('gallery-next')
        const counter = document.getElementById('gallery-current')
        const slideCount = track?.children.length ?? 0

        if (!track || slideCount === 0) return

        let currentIndex = 0

        function updateGallery(index) {
          currentIndex = Math.max(0, Math.min(index, slideCount - 1))
          track.scrollTo({ left: currentIndex * track.clientWidth, behavior: 'smooth' })

          counter.textContent = currentIndex + 1
        }

        function openModal(initialIndex = 0) {
          modal.hidden = false
          modal.setAttribute('aria-hidden', 'false')
          document.body.style.overflow = 'hidden'
          updateGallery(initialIndex)
        }

        window.openGalleryModal = openModal

        function closeModal() {
          modal.hidden = true
          modal.setAttribute('aria-hidden', 'true')
          document.body.style.overflow = ''
        }

        openBtn?.addEventListener('click', () => openModal())
        closeBtn.addEventListener('click', closeModal)
        backdrop.addEventListener('click', closeModal)

        prevBtn.addEventListener('click', () => updateGallery(currentIndex - 1))
        nextBtn.addEventListener('click', () => updateGallery(currentIndex + 1))

        track.addEventListener('scroll', () => {
          const index = Math.round(track.scrollLeft / track.clientWidth)
          if (index !== currentIndex) {
            currentIndex = index
            counter.textContent = currentIndex + 1
          }
        }, { passive: true })

        document.addEventListener('keydown', e => {
          if (modal.hidden) return

          if (e.key === 'Escape') {
            closeModal()
          } else if (e.key === 'ArrowLeft') {
            updateGallery(currentIndex - 1)
          } else if (e.key === 'ArrowRight') {
            updateGallery(currentIndex + 1)
          }
        })
      })()
    </script>
  @endpush
@endonce
