<div class="listing-nav">
  <a href="{{ $href ?? 'javascript:history.back()' }}" class="listing-nav-btn" aria-label="Retour">
    @svg('tabler-arrow-left')
  </a>
  <button class="listing-nav-btn" id="btn-share" aria-label="Partager">
    @svg('tabler-share-2')
  </button>
</div>

@once
  @push('styles')
    <style>
      .listing-nav {
        position: absolute;
        top: 1rem;
        left: 1rem;
        right: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 10;
      }

      .listing-nav-btn {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 50%;
        background-color: var(--clr-transparent);
        box-shadow: var(--box-shadow);
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
      }
    </style>
  @endpush
@endonce

@push('scripts')
  <script>
    document.getElementById('btn-share')?.addEventListener('click', () => {
      if (navigator.share) {
        navigator.share({
          title: document.title,
          url: window.location.href,
        })
      }
    })
  </script>
@endpush