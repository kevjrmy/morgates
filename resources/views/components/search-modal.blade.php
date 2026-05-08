<div id="search-modal" class="search-modal" aria-hidden="true">
  <div class="search-modal-backdrop" onclick="closeSearchModal()"></div>
  <div class="search-modal-content">
    <div class="search-modal-header">
      <button type="button" class="close-button" onclick="closeSearchModal()" aria-label="Fermer">
        @svg('mdi-close')
      </button>
      <div class="search-tabs">
        <button type="button" class="tab-button active" data-tab="stays" onclick="switchTab('stays')">Séjours</button>
        <button type="button" class="tab-button" data-tab="sailing" onclick="switchTab('sailing')">Sorties en mer</button>
      </div>
    </div>

    <div class="search-modal-body">
      <!-- Stays Form -->
      <form action="{{ route('listings') }}" method="GET" id="form-stays" class="search-form active">
        <input type="hidden" name="type" value="stays">
        <div class="form-group">
          <label for="q-stays">@svg('mdi-magnify') Que recherchez-vous ?</label>
          <input type="text" name="q" id="q-stays" placeholder="Appartement, villa, cabane..." value="{{ request('q') }}">
        </div>
        <div class="form-group">
          <label for="city-stays">@svg('mdi-map-marker-outline') Où ?</label>
          <input type="text" name="city" id="city-stays" placeholder="Ville ou région" value="{{ request('city') }}">
        </div>
        <button type="submit" class="submit-button">Rechercher</button>
      </form>

      <!-- Sailing Form -->
      <form action="{{ route('listings') }}" method="GET" id="form-sailing" class="search-form">
        <input type="hidden" name="type" value="sailing">
        <div class="form-group">
          <label for="q-sailing">@svg('mdi-magnify') Quel type de bateau ?</label>
          <input type="text" name="q" id="q-sailing" placeholder="Voilier, catamaran, yacht..." value="{{ request('q') }}">
        </div>
        <div class="form-group">
          <label for="city-sailing">@svg('mdi-anchor') Port de départ</label>
          <input type="text" name="city" id="city-sailing" placeholder="Ville ou port" value="{{ request('city') }}">
        </div>
        <button type="submit" class="submit-button">Rechercher</button>
      </form>

      <div class="search-modal-footer">
        <a href="{{ route('listings') }}?advanced=1" class="advanced-search-link">Recherche avancée</a>
      </div>
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
  align-items: flex-start;
  justify-content: center;
  padding-top: 5dvh;
}

.search-modal.active {
  display: flex;
}

.search-modal-backdrop {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.3);
  backdrop-filter: blur(12px) saturate(180%);
  -webkit-backdrop-filter: blur(12px) saturate(180%);
}

.search-modal-content {
  position: relative;
  background-color: white;
  width: 94%;
  max-width: 600px;
  border-radius: 32px;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
  overflow: hidden;
  animation: modalSlideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  border: 1px solid rgba(255, 255, 255, 0.3);
}

@keyframes modalSlideIn {
  from { opacity: 0; transform: translateY(40px) scale(0.95); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

.search-modal-header {
  padding: 2rem 2rem 1rem;
  border-bottom: 1px solid #f0f0f0;
  position: relative;
}

.close-button {
  position: absolute;
  top: 1.5rem;
  left: 1.5rem;
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
  transform: rotate(90deg);
}

.search-tabs {
  display: flex;
  justify-content: center;
  background-color: #f5f5f7;
  padding: 0.4rem;
  border-radius: 100px;
  width: fit-content;
  margin: 1.5rem auto 0;
}

.tab-button {
  font-weight: 600;
  color: var(--clr-text-medium);
  padding: 0.6rem 1.5rem;
  border-radius: 100px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  font-size: 0.95rem;
}

.tab-button.active {
  background-color: white;
  color: var(--clr-primary);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.search-modal-body {
  padding: 2rem;
}

.search-form {
  display: none;
  flex-direction: column;
  gap: 1.8rem;
}

.search-form.active {
  display: flex;
  animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateX(10px); }
  to { opacity: 1; transform: translateX(0); }
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.6rem;
}

.form-group label {
  font-size: 0.85rem;
  font-weight: 700;
  color: var(--clr-text-dark);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  display: flex;
  align-items: center;
  gap: 0.6rem;
}

.form-group label svg {
  width: 1.1rem;
  height: 1.1rem;
  color: var(--clr-primary);
}

.form-group input {
  padding: 1rem 1.2rem;
  border: 1.5px solid #eee;
  border-radius: 16px;
  font-size: 1.05rem;
  outline: none;
  transition: all 0.2s;
  background-color: #fafafa;
}

.form-group input:focus {
  border-color: var(--clr-primary);
  background-color: white;
  box-shadow: 0 0 0 4px rgba(0, 68, 170, 0.1);
}

.submit-button {
  background: linear-gradient(135deg, var(--clr-primary), var(--clr-marine));
  color: white;
  padding: 1.1rem;
  border-radius: 16px;
  font-weight: 700;
  font-size: 1.1rem;
  margin-top: 1rem;
  transition: all 0.3s;
  box-shadow: 0 10px 20px -5px rgba(0, 68, 170, 0.4);
}

.submit-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 15px 25px -5px rgba(0, 68, 170, 0.5);
}

.submit-button:active {
  transform: translateY(0);
}

.search-modal-footer {
  margin-top: 2.5rem;
  text-align: center;
}

.advanced-search-link {
  color: var(--clr-text-light);
  font-size: 0.95rem;
  font-weight: 500;
  transition: color 0.2s;
}

.advanced-search-link:hover {
  color: var(--clr-primary);
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
