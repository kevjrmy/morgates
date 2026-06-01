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
        <ul class="contact-list" role="list">
          @if($listing->contact_email)
            <li>
              <button type="button" class="contact-item" data-type="email" data-value="{{ $listing->contact_email }}">
                <span class="contact-icon">@svg('tabler-mail')</span>
                <span class="contact-label">Email</span>
                <span class="contact-reveal" hidden>
                  <span class="contact-value">{{ $listing->contact_email }}</span>
                  <span class="contact-copy" title="Copier">@svg('tabler-copy')</span>
                </span>
              </button>
            </li>
          @endif
          @if($listing->contact_phone)
            <li>
              <button type="button" class="contact-item" data-type="phone" data-value="{{ $listing->contact_phone }}">
                <span class="contact-icon">@svg('tabler-phone')</span>
                <span class="contact-label">Téléphone</span>
                <span class="contact-reveal" hidden>
                  <span class="contact-value">{{ $listing->contact_phone }}</span>
                  <span class="contact-copy" title="Copier">@svg('tabler-copy')</span>
                </span>
              </button>
            </li>
          @endif
          @if($listing->contact_whatsapp)
            <li>
              <button type="button" class="contact-item" data-type="whatsapp" data-href="https://wa.me/{{ preg_replace('/\D+/', '', $listing->contact_whatsapp) }}">
                <span class="contact-icon">@svg('tabler-brand-whatsapp')</span>
                <span class="contact-label">WhatsApp</span>
                <span class="contact-reveal" hidden>
                  <span class="contact-value">Ouvrir WhatsApp</span>
                  <a class="contact-open" href="https://wa.me/{{ preg_replace('/\D+/', '', $listing->contact_whatsapp) }}" target="_blank" rel="noopener noreferrer" title="Ouvrir">@svg('tabler-external-link')</a>
                </span>
              </button>
            </li>
          @endif
          @if($listing->contact_website)
            <li>
              <button type="button" class="contact-item" data-type="website" data-href="{{ $listing->contact_website }}">
                <span class="contact-icon">@svg('tabler-world')</span>
                <span class="contact-label">Web</span>
                <span class="contact-reveal" hidden>
                  <span class="contact-value">{{ parse_url($listing->contact_website, PHP_URL_HOST) }}</span>
                  <a class="contact-open" href="{{ $listing->contact_website }}" target="_blank" rel="noopener noreferrer" title="Ouvrir">@svg('tabler-external-link')</a>
                </span>
              </button>
            </li>
          @endif
          @unless($listing->contact_email || $listing->contact_phone || $listing->contact_whatsapp || $listing->contact_website)
            <li>
              <button type="button" class="contact-item" data-type="email" data-value="{{ $listing->user->email }}">
                <span class="contact-icon">@svg('tabler-mail')</span>
                <span class="contact-label">Email</span>
                <span class="contact-reveal" hidden>
                  <span class="contact-value">{{ $listing->user->email }}</span>
                  <span class="contact-copy" title="Copier">@svg('tabler-copy')</span>
                </span>
              </button>
            </li>
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

    .contact-list {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .contact-item {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      padding: 0.5rem 0.85rem;
      border-radius: 0.5rem;
      background-color: var(--clr-tertiary);
      border: none;
      cursor: pointer;
      transition: opacity 0.2s ease;
      min-width: 5.5rem;
    }

    .contact-item:hover {
      opacity: 0.8;
    }

    .contact-icon {
      display: flex;
      align-items: center;
      flex-shrink: 0;
    }

    .contact-icon svg {
      width: 1.1rem;
      height: 1.1rem;
    }

    .contact-label {
      font-size: 0.875rem;
      font-weight: 600;
      color: var(--clr-text-dark);
    }

    .contact-reveal {
      display: none;
      align-items: center;
      gap: 0.3rem;
    }

    .contact-item[data-state="open"] .contact-label {
      display: none;
    }

    .contact-item[data-state="open"] .contact-reveal {
      display: flex;
    }

    .contact-value {
      font-size: 0.8rem;
      color: var(--clr-text-dark);
      font-weight: 600;
    }

    .contact-copy {
      position: relative;
      display: flex;
      align-items: center;
      padding: 0.2rem;
      cursor: pointer;
      border-radius: 0.25rem;
      transition: color 0.15s ease, opacity 0.15s ease;
      flex-shrink: 0;
      color: var(--clr-primary);
    }

    .contact-copy:hover {
      opacity: 0.7;
    }

    .contact-copy.copied {
      color: var(--clr-success);
    }

    .contact-copy.copied::after {
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

    .contact-copy svg {
      width: 0.95rem;
      height: 0.95rem;
    }

    @keyframes copy-bubble {
      0% {
        opacity: 0;
        transform: translateY(0.25rem) scale(0.96);
      }

      15%,
      70% {
        opacity: 1;
        transform: translateY(0) scale(1);
      }

      100% {
        opacity: 0;
        transform: translateY(-0.45rem) scale(0.98);
      }
    }

    .contact-open {
      display: flex;
      align-items: center;
      padding: 0.2rem;
      border-radius: 0.25rem;
      transition: opacity 0.15s ease;
      flex-shrink: 0;
    }

    .contact-open:hover {
      opacity: 0.7;
    }

    .contact-open svg {
      width: 0.95rem;
      height: 0.95rem;
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
      padding: 0.85rem 1rem;
      border-radius: 0.5rem;
      background-color: var(--clr-tertiary);
      text-decoration: none;
      color: var(--clr-text-dark);
      transition: opacity 0.2s ease;
    }

    .contact-item-bottom:hover {
      opacity: 0.85;
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
      font-size: 0.95rem;
      font-weight: 500;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    </style>
@endpush

@push('scripts')
  <script>
    let openItem = null

document.querySelectorAll('.contact-item').forEach(item => {
  item.addEventListener('click', e => {
    const copyBtn = e.target.closest('.contact-copy')
    if (copyBtn) {
      const value = item.dataset.value
      if (value) {
        navigator.clipboard.writeText(value).then(() => {
          copyBtn.classList.add('copied')
          setTimeout(() => copyBtn.classList.remove('copied'), 2000)
        })
      }
      return
    }

    if (e.target.closest('.contact-open')) return

    if (item.dataset.type === 'whatsapp' && item.dataset.href && item.dataset.state === 'open') {
      window.open(item.dataset.href, '_blank', 'noopener')
      return
    }

    if (openItem && openItem !== item) {
      openItem.dataset.state = 'closed'
    }
    openItem = item
    item.dataset.state = 'open'
  })
})

document.addEventListener('click', e => {
  if (!e.target.closest('.contact-item') && openItem) {
    openItem.dataset.state = 'closed'
    openItem = null
  }
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
