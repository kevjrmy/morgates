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
  <a href="{{ route('listing', $listing) }}" class="listing-card">
  <div class="listing-card-photo">
    @if(!empty($listing->photos) && count($listing->photos) > 0)
      <img src="{{ $listing->photos[0] }}" alt="{{ $listing->title }}">
    @else
      <div class="listing-card-photo-fallback">
        @svg('tabler-photo-off')
      </div>
    @endif
  </div>
  <div class="listing-card-body">
    <span class="listing-card-city">{{ $listing->city }}</span>
    <h3 class="listing-card-title">{{ $listing->title }}</h3>
    <p class="listing-card-price">
      @if($listing->price_amount)
        <span class="listing-card-price-from">à partir de</span>
        <strong class="listing-card-price-value">{{ number_format($listing->price_amount, 0, ',', ' ') }} €</strong>
        <span class="listing-card-price-unit">/ {{ $listing->priceUnitLabel() }}</span>
      @else
        <strong>Prix sur demande</strong>
      @endif
    </p>
  </div>
</a>
@endif

@once
@push('styles')
<style>
  .listings-scroll {
    display: flex;
    gap: 0.875rem;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    padding: 0.5rem 1.25rem 1.25rem 0;
    scrollbar-width: none;
  }

  .listings-scroll::-webkit-scrollbar {
    display: none;
  }

  .listing-card {
    flex: 0 0 72vw;
    max-width: 300px;
    scroll-snap-align: center;
    border-radius: 0.875rem;
    border: 0.5px solid #EBEBEB;
    background: var(--clr-background);
    box-shadow: var(--box-shadow);
    overflow: hidden;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
  }

  .listing-card:first-child {
    scroll-snap-align: start;
  }

  .listing-card:last-child {
    scroll-snap-align: end;
  }

  .listing-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    border-color: #D5D5D5;
  }

  .listing-card-photo {
    width: 100%;
    aspect-ratio: 4 / 3;
    overflow: hidden;
  }

  .listing-card-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.25s ease;
  }

  .listing-card:hover .listing-card-photo img {
    transform: scale(1.03);
  }

  .listing-card-photo-fallback {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #eef2f8;
    color: #b0bfd5;
  }

  .listing-card-photo-fallback svg {
    width: 1.75rem;
    height: 1.75rem;
    opacity: 0.6;
  }

  .listing-card-body {
    padding: 0.75rem 0.875rem;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  .listing-card-city {
    font-size: 0.68rem;
    color: var(--clr-text-light);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-weight: 600;
  }

  .listing-card-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--clr-text-dark);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .listing-card-price {
    font-size: 0.82rem;
    color: var(--clr-text-medium);
    margin-top: 0.2rem;
  }

  .listing-card-price-from {
    font-size: 0.72rem;
    color: var(--clr-text-light);
  }

  .listing-card-price-value {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--clr-text-dark);
  }

  .listing-card-price-unit {
    font-size: 0.75rem;
    color: var(--clr-text-medium);
  }

  .listing-card--more {
    border: 0.5px solid #DADADA;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--clr-text-medium);
    transition: border-color 0.15s ease, color 0.15s ease;
    background: var(--clr-background);
    box-shadow: none;
  }

  .listing-card--more:hover {
    border-color: var(--clr-primary);
    color: var(--clr-primary);
  }

  .listing-card-more-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    font-size: 0.875rem;
  }

  .listing-card-more-inner svg {
    width: 1.5rem;
    height: 1.5rem;
  }
</style>
@endpush
@endonce
