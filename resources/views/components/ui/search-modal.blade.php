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
          <span>Hébergements</span>
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
        <label class="nearby-toggle" data-nearby-toggle>
          <span class="toggle-track">
            <input type="checkbox" name="include_nearby" value="1" {{ request()->boolean('include_nearby') ? 'checked' : '' }}>
          </span>
          <span>Inclure les annonces à proximité (20 km)</span>
        </label>
        <div class="form-group has-autocomplete" data-city-autocomplete>
          <label for="city-stays">@svg('mdi-map-marker-outline') Où ?</label>
          <input type="text" name="city" id="city-stays" placeholder="Ville ou région" value="{{ request('city') }}"
            autocomplete="off">
        </div>
      </form>

      <!-- Boats Form -->
      <form action="{{ route('listings') }}" method="GET" id="form-boats" class="search-form">
        <input type="hidden" name="type" value="boats">
        <label class="nearby-toggle" data-nearby-toggle>
          <span class="toggle-track">
            <input type="checkbox" name="include_nearby" value="1" {{ request()->boolean('include_nearby') ? 'checked' : '' }}>
          </span>
          <span>Inclure les annonces à proximité (20 km)</span>
        </label>
        <div class="form-group has-autocomplete" data-city-autocomplete>
          <label for="city-boats">@svg('mdi-anchor') Port de départ</label>
          <input type="text" name="city" id="city-boats" placeholder="Ville ou port" value="{{ request('city') }}"
            autocomplete="off">
        </div>
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
      </form>
    </div>
    <div class="search-modal-footer">
      <button type="button" class="submit-button" disabled>
        @svg('mdi-magnify')
        <span>Rechercher</span>
      </button>
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
      color: var(--clr-text-dark);
      font-size: 0.95rem;
      font-weight: 500;
    }

    .nearby-toggle[hidden] {
      display: none;
    }

    .toggle-track {
      position: relative;
      width: 44px;
      height: 24px;
      background: #ddd;
      border-radius: 12px;
      transition: background 0.2s;
      flex-shrink: 0;
      cursor: pointer;
    }

    .toggle-track input {
      position: absolute;
      opacity: 0;
      width: 0;
      height: 0;
    }

    .toggle-track::after {
      content: '';
      position: absolute;
      top: 2px;
      left: 2px;
      width: 20px;
      height: 20px;
      background: white;
      border-radius: 50%;
      transition: transform 0.2s;
      box-shadow: 0 1px 3px rgba(0,0,0,0.15);
      pointer-events: none;
    }

    .toggle-track:has(input:checked) {
      background: var(--clr-primary);
    }

    .toggle-track:has(input:checked)::after {
      transform: translateX(20px);
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

    .submit-button:disabled {
      opacity: 0.4;
      cursor: not-allowed;
      box-shadow: none;
    }

    .search-modal-footer {
      position: sticky;
      bottom: 0;
      padding: 1.5rem;
      background: white;
      border-top: 1px solid #f0f0f0;
      z-index: 10;
    }

    .search-modal-footer .submit-button {
      margin-top: 0;
      width: 100%;
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
      top: calc(100% + 0.45rem);
      left: 0;
      right: 0;
      background: #fff;
      border: 1px solid rgba(0, 0, 0, 0.08);
      border-radius: 14px;
      box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12);
      z-index: 50;
      overflow-y: auto;
      max-height: 320px;
      display: none;
    }

    .autocomplete-dropdown.visible {
      display: block;
    }

    .autocomplete-item {
      width: 100%;
      padding: 0.85rem 1rem;
      cursor: pointer;
      display: block;
      text-align: left;
      transition: background 0.15s;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      background: #fff;
    }

    .autocomplete-item:last-child {
      border-bottom: none;
    }

    .autocomplete-item:hover,
    .autocomplete-item.highlighted {
      background-color: var(--clr-softblue);
    }

    .autocomplete-item .item-name {
      display: block;
      font-size: 1rem;
      color: var(--clr-text-dark);
      font-weight: 700;
    }

    .autocomplete-item .item-region {
      display: block;
      font-size: 0.82rem;
      color: var(--clr-text-medium);
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
        window.autocompleteInstances = window.autocompleteInstances || new Map()

        const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (char) => ({
          '&': '&amp;',
          '<': '&lt;',
          '>': '&gt;',
          "'": '&#039;',
          '"': '&quot;',
        }[char]))

        window.openSearchModal = window.openSearchModal || function () {
          const modal = document.getElementById('search-modal')
          if (!modal) return
          const initialTab = modal.dataset.initialTab || 'stays'
          modal.classList.add('active')
          document.body.style.overflow = 'hidden'
          switchTab(initialTab)
        }

        window.closeSearchModal = window.closeSearchModal || function () {
          const modal = document.getElementById('search-modal')
          if (modal) modal.classList.remove('active')
          document.body.style.overflow = ''
        }

        window.switchTab = window.switchTab || function (tab) {
          document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.tab === tab)
            btn.setAttribute('aria-pressed', btn.dataset.tab === tab ? 'true' : 'false')
          })

          document.querySelectorAll('.search-form').forEach(form => {
            form.classList.toggle('active', form.id === `form-${tab}`)
          })

          updateFooterSubmit()
        }

        const footerSubmitBtn = document.querySelector('.search-modal-footer .submit-button')

        function updateFooterSubmit() {
          if (!footerSubmitBtn) return
          const activeForm = document.querySelector('.search-form.active')
          if (!activeForm) return
          const cityInput = activeForm.querySelector('input[name="city"]')
          const qInput = activeForm.querySelector('input[name="q"]')
          if (cityInput) footerSubmitBtn.disabled = cityInput.value.trim().length < 2
          else if (qInput) footerSubmitBtn.disabled = qInput.value.trim().length < 2
        }

        function initAutocomplete({ input, list, fetchSuggestions, renderItem, onSelect }) {
          if (!input || !list) return

          let debounceTimer = null
          let highlightedIndex = -1
          let items = []
          let isSelecting = false

          const close = () => {
            list.classList.remove('visible')
            list.innerHTML = ''
            highlightedIndex = -1
            items = []
          }

          const setHighlight = (index) => {
            highlightedIndex = index
            list.querySelectorAll('.autocomplete-item').forEach((item, itemIndex) => {
              item.classList.toggle('highlighted', itemIndex === highlightedIndex)
            })
          }

          const select = (index) => {
            const item = items[index]
            if (!item) return
            isSelecting = true
            onSelect(item)
            close()
          }

          input.addEventListener('input', () => {
            clearTimeout(debounceTimer)
            close()

            if (isSelecting) {
              isSelecting = false
              return
            }

            const query = input.value.trim()
            if (query.length < 2) return

            debounceTimer = setTimeout(async () => {
              try {
                items = await fetchSuggestions(query)
              } catch {
                close()
                return
              }

              if (!items.length) {
                close()
                return
              }

              list.innerHTML = items.map((item, index) => `
                <button type="button" class="autocomplete-item" data-index="${index}">
                  ${renderItem(item)}
                </button>
              `).join('')
              list.classList.add('visible')
            }, 250)
          })

          list.addEventListener('mousedown', (event) => {
            const item = event.target.closest('[data-index]')
            if (!item) return
            event.preventDefault()
            select(Number(item.dataset.index))
          })

          input.addEventListener('keydown', (event) => {
            if (!list.classList.contains('visible') || items.length === 0) return

            if (event.key === 'ArrowDown') {
              event.preventDefault()
              setHighlight(Math.min(highlightedIndex + 1, items.length - 1))
            } else if (event.key === 'ArrowUp') {
              event.preventDefault()
              setHighlight(Math.max(highlightedIndex - 1, 0))
            } else if (event.key === 'Enter' && highlightedIndex >= 0) {
              event.preventDefault()
              select(highlightedIndex)
            } else if (event.key === 'Escape') {
              close()
            }
          })

          document.addEventListener('click', (event) => {
            if (!list.contains(event.target) && event.target !== input) close()
          })
        }

        const suggestionCache = new Map()
        const fetchJson = async (url, query) => {
          const key = `${url}:${query.toLowerCase()}`
          if (suggestionCache.has(key)) return suggestionCache.get(key)

          const response = await fetch(`${url}?q=${encodeURIComponent(query)}`)
          if (!response.ok) return []
          const results = await response.json()
          suggestionCache.set(key, results)
          return results
        }

        document.querySelectorAll('.form-group.has-autocomplete input').forEach(input => {
          if (window.autocompleteInstances.has(input)) return

          const group = input.closest('.form-group')
          let dropdown = group.querySelector('.autocomplete-dropdown')
          if (!dropdown) {
            dropdown = document.createElement('div')
            dropdown.className = 'autocomplete-dropdown'
            group.appendChild(dropdown)
          }

          if (group.dataset.cityAutocomplete !== undefined) {
            initAutocomplete({
              input,
              list: dropdown,
              fetchSuggestions: (query) => fetchJson('/api/listings/cities', query),
              renderItem: (result) => `
                <div>
                  <div class="item-name">${escapeHtml(result.name)}</div>
                  ${result.region ? `<div class="item-region">${escapeHtml(result.region)}</div>` : ''}
                </div>
              `,
              onSelect: (result) => {
                input.value = result.name || ''
                if (result.type === 'region' || result.type === 'department') {
                  input.name = 'region'
                } else {
                  input.name = 'city'
                }
                input.dispatchEvent(new Event('input', { bubbles: true }))
              },
            })
            
            input.addEventListener('input', (e) => {
              // Reset to city if user types manually
              if (e.isTrusted) {
                input.name = 'city'
              }
            })
          } else {
            initAutocomplete({
              input,
              list: dropdown,
              fetchSuggestions: (query) => fetchJson(group.dataset.suggestUrl || '/api/listings/suggest', query),
              renderItem: (result) => `
                <div>
                  <div class="item-name">${escapeHtml(result.title || result.name)}</div>
                  <div class="item-region">${escapeHtml(result.owner || result.region || '')}</div>
                </div>
              `,
              onSelect: (result) => {
                if (result.url) {
                  window.location.href = result.url
                  return
                }

                input.value = result.name || result.title || ''
                input.dispatchEvent(new Event('input', { bubbles: true }))
              },
            })
          }

          window.autocompleteInstances.set(input, true)
        })

        document.querySelectorAll('.search-form').forEach(form => {
          const cityInput = form.querySelector('input[name="city"]')
          const qInput = form.querySelector('input[name="q"]')
          const nearbyToggle = form.querySelector('[data-nearby-toggle]')
          const nearbyInput = nearbyToggle?.querySelector('input[name="include_nearby"]')

          if (cityInput && nearbyToggle && nearbyInput) {
            cityInput.addEventListener('input', updateFooterSubmit)
            updateFooterSubmit()
          } else if (qInput) {
            qInput.addEventListener('input', updateFooterSubmit)
            updateFooterSubmit()
          }

          form.addEventListener('submit', (e) => {
            if (footerSubmitBtn?.disabled) e.preventDefault()
          })
        })

        footerSubmitBtn?.addEventListener('click', () => {
          const activeForm = document.querySelector('.search-form.active')
          if (!activeForm || footerSubmitBtn.disabled) return
          activeForm.requestSubmit()
        })

        if (!window.hasGlobalEscListener) {
          document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') window.closeSearchModal()
          })
          window.hasGlobalEscListener = true
        }
      }

      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init)
      } else {
        init()
      }
    })();
  </script>
@endpush
