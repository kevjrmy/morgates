@props(['listing'])

@php
  $preferred  = $listing->preferred_contact ?? 'email';
  $channelMap = [
    'email'    => $listing->contact_email,
    'phone'    => $listing->contact_phone,
    'whatsapp' => $listing->contact_whatsapp,
    'website'  => $listing->contact_website,
  ];
  $order  = array_values(array_unique(array_merge([$preferred], ['email', 'phone', 'whatsapp', 'website'])));
  $hasAny = array_filter($channelMap);
@endphp

<div class="bottom-sheet-overlay" id="contact-bottom-sheet" hidden>
  <div class="bottom-sheet-panel">
    <button type="button" class="bottom-sheet-close" aria-label="Fermer">
      @svg('tabler-x')
    </button>

    <h2 class="bottom-sheet-title">Contacter directement</h2>

    <ul class="contact-list-bottom" role="list">
      @foreach($order as $channel)
        @if(!empty($channelMap[$channel]))
          <li class="contact-item-bottom">
            @if($channel === 'email')
              <span class="contact-icon-bottom">@svg('tabler-mail')</span>
              <span class="contact-value-bottom">{{ $channelMap['email'] }}</span>
              <div class="contact-item-actions">
                <button class="contact-action-btn" data-copy="{{ $channelMap['email'] }}" title="Copier">@svg('tabler-copy')</button>
                <a class="contact-action-btn" href="mailto:{{ $channelMap['email'] }}" title="Envoyer un email">@svg('tabler-send')</a>
              </div>
            @elseif($channel === 'phone')
              <span class="contact-icon-bottom">@svg('tabler-phone')</span>
              <span class="contact-value-bottom">{{ $channelMap['phone'] }}</span>
              <div class="contact-item-actions">
                <button class="contact-action-btn" data-copy="{{ $channelMap['phone'] }}" title="Copier">@svg('tabler-copy')</button>
                <a class="contact-action-btn" href="tel:{{ $channelMap['phone'] }}" title="Appeler">@svg('tabler-phone-call')</a>
              </div>
            @elseif($channel === 'whatsapp')
              <span class="contact-icon-bottom">@svg('tabler-brand-whatsapp')</span>
              <span class="contact-value-bottom">{{ $channelMap['whatsapp'] }}</span>
              <div class="contact-item-actions">
                <button class="contact-action-btn" data-copy="{{ $channelMap['whatsapp'] }}" title="Copier">@svg('tabler-copy')</button>
                <a class="contact-action-btn" href="https://wa.me/{{ preg_replace('/\D+/', '', $channelMap['whatsapp']) }}"
                   target="_blank" rel="noopener noreferrer" title="Ouvrir WhatsApp">@svg('tabler-external-link')</a>
              </div>
            @elseif($channel === 'website')
              <span class="contact-icon-bottom">@svg('tabler-world')</span>
              <span class="contact-value-bottom">{{ parse_url($channelMap['website'], PHP_URL_HOST) }}</span>
              <div class="contact-item-actions">
                <a class="contact-action-btn" href="{{ $channelMap['website'] }}"
                   target="_blank" rel="noopener noreferrer" title="Ouvrir le site">@svg('tabler-external-link')</a>
              </div>
            @endif
          </li>
        @endif
      @endforeach

      @if(!$hasAny)
        <li class="contact-item-bottom">
          <span class="contact-icon-bottom">@svg('tabler-mail')</span>
          <span class="contact-value-bottom">{{ $listing->user->email }}</span>
          <div class="contact-item-actions">
            <button class="contact-action-btn" data-copy="{{ $listing->user->email }}" title="Copier">@svg('tabler-copy')</button>
            <a class="contact-action-btn" href="mailto:{{ $listing->user->email }}" title="Envoyer un email">@svg('tabler-send')</a>
          </div>
        </li>
      @endif
    </ul>
  </div>
</div>
