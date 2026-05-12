@props(['listing'])

<a href="{{ route('listing', $listing) }}" class="listing">
  <div class="listing-photo">
    <img src="{{ $listing->photos[0] }}" alt="{{ $listing->title }}" loading="lazy">
  </div>
  <div class="listing-body">
    <div class="listing-top">
      <span class="listing-type">
        @switch($listing->type)
          @case('stays') @svg('tabler-home-star') Séjour @break
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
        {{ $listing->capacity ? '·' : '' }} min. {{ $listing->min_duration }} {{ $listing->durationUnitLabel() }}{{ $listing->min_duration > 1 ? 's' : '' }}
      @endif
    </p>
    <p class="listing-price">
      @if($listing->price_amount)
        <strong>{{ number_format($listing->price_amount, 0, ',', ' ') }} {{ $listing->currencySymbol() }}</strong>
        <span>/ {{ $listing->priceUnitLabel() }}</span>
      @else
        <strong>Prix sur demande</strong>
      @endif
    </p>

  </div>
</a>

@once
@push('styles')
<style>
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
    font-size: 0.9rem;
    color: var(--clr-text-secondary);
    margin-top: auto;
  }

  .listing-price strong {
    color: var(--clr-text-primary);
    font-size: 1rem;
  }


</style>
@endpush
@endonce
