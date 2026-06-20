@extends('layouts.listing')

@section('title', $listing->title . ' — Morgates')
@section('description', Str::limit($listing->description, 150))

@section('content')
  <main id="listing-page" style="position: relative">
    <x-listings.nav />

    <x-listings.slideshow :listing="$listing" />

    {{-- Content --}}
    <div class="listing-content">

      {{-- Title + location --}}
      <section class="listing-header">
        <div class="listing-type">
          @switch($listing->type)
            @case('stays') @svg('tabler-home-star') Hébergement @break
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
            <span>{{ $listing->min_duration }} jour{{ $listing->min_duration > 1 ? 's' : '' }} min.</span>
          @endif
          @if ($listing->max_duration)
            <span aria-hidden="true">·</span>
            <span>{{ $listing->max_duration }} jour{{ $listing->max_duration > 1 ? 's' : '' }} max.</span>
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
                alt="{{ $listing->user->display_host_name }}">
            @else
              @svg('tabler-user', ['class' => 'icon'])
            @endif
          </div>
          <div class="host-details">
            <span class="host-label">Proposé par</span>
            <span class="host-name">{{ $listing->user->display_host_name ?? 'Hôte Morgates' }}</span>
          </div>
        </div>
      </section>

      <hr class="listing-divider">

      {{-- Direct contact --}}
      <section class="listing-contact">
        <h2>Contact rapide</h2>
        @php
          $preferred = $listing->preferred_contact ?? 'email';
          $channels  = [
            'email'    => $listing->contact_email,
            'phone'    => $listing->contact_phone,
            'whatsapp' => $listing->contact_whatsapp,
            'website'  => $listing->contact_website,
          ];
          $active = null;
          if (!empty($channels[$preferred])) {
            $active = $preferred;
          } else {
            foreach (['email', 'phone', 'whatsapp', 'website'] as $c) {
              if (!empty($channels[$c])) { $active = $c; break; }
            }
          }
        @endphp

        @if($active === 'email')
          <div class="contact-quick">
            <span class="contact-quick-icon">@svg('tabler-mail')</span>
            <span class="contact-quick-value">{{ $channels['email'] }}</span>
            <div class="contact-quick-actions">
              <button class="contact-action-btn" data-copy="{{ $channels['email'] }}" title="Copier">@svg('tabler-copy')</button>
              <a class="contact-action-btn" href="mailto:{{ $channels['email'] }}" title="Envoyer un email">@svg('tabler-send')</a>
            </div>
          </div>
        @elseif($active === 'phone')
          <div class="contact-quick">
            <span class="contact-quick-icon">@svg('tabler-phone')</span>
            <span class="contact-quick-value">{{ $channels['phone'] }}</span>
            <div class="contact-quick-actions">
              <button class="contact-action-btn" data-copy="{{ $channels['phone'] }}" title="Copier">@svg('tabler-copy')</button>
              <a class="contact-action-btn" href="tel:{{ $channels['phone'] }}" title="Appeler">@svg('tabler-phone-call')</a>
            </div>
          </div>
        @elseif($active === 'whatsapp')
          <div class="contact-quick">
            <span class="contact-quick-icon">@svg('tabler-brand-whatsapp')</span>
            <span class="contact-quick-value">{{ $channels['whatsapp'] }}</span>
            <div class="contact-quick-actions">
              <button class="contact-action-btn" data-copy="{{ $channels['whatsapp'] }}" title="Copier">@svg('tabler-copy')</button>
              <a class="contact-action-btn" href="https://wa.me/{{ preg_replace('/\D+/', '', $channels['whatsapp']) }}" target="_blank" rel="noopener noreferrer" title="Ouvrir WhatsApp">@svg('tabler-external-link')</a>
            </div>
          </div>
        @elseif($active === 'website')
          <div class="contact-quick">
            <span class="contact-quick-icon">@svg('tabler-world')</span>
            <span class="contact-quick-value">{{ parse_url($channels['website'], PHP_URL_HOST) }}</span>
            <div class="contact-quick-actions">
              <a class="contact-action-btn" href="{{ $channels['website'] }}" target="_blank" rel="noopener noreferrer" title="Ouvrir le site">@svg('tabler-external-link')</a>
            </div>
          </div>
        @else
          <div class="contact-quick">
            <span class="contact-quick-icon">@svg('tabler-mail')</span>
            <span class="contact-quick-value">{{ $listing->user->email }}</span>
            <div class="contact-quick-actions">
              <button class="contact-action-btn" data-copy="{{ $listing->user->email }}" title="Copier">@svg('tabler-copy')</button>
              <a class="contact-action-btn" href="mailto:{{ $listing->user->email }}" title="Envoyer un email">@svg('tabler-send')</a>
            </div>
          </div>
        @endif
      </section>

      <hr class="listing-divider">

      {{-- Description --}}
      @if ($listing->description)
        <section class="listing-description">
          <h2>À propos de cette annonce</h2>
          <div class="description-text" id="description-text">
            {!! nl2br(e($listing->description)) !!}
          </div>
          <button class="btn-readmore" id="btn-readmore" hidden>Lire plus</button>
        </section>

        <hr class="listing-divider">
      @endif

      <x-listings.tags :listing="$listing" />

      <hr class="listing-divider">

      {{-- Map --}}
      @if ($listing->map_embed_url)
        <section class="listing-map">
          <h2>Emplacement</h2>
          <div class="map-container">
            <iframe 
              src="{{ $listing->map_embed_url }}" 
              width="100%" 
              height="100%" 
              style="border:0;" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </section>

        <hr class="listing-divider">
      @endif

      <x-listings.gallery :listing="$listing" />

      <hr class="listing-divider">

      {{-- Share --}}
      <section class="listing-share">
        <p class="listing-share-label">Enregistrez ce lien en le partageant</p>
        <button type="button" class="btn-share" id="btn-share">
          @svg('tabler-share', ['class' => 'share-icon'])
          <span class="btn-share-text">Partager cette annonce</span>
        </button>
      </section>

    </div>
    {{-- end listing-content --}}


  </main>
@endsection

@section('contact-bar')
  <x-listings.cta :listing="$listing" />
@endsection

@push('styles')
  <style>
    #listing-page {
      padding-bottom: calc(2rem + 130px);
    }

    @media (min-width: 380px) {
      #listing-page {
        padding-bottom: calc(2rem + 80px);
      }
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
    .listing-tags h2,
    .listing-map h2 {
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


    /* Map */
    .map-container {
      width: 100%;
      aspect-ratio: 16 / 9;
      border-radius: 0.75rem;
      overflow: hidden;
      background-color: var(--clr-tertiary);
    }
    
    .map-container iframe {
      width: 100%;
      height: 100%;
      border: 0;
    }

    .contact-quick {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.85rem 1rem;
      background: var(--clr-tertiary);
      border-radius: 0.75rem;
    }

    .contact-quick-icon {
      display: flex;
      align-items: center;
      flex-shrink: 0;
      color: var(--clr-primary);
    }

    .contact-quick-icon svg {
      width: 1.25rem;
      height: 1.25rem;
    }

    .contact-quick-value {
      flex: 1;
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--clr-text-dark);
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .contact-quick-actions {
      display: flex;
      align-items: center;
      gap: 0.15rem;
      flex-shrink: 0;
    }

    .contact-action-btn {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 2rem;
      height: 2rem;
      border-radius: 0.4rem;
      border: none;
      background: none;
      color: var(--clr-text-light);
      cursor: pointer;
      transition: color 0.15s, background 0.15s;
      text-decoration: none;
    }

    .contact-action-btn:hover {
      color: var(--clr-primary);
      background: rgba(0, 68, 170, 0.06);
    }

    .contact-action-btn svg {
      width: 1.1rem;
      height: 1.1rem;
    }

    .contact-action-btn.copied {
      color: var(--clr-success);
    }

    .contact-action-btn.copied::after {
      content: 'Copié ✓';
      position: absolute;
      right: 0;
      bottom: calc(100% + 0.4rem);
      padding: 0.25rem 0.45rem;
      border-radius: 0.4rem;
      background-color: var(--clr-text-dark);
      box-shadow: var(--box-shadow);
      color: #fff;
      font-size: 0.7rem;
      font-weight: 700;
      line-height: 1;
      white-space: nowrap;
      pointer-events: none;
      animation: copy-bubble 2s ease forwards;
    }

    @keyframes copy-bubble {
      0%          { opacity: 0; transform: translateY(0.25rem) scale(0.96); }
      15%, 70%    { opacity: 1; transform: translateY(0) scale(1); }
      100%        { opacity: 0; transform: translateY(-0.45rem) scale(0.98); }
    }

    /* Share */
    .listing-share {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.75rem;
      text-align: center;
      padding: 0.5rem 0 1rem;
    }

    .listing-share-label {
      font-size: 0.85rem;
      color: var(--clr-text-medium);
    }

    .btn-share {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.6rem 1.25rem;
      border-radius: 2rem;
      border: 1.5px solid var(--clr-border, #e0e0e0);
      background: none;
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--clr-text-dark);
      cursor: pointer;
      transition: border-color 0.2s ease, background-color 0.2s ease;
    }

    .btn-share:hover {
      border-color: var(--clr-primary);
      background-color: rgba(0, 68, 170, 0.04);
    }

    .btn-share.copied {
      color: var(--clr-success);
      border-color: var(--clr-success);
    }

    .share-icon {
      width: 1.1rem;
      height: 1.1rem;
      flex-shrink: 0;
    }

    /* Bottom sheet */
    .bottom-sheet-overlay {
      position: fixed;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 200;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .bottom-sheet-overlay:not([hidden]) {
      opacity: 1;
      visibility: visible;
    }

    .bottom-sheet-panel {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: #fff;
      border-radius: 1rem 1rem 0 0;
      padding: 1.5rem 1.25rem 2rem;
      transform: translateY(100%);
      transition: transform 0.3s ease;
      max-height: 80vh;
      overflow-y: auto;
    }

    .bottom-sheet-overlay:not([hidden]) .bottom-sheet-panel {
      transform: translateY(0);
    }

    .bottom-sheet-close {
      position: absolute;
      top: 1rem;
      right: 1rem;
      width: 2rem;
      height: 2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      background: none;
      border: none;
      cursor: pointer;
      color: var(--clr-text-light);
      border-radius: 50%;
      transition: background-color 0.15s ease;
    }

    .bottom-sheet-close:hover {
      background-color: var(--clr-tertiary);
    }

    .bottom-sheet-close svg {
      width: 1.5rem;
      height: 1.5rem;
    }

    .bottom-sheet-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--clr-text-dark);
      margin-bottom: 1.25rem;
      padding-right: 2rem;
    }

    .contact-list-bottom {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }

    .contact-item-bottom {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;
      background-color: var(--clr-tertiary);
    }

    .contact-icon-bottom {
      display: flex;
      align-items: center;
      flex-shrink: 0;
      color: var(--clr-primary);
    }

    .contact-icon-bottom svg {
      width: 1.25rem;
      height: 1.25rem;
    }

    .contact-value-bottom {
      flex: 1;
      font-size: 0.9rem;
      font-weight: 500;
      color: var(--clr-text-dark);
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .contact-item-actions {
      display: flex;
      align-items: center;
      gap: 0.15rem;
      flex-shrink: 0;
    }

    </style>
@endpush

@push('scripts')
  <script>
    document.querySelectorAll('.contact-action-btn[data-copy]').forEach(btn => {
      btn.addEventListener('click', () => {
        navigator.clipboard.writeText(btn.dataset.copy).then(() => {
          btn.classList.add('copied')
          setTimeout(() => btn.classList.remove('copied'), 2000)
        })
      })
    })

const descriptionText = document.getElementById('description-text')
const btnReadmore = document.getElementById('btn-readmore')

function checkReadmore() {
  if (!descriptionText || !btnReadmore) return

  const clone = descriptionText.cloneNode(true)
  clone.style.position = 'absolute'
  clone.style.visibility = 'hidden'
  clone.style.width = descriptionText.offsetWidth + 'px'
  clone.style.maxWidth = 'none'
  clone.classList.remove('expanded')
  descriptionText.parentNode.appendChild(clone)

  const isTruncated = clone.scrollHeight > descriptionText.offsetHeight

  clone.remove()
  btnReadmore.hidden = !isTruncated
}

if (descriptionText && btnReadmore) {
  btnReadmore.addEventListener('click', () => {
    const isExpanded = descriptionText.classList.toggle('expanded')
    btnReadmore.textContent = isExpanded ? 'Réduire' : 'Lire plus'
  })

  checkReadmore()

  let resizeTimeout
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout)
    resizeTimeout = setTimeout(checkReadmore, 100)
  })
}

const btnContactOpen = document.getElementById('btn-contact-open')
const contactBottomSheet = document.getElementById('contact-bottom-sheet')
const bottomSheetClose = contactBottomSheet?.querySelector('.bottom-sheet-close')

function openBottomSheet() {
  contactBottomSheet.hidden = false
  document.body.style.overflow = 'hidden'
}

function closeBottomSheet() {
  contactBottomSheet.hidden = true
  document.body.style.overflow = ''
}

if (btnContactOpen && contactBottomSheet) {
  btnContactOpen.addEventListener('click', openBottomSheet)

  bottomSheetClose?.addEventListener('click', closeBottomSheet)

  contactBottomSheet.addEventListener('click', e => {
    if (e.target === contactBottomSheet) {
      closeBottomSheet()
    }
  })

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && !contactBottomSheet.hidden) {
      closeBottomSheet()
    }
  })
}

const btnShare = document.getElementById('btn-share')
if (btnShare) {
  btnShare.addEventListener('click', async () => {
    const url = window.location.href
    const title = document.title

    if (navigator.share) {
      try {
        await navigator.share({ title, url })
      } catch (e) {
        // user cancelled — do nothing
      }
    } else {
      try {
        await navigator.clipboard.writeText(url)
        const text = btnShare.querySelector('.btn-share-text')
        const original = text.textContent
        btnShare.classList.add('copied')
        text.textContent = 'Lien copié ✓'
        setTimeout(() => {
          btnShare.classList.remove('copied')
          text.textContent = original
        }, 2500)
      } catch (e) {
        // clipboard not available
      }
    }
  })
}

  </script>
@endpush
