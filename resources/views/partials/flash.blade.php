@if (session('success') || session('error'))
  <div class="flash-wrapper">
    @if (session('success'))
      <div class="flash flash-success" role="alert">
        @svg('tabler-circle-check', ['class' => 'icon'])
        <span>{{ session('success') }}</span>
        <button class="flash-close" aria-label="Fermer">
          @svg('tabler-x', ['class' => 'icon'])
        </button>
      </div>
    @endif

    @if (session('error'))
      <div class="flash flash-error" role="alert">
        @svg('tabler-alert-circle', ['class' => 'icon'])
        <span>{{ session('error') }}</span>
        <button class="flash-close" aria-label="Fermer">
          @svg('tabler-x', ['class' => 'icon'])
        </button>
      </div>
    @endif
  </div>

  <style>
    .flash-wrapper {
      position: fixed;
      bottom: 1.5rem;
      left: 50%;
      translate: -50% 0;
      z-index: 999;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      width: max-content;
      max-width: calc(100vw - 2rem);
    }

    .flash {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 1rem 1.5rem;
      font-size: 1rem;
      border-radius: 0.5rem;
      box-shadow: var(--box-shadow);
      animation: flash-in 0.5s ease;
    }

    .flash span {
      flex: 1;
    }

    .flash-success {
      background-color: #f0fdf4;
      color: #16a34a;
    }

    .flash-error {
      background-color: #fef2f2;
      color: #dc2626;
    }

    .flash-close {
      color: inherit;
      opacity: 0.6;
      transition: opacity 0.2s ease;
    }

    .flash-close:hover {
      opacity: 1;
    }

    @keyframes flash-in {
      from {
        opacity: 0;
        translate: 0 100%;
      }

      to {
        opacity: 1;
        translate: 0 0;
      }
    }
  </style>

  <script>
    function dismissFlash(el) {
      el.style.transition = 'opacity 0.3s ease';
      el.style.opacity = '0';
      setTimeout(() => el.remove(), 300);
    }

    document.querySelectorAll('.flash-close').forEach(btn => {
      btn.addEventListener('click', () => dismissFlash(btn.closest('.flash')));
    });

    document.querySelectorAll('.flash').forEach(el => {
      setTimeout(() => dismissFlash(el), 4000);
    });
  </script>
@endif