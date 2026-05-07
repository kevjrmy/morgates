@props(['listing'])

@php
  $photos = collect($listing->photos ?? [])->filter()->values();
@endphp

<section class="listing-gallery" data-listing-gallery>
  @if($photos->isEmpty())
    <div class="listing-gallery-empty" aria-label="Aucune photo disponible">
      @svg('tabler-photo-off', ['class' => 'listing-gallery-empty-icon'])
    </div>
  @elseif($photos->count() === 1)
    <div class="listing-gallery-single">
      <img
        src="{{ Str::startsWith($photos[0], 'http') ? $photos[0] : asset('storage/' . $photos[0]) }}"
        alt="{{ $listing->title }}"
      >
    </div>
  @else
    <div class="listing-gallery-carousel">
      <div class="listing-gallery-track" data-listing-gallery-track>
        @foreach($photos as $index => $photo)
          <div class="listing-gallery-slide">
            <img
              src="{{ Str::startsWith($photo, 'http') ? $photo : asset('storage/' . $photo) }}"
              alt="{{ $listing->title }} {{ $index + 1 }}"
            >
          </div>
        @endforeach
      </div>

      <div class="listing-gallery-dots" aria-label="Photos de l'annonce">
        @foreach($photos as $index => $photo)
          <button
            type="button"
            class="listing-gallery-dot {{ $index === 0 ? 'active' : '' }}"
            data-listing-gallery-dot="{{ $index }}"
            aria-label="Afficher la photo {{ $index + 1 }}"
            aria-current="{{ $index === 0 ? 'true' : 'false' }}"
          ></button>
        @endforeach
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

      .listing-gallery-single,
      .listing-gallery-carousel,
      .listing-gallery-empty {
        width: 100%;
        height: 320px;
      }

      .listing-gallery-single img,
      .listing-gallery-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
      }

      .listing-gallery-empty {
        display: grid;
        place-items: center;
        color: var(--clr-text-light);
      }

      .listing-gallery-empty-icon {
        width: 2.25rem;
        height: 2.25rem;
        stroke-width: 1.5;
      }

      .listing-gallery-carousel {
        position: relative;
        overflow: hidden;
      }

      .listing-gallery-track {
        height: 100%;
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
      }

      .listing-gallery-track::-webkit-scrollbar {
        display: none;
      }

      .listing-gallery-slide {
        flex: 0 0 100%;
        min-width: 100%;
        height: 100%;
        scroll-snap-align: start;
      }

      .listing-gallery-dots {
        position: absolute;
        left: 50%;
        bottom: 0.875rem;
        translate: -50% 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        padding: 0.35rem 0.5rem;
        border-radius: 999px;
        background-color: rgba(17, 24, 39, 0.32);
        backdrop-filter: blur(8px);
      }

      .listing-gallery-dot {
        width: 0.45rem;
        height: 0.45rem;
        padding: 0;
        border: 0;
        border-radius: 999px;
        background-color: rgba(255, 255, 255, 0.62);
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.2s ease;
      }

      .listing-gallery-dot.active {
        background-color: #fff;
        transform: scale(1.35);
      }

      @media (min-width: 720px) {
        .listing-gallery-single,
        .listing-gallery-carousel,
        .listing-gallery-empty {
          height: 420px;
        }
      }
    </style>
  @endpush

  @push('scripts')
    <script>
      document.querySelectorAll('[data-listing-gallery]').forEach(gallery => {
        const track = gallery.querySelector('[data-listing-gallery-track]')
        const dots = [...gallery.querySelectorAll('[data-listing-gallery-dot]')]

        if (!track || dots.length === 0) return

        const setActiveDot = index => {
          dots.forEach((dot, dotIndex) => {
            const isActive = dotIndex === index
            dot.classList.toggle('active', isActive)
            dot.setAttribute('aria-current', isActive ? 'true' : 'false')
          })
        }

        dots.forEach(dot => {
          dot.addEventListener('click', () => {
            const index = Number(dot.dataset.listingGalleryDot)
            track.scrollTo({ left: index * track.clientWidth, behavior: 'smooth' })
            setActiveDot(index)
          })
        })

        track.addEventListener('scroll', () => {
          const index = Math.round(track.scrollLeft / track.clientWidth)
          setActiveDot(index)
        }, { passive: true })
      })
    </script>
  @endpush
@endonce
