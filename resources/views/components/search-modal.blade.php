@props(['initialTab' => 'stays'])

<div id="search-modal" class="search-modal" aria-hidden="true" data-initial-tab="{{ $initialTab }}">
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
        <div class="form-group has-autocomplete">
          <label for="city-stays">@svg('mdi-map-marker-outline') Où ?</label>
          <input type="text" name="city" id="city-stays" placeholder="Ville ou région" value="{{ request('city') }}"
            autocomplete="off">
        </div>
        <label class="nearby-toggle">
          <input type="checkbox" name="include_nearby" value="1" {{ request()->boolean('include_nearby') ? 'checked' : '' }}>
          <span>Inclure les destinations proches (20 km)</span>
        </label>
        <button type="submit" class="submit-button">
          @svg('mdi-magnify')
          <span>Rechercher</span>
        </button>
      </form>

      <!-- Boats Form -->
      <form action="{{ route('listings') }}" method="GET" id="form-boats" class="search-form">
        <input type="hidden" name="type" value="boats">
        <div class="form-group has-autocomplete">
          <label for="city-boats">@svg('mdi-anchor') Port de départ</label>
          <input type="text" name="city" id="city-boats" placeholder="Ville ou port" value="{{ request('city') }}"
            autocomplete="off">
        </div>
        <label class="nearby-toggle">
          <input type="checkbox" name="include_nearby" value="1" {{ request()->boolean('include_nearby') ? 'checked' : '' }}>
          <span>Inclure les destinations proches (20 km)</span>
        </label>
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
        <div class="form-group has-autocomplete" data-suggest-url="/api/listings/suggest" data-suggest-mode="navigate">
          <label for="q-name">@svg('mdi-text-search') Nom de l'annonce ou de l'hôte</label>
          <input type="text" name="q" id="q-name" placeholder="Ex&nbsp;: Villa Bretagne, Jean Dupont..."
            value="{{ request('q') }}" autocomplete="off">
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
      display: flex;
      flex-direction: column;
      gap: 1.25rem;
    }

    .close-button {
      align-self: flex-end;
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
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 0.4rem;
      width: 100%;
      box-sizing: border-box;
      margin: 0 auto 0.5rem;
      padding: 0;
      overflow: visible;
    }

    .tab-button {
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 0;
      width: 100%;
      gap: 0.3rem;
      padding: 0.55rem 0.35rem;
      font-size: 0.78rem;
      border-radius: 12px;
    }

    .tab-button span {
      min-width: 0;
      overflow: hidden;
      text-overflow: ellipsis;
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

    .nearby-toggle {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.95rem 1rem;
      border: 1.5px solid #eee;
      border-radius: 16px;
      background-color: #fafafa;
      color: var(--clr-text-dark);
      font-size: 0.95rem;
      font-weight: 500;
    }

    .nearby-toggle input {
      width: 1rem;
      height: 1rem;
      accent-color: var(--clr-primary);
      flex-shrink: 0;
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

    .form-group.has-autocomplete {
      position: relative;
    }

    .autocomplete-dropdown {
      position: absolute;
      top: calc(100% + 0.5rem);
      left: 0;
      width: 100%;
      background: white;
      border: 1.5px solid #eee;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      z-index: 50;
      overflow-y: auto;
      max-height: 320px;
      display: none;
    }

    .autocomplete-dropdown.visible {
      display: block;
    }

    .autocomplete-item {
      padding: 0.9rem 1.1rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: background 0.15s;
      border-bottom: 1px solid #f5f5f5;
    }

    .autocomplete-item:last-child {
      border-bottom: none;
    }

    .autocomplete-item:hover,
    .autocomplete-item.highlighted {
      background-color: var(--clr-softblue);
    }

    .autocomplete-item .item-name {
      font-size: 1rem;
      color: var(--clr-text-dark);
      font-weight: 500;
    }

    .autocomplete-item .item-region {
      font-size: 0.78rem;
      color: var(--clr-text-light);
      margin-top: 0.15rem;
    }

    .autocomplete-empty {
      padding: 1.2rem 1.1rem;
      color: var(--clr-text-light);
      font-size: 0.9rem;
      text-align: center;
    }

    .autocomplete-loading {
      padding: 1.2rem 1.1rem;
      color: var(--clr-text-light);
      font-size: 0.9rem;
      text-align: center;
    }


  </style>
@endpush

@push('scripts')
  <script>
    (function () {
      function init() {
        // Global-ish state attached to window to avoid redeclaration errors if component is included twice
        window.autocompleteInstances = window.autocompleteInstances || new Map();

        window.openSearchModal = window.openSearchModal || function () {
          const modal = document.getElementById('search-modal');
          if (!modal) return;
          const initialTab = modal.dataset.initialTab || 'stays';
          modal.classList.add('active');
          document.body.style.overflow = 'hidden';
          switchTab(initialTab);
        };

        window.closeSearchModal = window.closeSearchModal || function () {
          const modal = document.getElementById('search-modal');
          if (modal) modal.classList.remove('active');
          document.body.style.overflow = '';
        };

        window.switchTab = window.switchTab || function (tab) {
          // Update buttons
          document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.tab === tab);
            btn.setAttribute('aria-pressed', btn.dataset.tab === tab ? 'true' : 'false');
          });

          // Update forms
          document.querySelectorAll('.search-form').forEach(form => {
            form.classList.toggle('active', form.id === `form-${tab}`);
          });
        };

        function initAutocomplete(inputEl) {
          const group = inputEl.closest('.form-group');
          if (!group) return;

          let dropdown = group.querySelector('.autocomplete-dropdown');
          if (!dropdown) {
            dropdown = document.createElement('div');
            dropdown.className = 'autocomplete-dropdown';
            group.appendChild(dropdown);
          }

          let debounceTimer = null;
          let highlightedIndex = -1;
          let items = [];

          function showLoading() {
            dropdown.innerHTML = '<div class="autocomplete-loading">Recherche...</div>';
            dropdown.classList.add('visible');
          }

          function showEmpty() {
            dropdown.innerHTML = '<div class="autocomplete-empty">Aucune destination trouvée</div>';
            dropdown.classList.add('visible');
            highlightedIndex = -1;
            items = [];
          }

          function renderResults(data) {
            if (!data || data.length === 0) {
              showEmpty();
              return;
            }

            highlightedIndex = -1;
            items = data;

            dropdown.innerHTML = data.map((d, i) => {
              // Listing suggestion (has 'url' field)
              if (d.url) {
                return `
                  <div class="autocomplete-item" data-index="${i}" data-url="${d.url}">
                    <div>
                      <div class="item-name">${d.title}</div>
                      <div class="item-region">${d.owner || ''}</div>
                    </div>
                  </div>
                `
              }
              // Destination suggestion
              return `
                <div class="autocomplete-item" data-index="${i}" data-name="${d.name}">
                  <div>
                    <div class="item-name">${d.name}</div>
                    ${d.region ? `<div class="item-region">${d.region}</div>` : ''}
                  </div>
                </div>
              `
            }).join('');

            dropdown.classList.add('visible');
          }

          function closeDropdown() {
            dropdown.classList.remove('visible');
            highlightedIndex = -1;
            items = [];
          }

          function setHighlight(idx) {
            const allItems = dropdown.querySelectorAll('.autocomplete-item');
            allItems.forEach((el, i) => el.classList.toggle('highlighted', i === idx));
            highlightedIndex = idx;
          }

          inputEl.addEventListener('input', () => {
            const val = inputEl.value.trim()
            const group = inputEl.closest('.form-group')
            const suggestUrl = group?.dataset.suggestUrl || '/api/destinations'

            closeDropdown()

            if (val.length < 2) return

            clearTimeout(debounceTimer)
            showLoading()

            debounceTimer = setTimeout(async () => {
              try {
                const res = await fetch(`${suggestUrl}?q=${encodeURIComponent(val)}`)
                if (!res.ok) throw new Error('fetch failed')
                const data = await res.json()
                renderResults(data)
              } catch {
                closeDropdown()
              }
            }, 300)
          })

          dropdown.addEventListener('click', (e) => {
            const item = e.target.closest('.autocomplete-item')
            if (item) {
              if (item.dataset.url) {
                window.location.href = item.dataset.url
              } else {
                inputEl.value = item.dataset.name
                closeDropdown()
                inputEl.focus()
              }
            }
          })

          inputEl.addEventListener('keydown', (e) => {
            if (!dropdown.classList.contains('visible') || items.length === 0) return
            if (e.key === 'ArrowDown') {
              e.preventDefault()
              setHighlight(Math.min(highlightedIndex + 1, items.length - 1))
            } else if (e.key === 'ArrowUp') {
              e.preventDefault()
              setHighlight(Math.max(highlightedIndex - 1, 0))
            } else if (e.key === 'Enter') {
              if (highlightedIndex >= 0) {
                e.preventDefault()
                const item = dropdown.querySelectorAll('.autocomplete-item')[highlightedIndex]
                if (item) {
                  if (item.dataset.url) {
                    window.location.href = item.dataset.url
                  } else {
                    inputEl.value = item.dataset.name
                    closeDropdown()
                  }
                }
              }
            } else if (e.key === 'Escape') {
              closeDropdown()
            }
          })

          document.addEventListener('click', (e) => {
            if (!group.contains(e.target)) closeDropdown();
          });
        }

        function attachAutocomplete() {
          document.querySelectorAll('.form-group.has-autocomplete input').forEach(input => {
            if (!window.autocompleteInstances.has(input)) {
              initAutocomplete(input);
              window.autocompleteInstances.set(input, true);
            }
          });
        }

        // Close on Escape key (global)
        if (!window.hasGlobalEscListener) {
          document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') window.closeSearchModal();
          });
          window.hasGlobalEscListener = true;
        }

        attachAutocomplete();
      }

      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
      } else {
        init();
      }
    })();
  </script>
@endpush
