@props([
  'listing' => null,
  'more' => null,
])

@if($more)
  <a href="{{ $more }}" class="listing-card listing-card--more">
    <div class="listing-card-more-inner">
      @svg('tabler-arrow-right')
      <span>Voir plus</span>
    </div>
  </a>
@else
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
@endif

@once
@push('styles')
<style>
  .listings-scroll {
    display: flex;
    gap: 1rem;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    padding: 0.5rem 0 1.5rem;
    scrollbar-width: none;
  }

  .listings-scroll::-webkit-scrollbar {
    display: none;
  }

  .listing-card {
    flex: 0 0 75vw;
    max-width: 320px;
    scroll-snap-align: center;
    border-radius: 1rem;
    background: var(--clr-background);
    box-shadow: var(--box-shadow);
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

  .listing-card--more {
    border: 1px solid var(--clr-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    aspect-ratio: 3 / 2;
    color: var(--clr-primary);
    transition: background-color 0.2s ease;
    background: transparent;
    box-shadow: none;
  }

  .listing-card--more:hover {
    background-color: rgba(0, 0, 0, 0.03);
  }

  .listing-card-more-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    font-size: 1rem;
  }
</style>
@endpush
@endonce