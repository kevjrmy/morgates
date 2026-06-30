@extends('layouts.account')

@section('title', 'Mes abonnements - Morgates')

@push('styles')
<style>
  /* ── Plan card ───────────────────────────────────────────── */
  .sub-plan-card {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    padding: 1.125rem;
    background: var(--clr-background);
    border: 0.5px solid #EBEBEB;
    border-left: 3px solid var(--clr-primary);
    border-radius: 0.875rem;
    box-shadow: var(--box-shadow);
  }

  .sub-plan-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 0.75rem;
  }

  .sub-plan-eyebrow {
    display: block;
    font-size: 0.68rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--clr-text-light);
    margin-bottom: 0.25rem;
  }

  .sub-plan-name {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--clr-text-dark);
    line-height: 1.2;
  }

  /* ── Billing cycle toggle ────────────────────────────────── */
  .sub-cycle-toggle {
    display: flex;
    gap: 0.25rem;
    background: #F3F3F3;
    border-radius: 0.625rem;
    padding: 0.25rem;
  }

  .sub-cycle-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    padding: 0.5rem 0.625rem;
    border: none;
    border-radius: 0.4rem;
    background: transparent;
    font: inherit;
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--clr-text-medium);
    cursor: pointer;
    transition: background 0.15s, color 0.15s, box-shadow 0.15s;
    white-space: nowrap;
  }

  .sub-cycle-btn.is-active {
    background: var(--clr-background);
    color: var(--clr-text-dark);
    font-weight: 600;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
  }

  .sub-cycle-savings {
    display: inline-flex;
    align-items: center;
    padding: 0.1rem 0.35rem;
    background: #d1fae5;
    color: #065f46;
    border-radius: 99px;
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.02em;
  }

  /* ── Slot usage ──────────────────────────────────────────── */
  .sub-slots {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
  }

  .sub-slots-labels {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    font-size: 0.78rem;
    color: var(--clr-text-medium);
  }

  .sub-slots-labels strong {
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--clr-text-dark);
  }

  .sub-slots-track {
    height: 6px;
    background: #EBEBEB;
    border-radius: 99px;
    overflow: hidden;
  }

  .sub-slots-fill {
    height: 100%;
    background: var(--clr-primary);
    border-radius: 99px;
    transition: width 0.5s ease;
  }

  .sub-slots-fill--full {
    background: #f59e0b;
  }

  .sub-slots-hint {
    margin: 0;
    font-size: 0.72rem;
    color: var(--clr-text-light);
  }

  .sub-slots-hint--full {
    color: #b45309;
    font-weight: 600;
  }

  /* ── Plan footer ─────────────────────────────────────────── */
  .sub-plan-footer {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding-top: 0.875rem;
    border-top: 0.5px solid #F0F0F0;
    font-size: 0.8rem;
    color: var(--clr-text-medium);
  }

  .sub-plan-footer svg {
    width: 1rem;
    height: 1rem;
    flex-shrink: 0;
    color: var(--clr-text-light);
  }

  /* ── Linked listings ─────────────────────────────────────── */
  .sub-listing {
    display: grid;
    grid-template-columns: 3.5rem 1fr auto;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: var(--clr-background);
    border-bottom: 0.5px solid #EBEBEB;
    text-decoration: none;
    transition: background 0.15s;
  }

  .sub-listing:last-child {
    border-bottom: none;
  }

  .sub-listing:hover {
    background: #FAFAFA;
  }

  .sub-thumb {
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 0.5rem;
    background: #eef2f8;
    overflow: hidden;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #b0bfd5;
  }

  .sub-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .sub-thumb svg {
    width: 1.25rem;
    height: 1.25rem;
  }

  .sub-info {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
    min-width: 0;
  }

  .sub-info-type {
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--clr-text-light);
  }

  .sub-info-title {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--clr-text-dark);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .sub-info-location {
    font-size: 0.72rem;
    color: var(--clr-text-medium);
  }

  .sub-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.375rem;
    flex-shrink: 0;
  }

  .sub-chevron {
    width: 1rem;
    height: 1rem;
    color: #D0D0D0;
  }
</style>
@endpush

@section('content')
  @php
    $used      = $listings->count();
    $limit     = $plan['publication_limit'];
    $remaining = max($limit - $used, 0);
    $pct       = $limit > 0 ? min(round($used / $limit * 100), 100) : 0;
    $isFull    = $remaining === 0;
    $isYearly  = ($plan['billing_cycle'] ?? 'monthly') === 'yearly';
  @endphp

  <main id="account-page">

    <section class="account-section">
      <h2 class="account-section-title">Formule actuelle</h2>

      <div class="sub-plan-card">
        <div class="sub-plan-top">
          <div>
            <span class="sub-plan-eyebrow">Abonnement</span>
            <h3 class="sub-plan-name">{{ $plan['name'] }}</h3>
          </div>
          <span class="account-listing-status active">{{ $plan['status'] }}</span>
        </div>

        <div class="sub-cycle-toggle" role="group" aria-label="Fréquence de facturation">
          <button type="button" class="sub-cycle-btn {{ !$isYearly ? 'is-active' : '' }}" data-cycle="monthly">
            Mensuel
          </button>
          <button type="button" class="sub-cycle-btn {{ $isYearly ? 'is-active' : '' }}" data-cycle="yearly">
            Annuel
            <span class="sub-cycle-savings">-20%</span>
          </button>
        </div>

        <div class="sub-slots">
          <div class="sub-slots-labels">
            <span>Publications utilisées</span>
            <strong>{{ $used }} / {{ $limit }}</strong>
          </div>
          <div class="sub-slots-track">
            <div class="sub-slots-fill {{ $isFull ? 'sub-slots-fill--full' : '' }}" style="width: {{ $pct }}%"></div>
          </div>
          @if($isFull)
            <p class="sub-slots-hint sub-slots-hint--full">Limite atteinte</p>
          @else
            <p class="sub-slots-hint">{{ $remaining }} emplacement{{ $remaining > 1 ? 's' : '' }} disponible{{ $remaining > 1 ? 's' : '' }}</p>
          @endif
        </div>

        <div class="sub-plan-footer">
          @svg('tabler-calendar')
          <span>Renouvellement le {{ $plan['ends_at'] }}</span>
        </div>
      </div>
    </section>

    <section class="account-section">
      <div class="account-section-header">
        <h2 class="account-section-title">Annonces liées</h2>
        @if($listings->isNotEmpty() && !$isFull)
          <a href="{{ route('listings.create.index') }}" class="account-section-link">+ Publier</a>
        @endif
      </div>

      @if($listings->isEmpty())
        <div class="account-empty">
          @svg('tabler-building-store')
          <p>Aucune annonce publiée pour le moment.</p>
          <a href="{{ route('listings.create.index') }}" class="btn-primary">Publier une annonce</a>
        </div>
      @else
        <ul class="account-listings" role="list">
          @foreach($listings as $listing)
            <li>
              <a href="{{ route('account.listings.edit', $listing) }}" class="sub-listing">
                <div class="sub-thumb">
                  @if(!empty($listing->photos) && is_array($listing->photos) && count($listing->photos) > 0)
                    <img src="{{ asset('storage/' . $listing->photos[0]) }}" alt="{{ $listing->title }}">
                  @else
                    @svg($listing->type === 'boats' ? 'tabler-sailboat' : 'tabler-home-2')
                  @endif
                </div>

                <div class="sub-info">
                  <span class="sub-info-type">{{ $listing->typeLabel() }}</span>
                  <span class="sub-info-title">{{ $listing->title }}</span>
                  @if($listing->city)
                    <span class="sub-info-location">{{ $listing->city }}</span>
                  @endif
                </div>

                <div class="sub-meta">
                  <span class="account-listing-status {{ $listing->is_active ? 'active' : 'inactive' }}">
                    {{ $listing->is_active ? 'Active' : 'Inactive' }}
                  </span>
                  @svg('tabler-chevron-right', ['class' => 'sub-chevron'])
                </div>
              </a>
            </li>
          @endforeach
        </ul>
      @endif
    </section>

  </main>
@endsection

@push('scripts')
<script>
  const cycleBtns = document.querySelectorAll('.sub-cycle-btn')
  cycleBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      cycleBtns.forEach(b => b.classList.remove('is-active'))
      btn.classList.add('is-active')
    })
  })
</script>
@endpush
