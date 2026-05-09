<div id="search-modal" class="search-modal" aria-hidden="true">
  <div class="search-modal-content">
    <div class="search-modal-header">
      <button type="button" class="close-button" onclick="closeSearchModal()" aria-label="Fermer">
        @svg('mdi-close')
      </button>
      <div class="search-tabs" aria-label="Type de recherche">
        <button type="button" class="tab-button active" data-tab="stays" onclick="switchTab('stays')"
          aria-pressed="true">
          @svg('mdi-home-outline')
          <span>Logements</span>
        </button>
        <button type="button" class="tab-button" data-tab="boats" onclick="switchTab('boats')" aria-pressed="false">
          @svg('mdi-sail-boat')
          <span>Bateaux</span>
        </button>
        <button type="button" class="tab-button" data-tab="name" onclick="switchTab('name')" aria-pressed="false">
          @svg('mdi-text-search')
          <span>Par nom</span>
        </button>
      </div>
    </div>

    <div class="search-modal-body">
      <!-- Stays Form -->
      <form action="{{ route('listings') }}" method="GET" id="form-stays" class="search-form active">
        <input type="hidden" name="type" value="stays">
        <div class="form-group">
          <label for="city-stays">@svg('mdi-map-marker-outline') Où ?</label>
          <input type="text" name="city" id="city-stays" placeholder="Ville ou région" value="{{ request('city') }}">
        </div>
        <button type="submit" class="submit-button">
          @svg('mdi-magnify')
          <span>Rechercher</span>
        </button>
      </form>

      <!-- Boats Form -->
      <form action="{{ route('listings') }}" method="GET" id="form-boats" class="search-form">
        <input type="hidden" name="type" value="boats">
        <div class="form-group">
          <label for="city-boats">@svg('mdi-anchor') Port de départ</label>
          <input type="text" name="city" id="city-boats" placeholder="Ville ou port" value="{{ request('city') }}">
        </div>
        <button type="submit" class="submit-button">
          @svg('mdi-magnify')
          <span>Rechercher</span>
        </button>
      </form>

      <!-- Name Search Form -->
      <form action="{{ route('listings') }}" method="GET" id="form-name" class="search-form">
        <div class="name-search-intro">
          <p>Vous avez vu une annonce ailleurs ? Retrouvez-la ici en tapant son nom ou celui de l'hôte.</p>
        </div>
        <div class="form-group">
          <label for="q-name">@svg('mdi-text-search') Nom de l'annonce ou de l'hôte</label>
          <input type="text" name="q" id="q-name" placeholder="Ex&nbsp;: Villa Bretagne, Jean Dupont..." value="{{ request('q') }}" autocomplete="off">
        </div>
        <button type="submit" class="submit-button">
          @svg('mdi-magnify')
          <span>Rechercher</span>
        </button>
      </form>
    </div>
  </div>
</div>

@push('styles')
  <style>
    .search-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1000;
      display: none;
      background-color: white;
    }

    .search-modal.active {
      display: block;
      overflow-y: auto;
    }

    .search-modal-content {
      width: 100%;
      max-width: var(--max-width);
      margin: 0 auto;
      min-height: 100dvh;
      display: flex;
      flex-direction: column;
      animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .search-modal-header {
      padding: 1.5rem;
      border-bottom: 1px solid #f0f0f0;
      position: sticky;
      top: 0;
      background: white;
      z-index: 10;
    }

    .close-button {
      position: absolute;
      top: 1.5rem;
      right: 1.5rem;
      padding: 0.6rem;
      border-radius: 50%;
      background-color: #f5f5f7;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .close-button:hover {
      background-color: #e5e5e7;
    }

    .search-tabs {
      display: flex;
      gap: 0.5rem;
      width: 100%;
      margin: 3.5rem auto 0.5rem; /* Slightly reduced margin to compensate for padding */
      overflow-x: auto;
      scrollbar-width: none;
      -ms-overflow-style: none;
      -webkit-overflow-scrolling: touch;
      padding: 0.5rem 1rem; /* Added vertical padding to prevent clipping */
    }

    .search-tabs::-webkit-scrollbar {
      display: none;
    }

    .tab-button {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      flex: 1;
      min-width: max-content;
      min-height: 3rem;
      font-weight: 600;
      color: var(--clr-text-dark);
      padding: 0.6rem 1rem;
      border: 1.5px solid #e5e5e7;
      border-radius: 14px;
      background-color: #fafafa;
      cursor: pointer;
      transition: all 0.2s;
      font-size: 0.85rem;
      white-space: nowrap;
    }

    .tab-button svg {
      width: 1.1rem;
      height: 1.1rem;
      color: var(--clr-text-medium);
      flex-shrink: 0;
      transition: color 0.2s;
    }

    .tab-button:hover {
      border-color: var(--clr-primary);
      background-color: white;
      box-shadow: 0 4px 12px rgba(0, 68, 170, 0.08);
    }

    .tab-button:focus-visible {
      outline: none;
      border-color: var(--clr-primary);
      box-shadow: 0 0 0 4px rgba(0, 68, 170, 0.12);
    }

    .tab-button.active {
      background-color: rgba(0, 68, 170, 0.06);
      border-color: var(--clr-primary);
      color: var(--clr-primary);
      box-shadow: 0 0 0 1px var(--clr-primary), 0 4px 12px rgba(0, 68, 170, 0.08);
    }

    .tab-button.active svg {
      color: var(--clr-primary);
    }

    .search-modal-body {
      padding: 2rem 1.5rem;
      flex: 1;
    }

    .search-form {
      display: none;
      flex-direction: column;
      gap: 2rem;
    }

    .search-form.active {
      display: flex;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.8rem;
    }

    .form-group label {
      font-size: 0.9rem;
      font-weight: 700;
      color: var(--clr-text-dark);
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }

    .form-group label svg {
      width: 1.2rem;
      height: 1.2rem;
      color: var(--clr-primary);
    }

    .form-group input {
      padding: 1.1rem;
      border: 1.5px solid #eee;
      border-radius: 16px;
      font-size: 1.1rem;
      outline: none;
      background-color: #fafafa;
      transition: all 0.2s;
    }

    .form-group input:focus {
      border-color: var(--clr-primary);
      background-color: white;
      box-shadow: 0 0 0 4px rgba(0, 68, 170, 0.1);
    }

    .submit-button {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.8rem;
      background-color: var(--clr-primary);
      color: white;
      padding: 1.2rem;
      border-radius: 16px;
      font-weight: 700;
      font-size: 1.2rem;
      margin-top: 1rem;
      box-shadow: 0 8px 16px rgba(0, 68, 170, 0.3);
      transition: transform 0.2s;
    }

    .submit-button svg {
      width: 1.5rem;
      height: 1.5rem;
    }

    .submit-button:active {
      transform: scale(0.98);
    }

    .name-search-intro {
      background-color: var(--clr-softblue);
      border-radius: 14px;
      padding: 1rem 1.2rem;
    }

    .name-search-intro p {
      color: var(--clr-text-medium);
      font-size: 0.9rem;
      line-height: 1.5;
    }
  </style>
@endpush

@push('scripts')
  <script>
    function openSearchModal() {
      document.getElementById('search-modal').classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeSearchModal() {
      document.getElementById('search-modal').classList.remove('active');
      document.body.style.overflow = '';
    }

    function switchTab(tab) {
      // Update buttons
      document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.tab === tab);
        btn.setAttribute('aria-pressed', btn.dataset.tab === tab ? 'true' : 'false');
      });

      // Update forms
      document.querySelectorAll('.search-form').forEach(form => {
        form.classList.toggle('active', form.id === `form-${tab}`);
      });
    }

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeSearchModal();
    });
  </script>
@endpush