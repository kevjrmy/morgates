@props(['listing'])

<div class="bottom-sheet-overlay" id="contact-bottom-sheet" hidden>
  <div class="bottom-sheet-panel">
    <button type="button" class="bottom-sheet-close" aria-label="Fermer">
      @svg('tabler-x')
    </button>

    <h2 class="bottom-sheet-title">Contacter directement</h2>

    <ul class="contact-list-bottom" role="list">
      @if($listing->contact_email)
        <li>
          <a href="mailto:{{ $listing->contact_email }}" class="contact-item-bottom">
            <span class="contact-icon-bottom">@svg('tabler-mail')</span>
            <span class="contact-value-bottom">{{ $listing->contact_email }}</span>
          </a>
        </li>
      @endif

      @if($listing->contact_phone)
        <li>
          <a href="tel:{{ $listing->contact_phone }}" class="contact-item-bottom">
            <span class="contact-icon-bottom">@svg('tabler-phone')</span>
            <span class="contact-value-bottom">{{ $listing->contact_phone }}</span>
          </a>
        </li>
      @endif

      @if($listing->contact_whatsapp)
        <li>
          <a href="https://wa.me/{{ preg_replace('/\D+/', '', $listing->contact_whatsapp) }}"
             target="_blank" rel="noopener noreferrer" class="contact-item-bottom">
            <span class="contact-icon-bottom">@svg('tabler-brand-whatsapp')</span>
            <span class="contact-value-bottom">WhatsApp</span>
          </a>
        </li>
      @endif

      @if($listing->contact_website)
        <li>
          <a href="{{ $listing->contact_website }}"
             target="_blank" rel="noopener noreferrer" class="contact-item-bottom">
            <span class="contact-icon-bottom">@svg('tabler-world')</span>
            <span class="contact-value-bottom">{{ parse_url($listing->contact_website, PHP_URL_HOST) }}</span>
          </a>
        </li>
      @endif

      @unless($listing->contact_email || $listing->contact_phone || $listing->contact_whatsapp || $listing->contact_website)
        <li>
          <a href="mailto:{{ $listing->user->email }}" class="contact-item-bottom">
            <span class="contact-icon-bottom">@svg('tabler-mail')</span>
            <span class="contact-value-bottom">{{ $listing->user->email }}</span>
          </a>
        </li>
      @endunless
    </ul>
  </div>
</div>