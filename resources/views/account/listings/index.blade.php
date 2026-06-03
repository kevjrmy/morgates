@extends('layouts.account')

@section('title', 'Mes annonces — Morgates')

@section('content')
  <main id="account-page">
    <section class="account-section">
      <div class="account-section-header">
        <h2 class="account-section-title">Mes annonces</h2>
      </div>

      @if($listings->isEmpty())
        <div class="account-empty">
          @svg('tabler-building-store')
          <p>Vous n'avez pas encore d'annonce.</p>
          <a href="{{ route('listings.create.index') }}" class="btn-primary">Publier ma première annonce</a>
        </div>
      @else
        <ul class="account-listings">
          @foreach($listings as $listing)
            <li class="account-listing">
              <div class="account-listing-info">
                <span class="account-listing-type">{{ $listing->typeLabel() }}</span>
                <span class="account-listing-title">{{ $listing->title }}</span>
                <span class="account-listing-location">{{ $listing->city }}</span>
              </div>
              <div class="account-listing-meta">
                <span class="account-listing-price">
                  @if($listing->price_amount)
                    {{ number_format($listing->price_amount, 0, ',', ' ') }} €<small>/{{ $listing->priceUnitLabel() }}</small>
                  @else
                    Prix sur demande
                  @endif
                </span>
                <span class="account-listing-status {{ $listing->is_active ? 'active' : 'inactive' }}">
                  {{ $listing->is_active ? 'Active' : 'Inactive' }}
                </span>
              </div>
            </li>
          @endforeach
        </ul>
      @endif
    </section>
  </main>
@endsection
