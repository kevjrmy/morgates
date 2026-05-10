@extends('layouts.listing')

@section('title', $listing->title . ' — Morgates')
@section('description', Str::limit($listing->description, 150))

@section('content')
  <main id="listing-page" style="position: relative">
    <x-listings.nav />

    <x-listings.gallery :listing="$listing" />

    {{-- Content --}}
    <div class="listing-content">

      {{-- Title + location --}}
      <section class="listing-header">
        <div class="listing-type">
          @switch($listing->type)
            @case('stays') @svg('tabler-home-star') Séjour @break
            @case('boats') @svg('tabler-sailboat') Bateau @break
          @endswitch
        </div>
        <h1 class="listing-title">{{ $listing->title }}</h1>
        <p class="listing-location">
          @svg('tabler-map-pin', ['class' => 'icon'])
          @if($listing->region)
            <a href="{{ route('listings', ['region' => $listing->region]) }}" class="location-link">{{ $listing->region }}</a>
            <span aria-hidden="true">·</span>
          @endif
          <a href="{{ route('listings', ['city' => $listing->city]) }}" class="location-link">{{ $listing->city }}</a>
        </p>
        <div class="listing-meta">
          @if($listing->capacity)
            <span>
              {{ $listing->capacity }} {{ $listing->capacity > 1 ? 'personnes' : 'personne' }}
            </span>
          @endif
          @if($listing->min_duration)
            @if($listing->capacity)
              <span aria-hidden="true">·</span>
            @endif
            <span>{{ $listing->min_duration }} {{ $listing->durationUnitLabel() }}{{ $listing->min_duration > 1 ? 's' : '' }} min.</span>
          @endif
          @if ($listing->max_duration)
            <span aria-hidden="true">·</span>
            <span>{{ $listing->max_duration }} {{ $listing->durationUnitLabel() }}{{ $listing->max_duration > 1 ? 's' : '' }} max.</span>
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

      {{-- Direct contact --}}
      <section class="listing-contact">
        <h2>Contact direct</h2>
        <ul class="contact-list" role="list">
          @if($listing->contact_email)
            <li><a href="mailto:{{ $listing->contact_email }}">Email</a></li>
          @endif
          @if($listing->contact_phone)
            <li><a href="tel:{{ $listing->contact_phone }}">Téléphone</a></li>
          @endif
          @if($listing->contact_whatsapp)
            <li><a href="https://wa.me/{{ preg_replace('/\D+/', '', $listing->contact_whatsapp) }}" target="_blank" rel="noopener noreferrer">WhatsApp</a></li>
          @endif
          @if($listing->contact_website)
            <li><a href="{{ $listing->contact_website }}" target="_blank" rel="noopener noreferrer">Site externe</a></li>
          @endif
          @unless($listing->contact_email || $listing->contact_phone || $listing->contact_whatsapp || $listing->contact_website)
            <li><a href="mailto:{{ $listing->user->email }}">Email</a></li>
          @endunless
        </ul>
      </section>

      <hr class="listing-divider">

      {{-- Description --}}
      @if ($listing->description)
        <section class="listing-description">
          <h2>À propos de cette annonce</h2>
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

    {{-- Contact bar spacer --}}
    <div class="contact-bar-spacer"></div>

  </main>
@endsection

@section('contact-bar')
  <div class="contact-bar">
    <div class="contact-price">
      @if($listing->price_amount)
        <span class="price-amount">{{ number_format($listing->price_amount, 0, ',', ' ') }}
          {{ $listing->currency }}</span>
        <span class="price-label">/ {{ $listing->priceUnitLabel() }}</span>
      @else
        <span class="price-amount">Prix sur demande</span>
      @endif
    </div>
    <a href="{{ $listing->primaryContactUrl() }}" class="btn-contact" @if(Str::startsWith($listing->primaryContactUrl(), 'http')) target="_blank" rel="noopener noreferrer" @endif>
      Contacter directement
    </a>
  </div>
@endsection

@push('styles')
  <style>
    #listing-page {
      padding-bottom: 2rem;
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

    .contact-list {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .contact-list a {
      display: inline-flex;
      align-items: center;
      padding: 0.55rem 0.9rem;
      border-radius: 0.5rem;
      background-color: var(--clr-tertiary);
      color: var(--clr-text-dark);
      font-size: 0.875rem;
      font-weight: 600;
    }

    /* Contact bar */
    .contact-bar-spacer {
      height: 80px;
    }

    .contact-bar {
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

    .contact-price {
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

    .btn-contact {
      padding: 0.85rem 2rem;
      border-radius: 0.5rem;
      background-color: var(--clr-primary);
      color: #fff;
      font-size: 1rem;
      font-weight: 600;
      transition: opacity 0.2s ease;
      white-space: nowrap;
    }

    .btn-contact:hover {
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
