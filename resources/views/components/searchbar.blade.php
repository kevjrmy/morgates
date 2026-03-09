@props([
  'placeholder' => 'Explorer...',
  'value' => null
])

<form action="{{ route('search') }}" method="GET" role="search" {{ $attributes->merge(['class' => 'search-bar']) }}>
  <button type="submit" aria-label="Submit search">
    @svg('mdi-magnify', ['color' => 'var(--clr-primary)'])
  </button>
  <input type="search" name="q" placeholder="{{ $placeholder }}" value="{{ $value ?? request('q') }}"
    aria-label="Search">
</form>

@push('styles')
<style>
.search-bar {
  display: flex;
  align-items: center;
  border: var(--border);
  border-radius: 120px;
  overflow: hidden;
  box-shadow: var(--box-shadow);
  background-color: white;
  width: 100%;
}

.search-bar input {
  flex: 1;
  border: none;
  outline: none;
  padding: 0.6rem 1.2rem;
  background: transparent;
  color: var(--color-text);
  font-size: 1rem;
}

.search-bar button {
  padding: 0.6rem 1.2rem;
  display: flex;
  align-items: center;
}
</style>
@endpush