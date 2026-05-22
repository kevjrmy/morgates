@props(['url' => null])

@if ($url)
  <a href="{{ $url }}" class="btn-close" aria-label="Fermer">
    @svg('mdi-close')
  </a>
@else
  <button type="button" class="btn-close" {{ $attributes }} aria-label="Fermer">
    @svg('mdi-close')
  </button>
@endif

@pushOnce('styles')
  <style>
    .btn-close {
      align-self: flex-end;
      padding: 0.6rem;
      border-radius: 50%;
      background-color: #f5f5f7;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .btn-close:hover {
      background-color: #e5e5e7;
    }
  </style>
@endPushOnce