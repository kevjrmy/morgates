@props(['listing'])

@php
  $preferred  = $listing->preferred_contact ?? 'email';
  $social     = $listing->contact_social_links ?? [];
  $channelMap = [
    'email'     => $listing->contact_email,
    'phone'     => $listing->contact_phone,
    'whatsapp'  => $listing->contact_whatsapp,
    'website'   => $listing->contact_website,
    'instagram' => $social['instagram'] ?? null,
    'messenger' => $social['messenger'] ?? null,
  ];
  $order          = array_values(array_unique(array_merge([$preferred], array_keys($channelMap))));
  $hasAny         = array_filter($channelMap);
  $filled         = array_values(array_filter($order, fn($ch) => !empty($channelMap[$ch])));
  $hiddenCount    = max(0, count($filled) - 4);
@endphp

<div class="bottom-sheet-overlay" id="contact-bottom-sheet" hidden>
  <div class="bottom-sheet-panel">
    <div class="sheet-handle"></div>
    <button type="button" class="bottom-sheet-close" aria-label="Fermer">
      @svg('tabler-x')
    </button>

    <ul class="contact-list-bottom" role="list">
      @foreach($filled as $i => $channel)
          @php $isPrimary = $channel === $preferred; $isHidden = $i >= 4; @endphp
          <li class="contact-item-bottom {{ $isPrimary ? 'contact-item-bottom--primary' : '' }} {{ $isHidden ? 'contact-item-secondary' : '' }}"
              @if($isHidden) hidden @endif>
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
            @elseif($channel === 'instagram')
              <span class="contact-icon-bottom">@svg('tabler-brand-instagram')</span>
              <span class="contact-value-bottom">{{ parse_url($channelMap['instagram'], PHP_URL_HOST) . parse_url($channelMap['instagram'], PHP_URL_PATH) }}</span>
              <div class="contact-item-actions">
                <a class="contact-action-btn" href="{{ $channelMap['instagram'] }}"
                   target="_blank" rel="noopener noreferrer" title="Ouvrir Instagram">@svg('tabler-external-link')</a>
              </div>
            @elseif($channel === 'messenger')
              <span class="contact-icon-bottom">@svg('tabler-brand-messenger')</span>
              <span class="contact-value-bottom">{{ parse_url($channelMap['messenger'], PHP_URL_HOST) . parse_url($channelMap['messenger'], PHP_URL_PATH) }}</span>
              <div class="contact-item-actions">
                <a class="contact-action-btn" href="{{ $channelMap['messenger'] }}"
                   target="_blank" rel="noopener noreferrer" title="Ouvrir Messenger">@svg('tabler-external-link')</a>
              </div>
            @endif
          </li>
      @endforeach

      @if($hiddenCount > 0)
        <li>
          <button type="button" class="contact-expand-btn" id="contact-expand-btn">
            @svg('tabler-chevron-down')
            <span>Voir {{ $hiddenCount }} autre{{ $hiddenCount > 1 ? 's' : '' }} moyen{{ $hiddenCount > 1 ? 's' : '' }} de contact</span>
          </button>
        </li>
      @endif

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
