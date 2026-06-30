@extends('layouts.account')

@section('title', 'Modifier l\'annonce - Morgates')

@push('styles')
@vite(['resources/css/listing-create.css'])
<style>
  /* ── Edit page layout ────────────────────────────────────── */
  .ae-page {
    max-width: 720px;
    margin: 0 auto;
  }

  /* ── Back link + title ───────────────────────────────────── */
  .ae-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.75rem;
  }

  .ae-back {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    background: var(--clr-background);
    border: 0.5px solid #EBEBEB;
    color: var(--clr-text-medium);
    flex-shrink: 0;
    transition: background 0.15s, border-color 0.15s;
  }

  .ae-back:hover {
    background: #EBEBEB;
    border-color: #c0c0c0;
  }

  .ae-back svg {
    width: 1rem;
    height: 1rem;
  }

  .ae-page-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--clr-text-dark);
    margin: 0;
    letter-spacing: -0.01em;
  }

  /* ── Sections ────────────────────────────────────────────── */
  .ae-section {
    background: var(--clr-background);
    border: 0.5px solid #EBEBEB;
    border-radius: 0.875rem;
    margin-bottom: 1rem;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
  }

  .ae-section-header {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.875rem 1rem 0.75rem;
    border-bottom: 0.5px solid #F0F0F0;
  }

  .ae-section-icon {
    width: 1.6rem;
    height: 1.6rem;
    border-radius: 0.4rem;
    background: var(--clr-tertiary);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--clr-primary);
    flex-shrink: 0;
  }

  .ae-section-icon svg {
    width: 0.9rem;
    height: 0.9rem;
  }

  .ae-section-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--clr-text-dark);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin: 0;
  }

  .ae-section-body {
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  /* ── Field ───────────────────────────────────────────────── */
  .ae-field {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
  }

  .ae-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--clr-text-medium);
    letter-spacing: 0.01em;
  }

  .ae-label-hint {
    font-size: 0.72rem;
    color: var(--clr-text-light);
    font-weight: 400;
  }

  .ae-input,
  .ae-textarea,
  .ae-select {
    width: 100%;
    padding: 0.65rem 0.8rem;
    border: 0.5px solid #DADADA;
    border-radius: 0.5rem;
    background: #fff;
    color: var(--clr-text-dark);
    font: inherit;
    font-size: 0.875rem;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
  }

  .ae-input:focus,
  .ae-textarea:focus,
  .ae-select:focus {
    border-color: var(--clr-primary);
    box-shadow: 0 0 0 3px rgba(0, 68, 170, 0.1);
  }

  .ae-textarea {
    resize: vertical;
    line-height: 1.55;
    min-height: 7rem;
  }

  .ae-select-wrap {
    position: relative;
  }

  .ae-select-wrap .ae-select {
    appearance: none;
    padding-right: 2rem;
  }

  .ae-select-icon {
    position: absolute;
    right: 0.65rem;
    top: 50%;
    transform: translateY(-50%);
    width: 0.9rem;
    height: 0.9rem;
    color: var(--clr-text-light);
    pointer-events: none;
  }

  /* ── Grid helpers ────────────────────────────────────────── */
  .ae-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.875rem;
  }

  @media (max-width: 480px) {
    .ae-grid-2 {
      grid-template-columns: 1fr;
    }
  }

  /* ── Toggle switch ───────────────────────────────────────── */
  .ae-toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 0.875rem 1rem;
    background: #fff;
    border: 0.5px solid #EBEBEB;
    border-radius: 0.625rem;
    cursor: pointer;
    transition: border-color 0.15s;
  }

  .ae-toggle-row:hover {
    border-color: #c0c0c0;
  }

  .ae-toggle-label {
    display: flex;
    flex-direction: column;
    gap: 0.1rem;
    min-width: 0;
  }

  .ae-toggle-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--clr-text-dark);
  }

  .ae-toggle-hint {
    font-size: 0.75rem;
    color: var(--clr-text-light);
    line-height: 1.4;
  }

  .ae-toggle-switch {
    flex-shrink: 0;
    position: relative;
  }

  .ae-toggle-input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
  }

  .ae-toggle-track {
    display: block;
    width: 40px;
    height: 22px;
    background: #D1D5DB;
    border-radius: 999px;
    position: relative;
    transition: background 0.2s;
  }

  .ae-toggle-thumb {
    position: absolute;
    top: 3px;
    left: 3px;
    width: 16px;
    height: 16px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    transition: transform 0.2s;
  }

  .ae-toggle-input:checked ~ .ae-toggle-track {
    background: var(--clr-primary);
  }

  .ae-toggle-input:checked ~ .ae-toggle-track .ae-toggle-thumb {
    transform: translateX(18px);
  }

  /* ── Hint text ───────────────────────────────────────────── */
  .ae-hint {
    font-size: 0.72rem;
    color: var(--clr-text-light);
    line-height: 1.4;
    margin-top: -0.25rem;
  }

  /* ── Form actions ────────────────────────────────────────── */
  .ae-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 0.75rem;
    padding: 1.25rem 0 0;
    margin-top: 0.5rem;
  }

  .ae-btn-cancel {
    padding: 0.65rem 1.25rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--clr-text-medium);
    background: transparent;
    border: 0.5px solid #DADADA;
    text-decoration: none;
    transition: background 0.15s, border-color 0.15s;
  }

  .ae-btn-cancel:hover {
    background: #f0f0f0;
    border-color: #c0c0c0;
  }

  .ae-btn-save {
    padding: 0.65rem 1.5rem;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: #fff;
    background: var(--clr-primary);
    border: none;
    cursor: pointer;
    transition: opacity 0.15s;
  }

  .ae-btn-save:hover { opacity: 0.88; }
</style>
@endpush

@section('content')
<main id="account-page">
  <div class="ae-page">

    {{-- Header --}}
    <div class="ae-header">
      <a href="{{ route('account.listings') }}" class="ae-back" aria-label="Retour à mes annonces">
        @svg('tabler-arrow-left')
      </a>
      <h2 class="ae-page-title">Modifier l'annonce</h2>
    </div>

    {{-- Note: action="#" until backend is wired --}}
    <form action="#" method="POST">
      @csrf
      @method('PUT')

      {{-- ① Informations générales ──────────────────────── --}}
      <div class="ae-section">
        <div class="ae-section-header">
          <span class="ae-section-icon">@svg('tabler-info-circle')</span>
          <h3 class="ae-section-title">Informations générales</h3>
        </div>
        <div class="ae-section-body">

          <div class="ae-field">
            <label for="title" class="ae-label">Titre de l'annonce</label>
            <input type="text" name="title" id="title" class="ae-input"
              value="{{ old('title', $listing->title ?? '') }}" required maxlength="100">
          </div>

          <div class="ae-field">
            <label for="description" class="ae-label">Description</label>
            <textarea name="description" id="description" class="ae-textarea" rows="5">{{ old('description', $listing->description ?? '') }}</textarea>
          </div>

          <div class="ae-grid-2">
            <div class="ae-field">
              <label for="type" class="ae-label">Type de bien</label>
              <div class="ae-select-wrap">
                <select name="type" id="type" class="ae-select" required>
                  <option value="boats" {{ old('type', $listing->type ?? '') === 'boats' ? 'selected' : '' }}>Bateau</option>
                  <option value="stays" {{ old('type', $listing->type ?? '') === 'stays' ? 'selected' : '' }}>Hébergement</option>
                </select>
                @svg('tabler-chevron-down', ['class' => 'ae-select-icon'])
              </div>
            </div>
            <div class="ae-field">
              <label for="capacity" class="ae-label">Capacité</label>
              <input type="number" name="capacity" id="capacity" class="ae-input"
                value="{{ old('capacity', $listing->capacity ?? 2) }}" min="1" max="200">
            </div>
          </div>

        </div>
      </div>

      {{-- ② Tarification & Durée ─────────────────────────── --}}
      <div class="ae-section">
        <div class="ae-section-header">
          <span class="ae-section-icon">@svg('tabler-tag')</span>
          <h3 class="ae-section-title">Tarification & Durée</h3>
        </div>
        <div class="ae-section-body">

          <div class="ae-grid-2">
            <div class="ae-field">
              <label for="price_amount" class="ae-label">Prix <span class="ae-label-hint">(laisser vide = sur demande)</span></label>
              <input type="number" name="price_amount" id="price_amount" class="ae-input"
                value="{{ old('price_amount', $listing->price_amount ?? '') }}"
                placeholder="0" min="1" max="99999" step="1">
            </div>
            <div class="ae-field">
              <label for="price_unit" class="ae-label">Par</label>
              <div class="ae-select-wrap">
                <select name="price_unit" id="price_unit" class="ae-select">
                  <option value="hour"    {{ old('price_unit', $listing->price_unit ?? '') === 'hour'     ? 'selected' : '' }}>Heure</option>
                  <option value="half-day"{{ old('price_unit', $listing->price_unit ?? '') === 'half-day' ? 'selected' : '' }}>Demi-journée</option>
                  <option value="day"     {{ old('price_unit', $listing->price_unit ?? 'day') === 'day'   ? 'selected' : '' }}>Jour</option>
                  <option value="week"    {{ old('price_unit', $listing->price_unit ?? '') === 'week'     ? 'selected' : '' }}>Semaine</option>
                  <option value="month"   {{ old('price_unit', $listing->price_unit ?? '') === 'month'    ? 'selected' : '' }}>Mois</option>
                  <option value="contact" {{ old('price_unit', $listing->price_unit ?? '') === 'contact'  ? 'selected' : '' }}>Sur demande</option>
                </select>
                @svg('tabler-chevron-down', ['class' => 'ae-select-icon'])
              </div>
            </div>
          </div>

          <div class="ae-grid-2">
            <div class="ae-field">
              <label for="min_duration" class="ae-label">Durée minimum <span class="ae-label-hint">(jours)</span></label>
              <input type="number" name="min_duration" id="min_duration" class="ae-input"
                value="{{ old('min_duration', $listing->min_duration ?? 1) }}" min="1">
            </div>
            <div class="ae-field">
              <label for="max_duration" class="ae-label">Durée maximum <span class="ae-label-hint">(jours)</span></label>
              <input type="number" name="max_duration" id="max_duration" class="ae-input"
                value="{{ old('max_duration', $listing->max_duration ?? '') }}" min="1"
                placeholder="Pas de limite">
            </div>
          </div>

        </div>
      </div>

      {{-- ③ Localisation ──────────────────────────────────── --}}
      <div class="ae-section">
        <div class="ae-section-header">
          <span class="ae-section-icon">@svg('tabler-map-pin')</span>
          <h3 class="ae-section-title">Localisation</h3>
        </div>
        <div class="ae-section-body">

          <div class="ae-grid-2">
            <div class="ae-field">
              <label for="country" class="ae-label">Pays</label>
              <input type="text" name="country" id="country" class="ae-input"
                value="{{ old('country', $listing->country ?? 'FR') }}" maxlength="2">
            </div>
            <div class="ae-field">
              <label for="region" class="ae-label">Région</label>
              <input type="text" name="region" id="region" class="ae-input"
                value="{{ old('region', $listing->region ?? '') }}">
            </div>
          </div>

          <div class="ae-grid-2">
            <div class="ae-field">
              <label for="city" class="ae-label">Ville</label>
              <input type="text" name="city" id="city" class="ae-input"
                value="{{ old('city', $listing->city ?? '') }}">
            </div>
            <div class="ae-field">
              <label for="address" class="ae-label">Adresse <span class="ae-label-hint">(optionnel)</span></label>
              <input type="text" name="address" id="address" class="ae-input"
                value="{{ old('address', $listing->address ?? '') }}">
            </div>
          </div>

          <div class="ae-field">
            <label for="map_url" class="ae-label">Lien Google Maps <span class="ae-label-hint">(optionnel)</span></label>
            <input type="url" name="map_url" id="map_url" class="ae-input"
              value="{{ old('map_url', $listing->map_url ?? '') }}"
              placeholder="https://goo.gl/maps/…">
          </div>

        </div>
      </div>

      {{-- ④ Contact ─────────────────────────────────────────── --}}
      <div class="ae-section">
        <div class="ae-section-header">
          <span class="ae-section-icon">@svg('tabler-mail')</span>
          <h3 class="ae-section-title">Contact</h3>
        </div>
        <div class="ae-section-body">
          <p class="ae-hint">Laissez vide pour utiliser les coordonnées de votre profil par défaut.</p>

          <div class="ae-grid-2">
            <div class="ae-field">
              <label for="contact_email" class="ae-label">Email</label>
              <input type="email" name="contact_email" id="contact_email" class="ae-input"
                value="{{ old('contact_email', $listing->contact_email ?? '') }}">
            </div>
            <div class="ae-field">
              <label for="contact_phone" class="ae-label">Téléphone</label>
              <input type="tel" name="contact_phone" id="contact_phone" class="ae-input"
                value="{{ old('contact_phone', $listing->contact_phone ?? '') }}">
            </div>
          </div>

          <div class="ae-grid-2">
            <div class="ae-field">
              <label for="contact_whatsapp" class="ae-label">WhatsApp</label>
              <input type="tel" name="contact_whatsapp" id="contact_whatsapp" class="ae-input"
                value="{{ old('contact_whatsapp', $listing->contact_whatsapp ?? '') }}">
            </div>
            <div class="ae-field">
              <label for="contact_website" class="ae-label">Site web</label>
              <input type="url" name="contact_website" id="contact_website" class="ae-input"
                value="{{ old('contact_website', $listing->contact_website ?? '') }}">
            </div>
          </div>

        </div>
      </div>

      {{-- ⑤ Statut ───────────────────────────────────────────── --}}
      <div class="ae-section">
        <div class="ae-section-header">
          <span class="ae-section-icon">@svg('tabler-toggle-right')</span>
          <h3 class="ae-section-title">Statut</h3>
        </div>
        <div class="ae-section-body">
          <label class="ae-toggle-row" for="is_active_toggle">
            <div class="ae-toggle-label">
              <span class="ae-toggle-title">Annonce active</span>
              <span class="ae-toggle-hint">Visible par tous les visiteurs sur Morgates.</span>
            </div>
            <span class="ae-toggle-switch">
              <input
                type="hidden" name="is_active" value="0">
              <input
                type="checkbox" name="is_active" id="is_active_toggle"
                value="1" class="ae-toggle-input"
                {{ old('is_active', $listing->is_active ?? true) ? 'checked' : '' }}>
              <span class="ae-toggle-track"><span class="ae-toggle-thumb"></span></span>
            </span>
          </label>
        </div>
      </div>

      {{-- Actions ──────────────────────────────────────────── --}}
      <div class="ae-actions">
        <a href="{{ route('account.listings') }}" class="ae-btn-cancel">Annuler</a>
        <button type="submit" class="ae-btn-save">Enregistrer les modifications</button>
      </div>

    </form>
  </div>
</main>
@endsection

@push('scripts')
<script>
  // Fix toggle: when the checkbox is checked, remove the hidden input so only value=1 is submitted
  const toggle = document.getElementById('is_active_toggle');
  if (toggle) {
    toggle.addEventListener('change', () => {
      const hidden = toggle.previousElementSibling;
      hidden.disabled = toggle.checked;
    });
    // Init on load
    toggle.previousElementSibling.disabled = toggle.checked;
  }
</script>
@endpush
