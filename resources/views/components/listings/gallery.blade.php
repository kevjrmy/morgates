@props(['listing'])

@php
  $photos = collect($listing->photos ?? [])->filter()->values();
  $visiblePhotos = $photos->take(3);
@endphp

@if($photos->isNotEmpty())
  <section class="listing-gallery-grid" aria-label="Galerie photos">
    <h2>Galerie</h2>

    <div class="gallery-grid gallery-grid--{{ $visiblePhotos->count() }}" role="list">
      @foreach($visiblePhotos as $index => $photo)
        <button type="button" class="gallery-grid-item" data-gallery-index="{{ $index }}" role="listitem">
          <img
            src="{{ Str::startsWith($photo, 'http') ? $photo : asset('storage/' . $photo) }}"
            alt="{{ $listing->title }} {{ $index + 1 }}"
          >
        </button>
      @endforeach
    </div>

    @if($photos->count() > 3)
      <button type="button" class="gallery-grid-open" data-gallery-index="0">
        @svg('tabler-photo-library', ['class' => 'gallery-grid-open-icon'])
        <span>Voir la galerie</span>
      </button>
    @endif
  </section>
@endif

@once
  @push('styles')
    <style>
      .listing-gallery-grid h2 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
      }

      .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.5rem;
      }

      .gallery-grid--1 {
        grid-template-columns: 1fr;
      }

      .gallery-grid--2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }

      .gallery-grid-item {
        position: relative;
        aspect-ratio: 1;
        padding: 0;
        border: none;
        border-radius: 0.5rem;
        overflow: hidden;
        cursor: pointer;
        background-color: var(--clr-tertiary);
      }

      .gallery-grid-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.2s ease;
      }

      .gallery-grid-item:hover img {
        transform: scale(1.05);
      }

      .gallery-grid-open {
        width: 100%;
        min-height: 2.75rem;
        margin-top: 0.75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        padding: 0.65rem 1rem;
        border: var(--border);
        border-radius: 0.5rem;
        background-color: #fff;
        color: var(--clr-text-dark);
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
      }

      .gallery-grid-open-icon {
        width: 1.1rem;
        height: 1.1rem;
      }
    </style>
  @endpush

  @push('scripts')
    <script>
      document.querySelectorAll('[data-gallery-index]').forEach(item => {
        item.addEventListener('click', () => {
          if (typeof window.openGalleryModal !== 'function') return

          window.openGalleryModal(Number(item.dataset.galleryIndex))
        })
      })
    </script>
  @endpush
@endonce
