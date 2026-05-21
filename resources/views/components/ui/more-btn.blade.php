<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn-more']) }}>
  {{ $slot }}
</button>

@pushOnce('styles')
  <style>
    .btn-more {
      margin-top: 1rem;
      width: 100%;
      padding: 0.75rem;
      border-radius: 0.5rem;
      background: var(--clr-softblue);
      font-weight: 600;
      color: var(--clr-text-dark);
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .btn-more:hover {
      opacity: 0.8;
    }
  </style>
@endPushOnce