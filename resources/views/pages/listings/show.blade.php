@extends('layouts.listing')

@section('title', $listing->title . ' — Morgates')
@section('description', Str::limit($listing->description, 150))

@section('content')
  <main id="listing-page" style="position: relative">
    <x-listings.nav />

    {{-- Gallery --}}
    <section class="listing-gallery" id="gallery">
      @if ($listing->photos && count($listing->photos) > 0)
        <div class="gallery-grid">
          <div class="gallery-main">
            <img
              src="{{ Str::startsWith($listing->photos[0], 'http') ? $listing->photos[0] : asset('storage/' . $listing->photos[0]) }}"
              alt="{{ $listing->title }}">
          </div>
          @if (count($listing->photos) > 1)
            <div class="gallery-thumbs">
              @foreach (array_slice($listing->photos, 1, 4) as $i => $photo)
                <div class="gallery-thumb {{ $i === 3 && count($listing->photos) > 5 ? 'gallery-thumb--more' : '' }}">
                  <img src="{{ Str::startsWith($photo, 'http') ? $photo : asset('storage/' . $photo) }}"
                    alt="{{ $listing->title }} {{ $i + 2 }}">
                  @if ($i === 3 && count($listing->photos) > 5)
                    <span class="gallery-more">+{{ count($listing->photos) - 5 }}</span>
                  @endif
                </div>
              @endforeach
            </div>
          @endif
        </div>
      @else
        <div class="gallery-empty">
          @svg('tabler-photo-off', ['class' => 'icon'])
        </div>
      @endif
    </section>

    {{-- Content --}}
    <div class="listing-content">

      {{-- Title + location --}}
      <section class="listing-header">
        <div class="listing-type">
          @switch($listing->type)
            @case('house') @svg('tabler-home') Maison @break
            @case('boat') @svg('tabler-sailboat') Bateau @break
            @case('garage') @svg('tabler-car-garage') Garage @break
          @endswitch
        </div>
        <h1 class="listing-title">{{ $listing->title }}</h1>
        <p class="listing-location">
          @svg('tabler-map-pin', ['class' => 'icon'])
          {{ $listing->city }}, {{ $listing->country }}
        </p>
        <div class="listing-meta">
          <span>
            {{ $listing->max_guests }} {{ $listing->max_guests > 1 ? 'voyageurs' : 'voyageur' }}
          </span>
          <span aria-hidden="true">·</span>
          <span>{{ $listing->min_nights }} nuit{{ $listing->min_nights > 1 ? 's' : '' }} min.</span>
          @if ($listing->max_nights)
            <span aria-hidden="true">·</span>
            <span>{{ $listing->max_nights }} nuits max.</span>
          @endif
        </div>
      </section>

      <hr class="listing-divider">

      {{-- Host --}}
      <section class="listing-host">
        <div class="host-info">
          <div class="host-avatar">
            @if ($listing->user->profile_picture)
              <img src="{{ Str::startsWith($listing->user->profile_picture, 'http') ? $listing->user->profile_picture : asset('storage/' . $listing->user->profile_picture) }}"
                alt="{{ $listing->user->name }}">
            @else
              @svg('tabler-user', ['class' => 'icon'])
            @endif
          </div>
          <div class="host-details">
            <span class="host-label">Proposé par</span>
            <span class="host-name">{{ $listing->user->name ?? 'Hôte Morgates' }}</span>
          </div>
        </div>
      </section>

      <hr class="listing-divider">

      {{-- Description --}}
      @if ($listing->description)
        <section class="listing-description">
          <h2>À propos de ce logement</h2>
          <div class="description-text" id="description-text">
            {!! nl2br(e($listing->description)) !!}
          </div>
          <button class="btn-readmore" id="btn-readmore">Lire plus</button>
        </section>

        <hr class="listing-divider">
      @endif

      {{-- Tags --}}
      @if ($listing->tags && count($listing->tags) > 0)
        <section class="listing-tags">
          <h2>Équipements</h2>
          <ul class="tags-list" role="list">
            @foreach ($listing->tags as $tag)
              <li class="tag">{{ $tag }}</li>
            @endforeach
          </ul>
        </section>

        <hr class="listing-divider">
      @endif

    </div>
    {{-- end listing-content --}}

    {{-- Booking bar spacer --}}
    <div class="booking-bar-spacer"></div>

  </main>
@endsection

@section('booking-bar')
  <div class="booking-bar">
    <div class="booking-price">
      <span class="price-amount">{{ number_format($listing->price_per_night, 0, ',', ' ') }}
        {{ $listing->currency }}</span>
      <span class="price-label">/ nuit</span>
    </div>
    @if ($listing->booking_links && count($listing->booking_links) > 0)
      <a href="{{ $listing->booking_links[0] }}" target="_blank" rel="noopener noreferrer" class="btn-book">
        Réserver
      </a>
    @else
      <a href="mailto:{{ $listing->user->email }}" class="btn-book">
        Contacter l'hôte
      </a>
    @endif
  </div>
@endsection

@push('styles')
  <style>
    #listing-page {
      padding-bottom: 2rem;
    }

    /* Gallery */
    .listing-gallery {
      width: 100%;
    }

    .gallery-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 0.25rem;
    }

    .gallery-main img {
      width: 100%;
      height: 260px;
      object-fit: cover;
    }

    .gallery-thumbs {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 0.25rem;
    }

    .gallery-thumb {
      position: relative;
      overflow: hidden;
    }

    .gallery-thumb img {
      width: 100%;
      height: 80px;
      object-fit: cover;
    }

    .gallery-thumb--more img {
      filter: brightness(0.5);
    }

    .gallery-more {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 1.1rem;
      font-weight: 700;
    }

    .gallery-empty {
      height: 220px;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: var(--clr-tertiary);
      color: var(--clr-text-light);
    }

    /* Content */
    .listing-content {
      padding: 1.5rem 1.25rem 0;
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .listing-divider {
      border: none;
      border-top: var(--border);
      margin: 0;
    }

    /* Header */
    .listing-type {
      display: flex;
      align-items: center;
      gap: 0.3rem;
      font-size: 0.8rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.07em;
      color: var(--clr-primary);
      margin-bottom: 0.5rem;
    }

    .listing-title {
      font-size: 1.4rem;
      font-weight: 700;
      line-height: 1.3;
      color: var(--clr-text-dark);
      margin-bottom: 0.5rem;
    }

    .listing-location {
      display: flex;
      align-items: center;
      gap: 0.3rem;
      font-size: 0.9rem;
      color: var(--clr-text-medium);
      margin-bottom: 0.5rem;
    }

    .listing-meta {
      display: flex;
      align-items: center;
      gap: 0.4rem;
      font-size: 0.875rem;
      color: var(--clr-text-medium);
      flex-wrap: wrap;
    }

    /* Host */
    .listing-host {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .host-info {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .host-avatar {
      width: 3rem;
      height: 3rem;
      border-radius: 50%;
      overflow: hidden;
      background-color: var(--clr-tertiary);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .host-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .host-details {
      display: flex;
      flex-direction: column;
    }

    .host-label {
      font-size: 0.8rem;
      color: var(--clr-text-light);
    }

    .host-name {
      font-weight: 600;
      color: var(--clr-text-dark);
    }

    /* Description */
    .listing-description h2,
    .listing-tags h2 {
      font-size: 1.1rem;
      font-weight: 700;
      margin-bottom: 0.75rem;
    }

    .description-text {
      font-size: 0.95rem;
      color: var(--clr-text-medium);
      line-height: 1.7;
      display: -webkit-box;
      -webkit-line-clamp: 4;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .description-text.expanded {
      display: block;
    }

    .btn-readmore {
      margin-top: 0.5rem;
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--clr-primary);
      text-decoration: underline;
      background: none;
      border: none;
      cursor: pointer;
      padding: 0;
    }

    /* Tags */
    .tags-list {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .tag {
      padding: 0.4rem 0.85rem;
      border-radius: 99px;
      border: var(--border);
      font-size: 0.8rem;
      color: var(--clr-text-medium);
      background-color: #fff;
    }

    /* Booking bar */
    .booking-bar-spacer {
      height: 80px;
    }

    .booking-bar {
      position: fixed;
      bottom: 0;
      left: 50%;
      translate: -50% 0;
      width: 100%;
      max-width: var(--max-width);
      background-color: #fff;
      border-top: var(--border);
      padding: 1rem 1.25rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      z-index: 100;
    }

    .booking-price {
      display: flex;
      align-items: baseline;
      gap: 0.25rem;
    }

    .price-amount {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--clr-text-dark);
    }

    .price-label {
      font-size: 0.875rem;
      color: var(--clr-text-light);
    }

    .btn-book {
      padding: 0.85rem 2rem;
      border-radius: 0.5rem;
      background-color: var(--clr-primary);
      color: #fff;
      font-size: 1rem;
      font-weight: 600;
      transition: opacity 0.2s ease;
      white-space: nowrap;
    }

    .btn-book:hover {
      opacity: 0.9;
    }
  </style>
@endpush

@push('scripts')
  <script>
    const descriptionText = document.getElementById('description-text')
    const btnReadmore = document.getElementById('btn-readmore')

    btnReadmore?.addEventListener('click', () => {
      const expanded = descriptionText.classList.toggle('expanded')
      btnReadmore.textContent = expanded ? 'Lire moins' : 'Lire plus'
    })
  </script>
@endpush