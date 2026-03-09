@props(['listing'])

<article class="listing-card">
  <div class="listing-card-photo">
    <img src="{{ $listing->photos[0] }}" alt="{{ $listing->title }}">
  </div>
  <div class="listing-card-body">
    <span class="listing-card-city">{{ $listing->city }}</span>
    <h3 class="listing-card-title">{{ $listing->title }}</h3>
    <p class="listing-card-price">
      <strong>{{ number_format($listing->price_per_night, 0, ',', ' ') }} €</strong> / nuit
    </p>
  </div>
</article>

@once
  @push('styles')
    <style>
      .listings-section {
        padding: 1rem;
      }

      .listings-section h2 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--clr-text-primary);
      }

      .listings-scroll {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 1rem;
        padding-top: 0.5rem;
        padding-left: 1rem;
        padding-right: 1rem;
        margin: 0 -1rem;
        scrollbar-width: none;
      }

      .listings-scroll::-webkit-scrollbar {
        display: none;
      }

      .listing-card {
        flex: 0 0 75vw;
        max-width: 320px;
        scroll-snap-align: start;
        border-radius: 1rem;
        background: var(--clr-background);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
      }

      .listing-card-photo {
        width: 100%;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        border-radius: 1rem 1rem 0 0;
      }

      .listing-card-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
      }

      .listing-card:hover .listing-card-photo img {
        transform: scale(1.03);
      }

      .listing-card-body {
        padding: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
      }

      .listing-card-city {
        font-size: 0.75rem;
        color: var(--clr-text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
      }

      .listing-card-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--clr-text-primary);
      }

      .listing-card-price {
        font-size: 0.9rem;
        color: var(--clr-text-secondary);
        margin-top: 0.25rem;
      }

      .listing-card-price strong {
        color: var(--clr-text-primary);
      }
    </style>
  @endpush
@endonce