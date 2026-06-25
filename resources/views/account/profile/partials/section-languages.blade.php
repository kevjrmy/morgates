@php
  $spoken = json_decode($user->spoken_languages ?? '[]') ?: [];
  $languages = [
    'fr' => '🇫🇷 Français',
    'en' => '🇬🇧 English',
    'es' => '🇪🇸 Español',
    'it' => '🇮🇹 Italiano',
  ];
@endphp

<section class="account-section">
  <h2 class="account-section-title">Je parle…</h2>

  <div class="account-languages" id="account-languages">
    @foreach($languages as $code => $label)
      <label class="account-language-tag" data-checked="{{ in_array($code, $spoken) ? 'true' : 'false' }}">
        <input type="checkbox" name="spoken_languages[]" value="{{ $code }}" {{ in_array($code, $spoken) ? 'checked' : '' }}>
        <span>{{ $label }}</span>
      </label>
    @endforeach
  </div>
</section>

@push('scripts')
  <script>
    document.querySelectorAll('.account-language-tag').forEach((tag) => {
      tag.addEventListener('click', (e) => {
        if (e.target.tagName === 'INPUT') return
        const cb = tag.querySelector('input')
        cb.checked = !cb.checked
        tag.dataset.checked = cb.checked ? 'true' : 'false'
      })
    })
  </script>
@endpush
