@extends('layouts.account')

@section('title', 'Mes annonces — Morgates')

@push('styles')
<style>
  /* ── Page header ─────────────────────────────────────────── */
  .al-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .al-page-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--clr-text-dark);
    letter-spacing: -0.01em;
    margin: 0;
  }

  .al-new-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.55rem 1rem;
    border-radius: 0.5rem;
    background: var(--clr-primary);
    color: #fff;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    transition: opacity 0.2s;
    white-space: nowrap;
    flex-shrink: 0;
  }

  .al-new-btn:hover { opacity: 0.88; }

  .al-new-btn svg {
    width: 1rem;
    height: 1rem;
  }

  /* ── List ────────────────────────────────────────────────── */
  .al-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
  }

  /* ── Card ────────────────────────────────────────────────── */
  .al-card {
    display: grid;
    grid-template-columns: 5rem 1fr;
    background: var(--clr-background);
    border: 0.5px solid #EBEBEB;
    border-radius: 0.875rem;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: box-shadow 0.2s, border-color 0.2s;
    min-height: 5.5rem;
  }

  .al-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    border-color: #d5d5d5;
  }

  /* ── Thumbnail ───────────────────────────────────────────── */
  .al-thumb {
    position: relative;
    background: #eef2f8;
    overflow: hidden;
    flex-shrink: 0;
  }

  .al-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .al-thumb-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #b0bfd5;
  }

  .al-thumb-placeholder svg {
    width: 1.75rem;
    height: 1.75rem;
  }

  /* ── Body ────────────────────────────────────────────────── */
  .al-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 0.75rem 1rem;
    gap: 0.5rem;
    min-width: 0;
  }

  /* ── Top row: title + badge ──────────────────────────────── */
  .al-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 0.5rem;
  }

  .al-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--clr-text-dark);
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin: 0;
  }

  .al-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.15rem 0.55rem;
    border-radius: 99px;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    white-space: nowrap;
    flex-shrink: 0;
  }

  .al-badge svg {
    width: 0.75rem;
    height: 0.75rem;
  }

  .al-badge--active {
    background: #d1fae5;
    color: #065f46;
  }

  .al-badge--inactive {
    background: #EBEBEB;
    color: var(--clr-text-medium);
  }

  /* ── Meta chips ──────────────────────────────────────────── */
  .al-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem 0.875rem;
  }

  .al-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.72rem;
    color: var(--clr-text-medium);
  }

  .al-chip svg {
    width: 0.85rem;
    height: 0.85rem;
    color: var(--clr-text-light);
  }

  /* ── Bottom row: price + action ──────────────────────────── */
  .al-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    padding-top: 0.5rem;
    border-top: 0.5px solid #F0F0F0;
  }

  .al-price {
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--clr-text-dark);
  }

  .al-price small {
    font-size: 0.7rem;
    font-weight: 400;
    color: var(--clr-text-light);
  }

  .al-price--contact {
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--clr-text-medium);
    font-style: italic;
  }

  .al-edit-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.35rem 0.8rem;
    border-radius: 0.4rem;
    border: 0.5px solid #DADADA;
    background: #fff;
    color: var(--clr-text-dark);
    font-size: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.15s, border-color 0.15s;
    white-space: nowrap;
  }

  .al-edit-btn:hover {
    background: #f3f4f6;
    border-color: #c4c4c4;
  }

  .al-edit-btn svg {
    width: 0.85rem;
    height: 0.85rem;
  }

  /* ── Empty state ─────────────────────────────────────────── */
  .al-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 3rem 1.5rem;
    background: var(--clr-background);
    border: 0.5px dashed #D0D0D0;
    border-radius: 1rem;
    text-align: center;
  }

  .al-empty-icon {
    width: 3rem;
    height: 3rem;
    background: #eef2f8;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--clr-primary);
  }

  .al-empty-icon svg {
    width: 1.4rem;
    height: 1.4rem;
  }

  .al-empty h3 {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--clr-text-dark);
    margin: 0;
  }

  .al-empty p {
    font-size: 0.8rem;
    color: var(--clr-text-medium);
    margin: 0;
    line-height: 1.5;
    max-width: 22rem;
  }
</style>
@endpush

@section('content')
<main id="account-page">
  <section class="account-section">
    <div class="al-header">
      <h2 class="al-page-title">Mes annonces</h2>
      <a href="{{ route('listings.create.index') }}" class="al-new-btn">
        @svg('tabler-plus')
        Nouvelle annonce
      </a>
    </div>

    @if($listings->isEmpty())
      <div class="al-empty">
        <div class="al-empty-icon">
          @svg('tabler-building-store')
        </div>
        <div>
          <h3>Aucune annonce pour le moment</h3>
          <p>Publiez votre première annonce pour être visible sur Morgates.</p>
        </div>
        <a href="{{ route('listings.create.index') }}" class="btn-primary">Créer une annonce</a>
      </div>
    @else
      <ul class="al-list">
        @foreach($listings as $listing)
          <li class="al-card">
            <div class="al-thumb">
              @if(!empty($listing->photos) && is_array($listing->photos) && count($listing->photos) > 0)
                <img
                  src="{{ asset('storage/' . $listing->photos[0]) }}"
                  alt="{{ $listing->title }}"
                  onerror="this.parentElement.innerHTML='<div class=\'al-thumb-placeholder\'><svg viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'1.5\'><path d=\'M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z\'/></svg></div>'"
                >
              @else
                <div class="al-thumb-placeholder">
                  @svg($listing->type === 'boats' ? 'tabler-sailboat' : 'tabler-home-2')
                </div>
              @endif
            </div>

            <div class="al-body">
              <div class="al-top">
                <h3 class="al-title">{{ $listing->title }}</h3>
                <span class="al-badge {{ $listing->is_active ? 'al-badge--active' : 'al-badge--inactive' }}">
                  @svg($listing->is_active ? 'tabler-check' : 'tabler-eye-off')
                  {{ $listing->is_active ? 'Active' : 'Inactive' }}
                </span>
              </div>

              <div class="al-meta">
                <span class="al-chip">
                  @svg($listing->type === 'boats' ? 'tabler-sailboat' : 'tabler-home-2')
                  {{ $listing->typeLabel() }}
                </span>
                @if($listing->city)
                  <span class="al-chip">
                    @svg('tabler-map-pin')
                    {{ $listing->city }}
                  </span>
                @endif
                @if($listing->capacity)
                  <span class="al-chip">
                    @svg('tabler-users')
                    {{ $listing->capacity }} pers. max.
                  </span>
                @endif
              </div>

              <div class="al-bottom">
                @if($listing->price_amount)
                  <span class="al-price">
                    {{ number_format($listing->price_amount, 0, ',', ' ') }} €<small>/{{ $listing->priceUnitLabel() }}</small>
                  </span>
                @else
                  <span class="al-price--contact">Prix sur demande</span>
                @endif

                <a href="{{ route('account.listings.edit', $listing) }}" class="al-edit-btn">
                  @svg('tabler-pencil')
                  Modifier
                </a>
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    @endif
  </section>
</main>
@endsection
