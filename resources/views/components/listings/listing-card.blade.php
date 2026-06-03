@props(['listing'])

<a href="{{ route('listing', $listing) }}" class="listing">
  <div class="listing-photo">
    @if(!empty($listing->photos) && count($listing->photos) > 0)
      <img src="{{ $listing->photos[0] }}" alt="{{ $listing->title }}" loading="lazy">
    @else
      <div class="listing-photo-fallback" style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background-color: var(--color-surface-2, #f3f4f6); color: var(--color-text-muted, #9ca3af);">
        @svg('tabler-photo-off', ['style' => 'width: 32px; height: 32px; opacity: 0.5;'])
      </div>
    @endif
  </div>
  <div class="listing-body">
    <div class="listing-top">
      <span class="listing-type">
        @switch($listing->type)
          @case('stays') @svg('tabler-home-star') Hébergement @break
          @case('boats') @svg('tabler-sailboat') Bateau @break
        @endswitch
      </span>
      <span class="listing-city">@svg('mdi-map-marker-outline', ['style' => 'width: 1rem; height: 1rem; vertical-align: sub;']){{ $listing->city }}</span>
    </div>
    <h3 class="listing-title">{{ $listing->title }}</h3>
    <p class="listing-meta">
      @if($listing->capacity)
        {{ $listing->capacity }} pers.
      @endif
      @if($listing->min_duration)
        {{ $listing->capacity ? '·' : '' }} min. {{ $listing->min_duration }} jour{{ $listing->min_duration > 1 ? 's' : '' }}
      @endif
    </p>
    <p class="listing-price">
      @if($listing->price_amount)
        <span class="price-from">à partir de</span>
        <strong class="price-value">{{ number_format($listing->price_amount, 0, ',', ' ') }} €</strong>
        <span class="price-unit">/ {{ $listing->priceUnitLabel() }}</span>
      @else
        <strong>Prix sur demande</strong>
      @endif
    </p>

  </div>
</a>

@once
@push('styles')
<style scoped>
  .listing {
    display: flex;
    gap: 0.85rem;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: var(--box-shadow);
    background-color: var(--clr-background);
    color: var(--clr-text-primary);
    transition: transform 0.2s ease;
  }

  .listing:hover {
    transform: translateY(-2px);
  }

  .listing-photo {
    flex-shrink: 0;
    width: 120px;
    aspect-ratio: 1 / 1;
    overflow: hidden;
  }

  .listing-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .listing:hover .listing-photo img {
    transform: scale(1.05);
  }

  .listing-body {
    flex: 1;
    padding: 0.75rem 0.75rem 0.75rem 0;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    min-width: 0;
  }

  .listing-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .listing-type {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--clr-primary);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .listing-type svg {
    height: 1rem;
    width: 1rem;
  }

  .listing-city {
    font-size: 0.75rem;
    color: var(--clr-text-secondary);
  }

  .listing-title {
    font-size: 0.95rem;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .listing-meta {
    font-size: 0.8rem;
    color: var(--clr-text-secondary);
  }

  .listing-price {
    margin-top: auto;
  }

  .price-from {
    font-size: 0.75rem;
    color: var(--clr-text-medium);
    font-weight: 400;
  }

  .price-value {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--clr-text-dark);
  }

  .price-unit {
    font-size: 0.8rem;
    color: var(--clr-text-secondary);
  }


</style>
@endpush
@endonce
