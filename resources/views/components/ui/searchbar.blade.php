@props([
  'placeholder' => 'Rechercher',
  'value' => null,
  'initialTab' => 'stays',
])

<div class="search-bar-container" {{ $attributes }}>
  <button type="button" class="search-bar-trigger" onclick="openSearchModal()" aria-label="Ouvrir la recherche">
    <span class="search-bar-icon">
      @svg('mdi-magnify', ['color' => 'var(--clr-primary)'])
    </span>
    <span class="search-bar-placeholder">{{ $placeholder }}</span>
  </button>
  <x-ui.search-modal :initial-tab="$initialTab" />
</div>
  
@push('styles')
  <style>
.search-bar-container {
    width: 100%;
  }
  
  .search-bar-trigger {
    display: flex;
    align-items: center;
    justify-content: center;
    column-gap: 1ch;
    border: var(--border);
    border-radius: 120px;
    overflow: hidden;
    box-shadow: var(--box-shadow);
    background-color: white;
    width: 100%;
    padding: 0.6rem 1.2rem;
    text-align: left;
  cursor: pointer;
    transition: box-shadow 0.2s;
 }
   
.search-bar-trigger:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  .s  earch-bar-icon {
    display: flex;
  align-items: center;
    margin-right: 0.8rem;
  }
  
  .search-bar-placeholder {
  font-size: 1rem;
}
</style>
@endpush