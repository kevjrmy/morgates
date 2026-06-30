@props(['listing'])

<div class="contact-bar">
  <div class="contact-bar-top">
    <div class="contact-price-wrapper">
      <div class="contact-price">
        @if($listing->price_amount)
          <span class="price-prefix">À partir de</span>
          <span class="price-amount">{{ number_format($listing->price_amount, 0, ',', ' ') }} €</span>
          <span class="price-label">/ {{ $listing->priceUnitLabel() }} *</span>
        @else
          <span class="price-amount">Prix sur demande</span>
        @endif
      </div>
    </div>
    <button type="button" class="btn-contact" id="btn-contact-open">
      Contacter directement
    </button>
  </div>
  @if($listing->price_amount)
    <div class="price-conditions">* consulter les tarifs et conditions auprès de l'hôte</div>
  @endif
</div>

<x-listings.contact-bottom-sheet :listing="$listing" />

@once
  @push('styles')
    <style>
      .contact-bar {
        position: fixed;
        bottom: 0;
        left: 50%;
        translate: -50% 0;
        width: 100%;
        max-width: var(--max-width);
        background-color: #fff;
        border-top: var(--border);
        padding: 0.75rem 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        z-index: 100;
        box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.05);
      }

      .contact-bar-top {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 0.65rem;
      }

      .contact-price-wrapper {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 0;
      }

      .contact-price {
        display: flex;
        flex-wrap: wrap;
        align-items: baseline;
        gap: 0.25rem;
        line-height: 1.1;
      }

      .price-prefix {
        font-size: 0.8rem;
        color: var(--clr-text-medium);
        font-weight: 400;
      }

      .price-amount {
        font-size: 1.rem;
        font-weight: 700;
        color: var(--clr-text-dark);
      }

      .price-label {
        font-size: 0.8rem;
        color: var(--clr-text-light);
        white-space: nowrap;
      }

      .price-conditions {
        font-size: 0.65rem;
        color: var(--clr-text-light);
        line-height: 1.2;
        margin-top: 0.1rem;
        text-align: center;
      }

      .btn-contact {
        padding: 0.65rem 1rem;
        border-radius: 0.75rem;
        background-color: var(--clr-primary);
        color: #fff;
        font-size: 0.9rem;
        font-weight: 700;
        transition: opacity 0.2s ease;
        white-space: nowrap;
        flex-shrink: 0;
        border: none;
        cursor: pointer;
        width: 100%;
        text-align: center;
      }

      .btn-contact:hover {
        opacity: 0.9;
      }

      @media (min-width: 380px) {
        .contact-bar {
          padding: 0.75rem 1rem;
        }
        .contact-bar-top {
          flex-direction: row;
          align-items: center;
          justify-content: space-between;
          gap: 0.5rem;
        }
        .btn-contact {
          width: auto;
          padding: 0.65rem 1rem;
          font-size: 0.9rem;
        }
      }

      @media (min-width: 480px) {
        .contact-bar {
          padding: 1rem 1.5rem;
        }
        .contact-bar-top {
          gap: 1rem;
        }
        .price-prefix {
          font-size: 0.9rem;
        }
        .price-amount {
          font-size: 1.1rem;
        }
        .price-label {
          font-size: 0.85rem;
        }
        .price-conditions {
          font-size: 0.75rem;
        }
        .btn-contact {
          padding: 0.85rem 1.5rem;
          font-size: 1rem;
        }
      }
    </style>
  @endpush
@endonce
