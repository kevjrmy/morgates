{{--
  listings/create/step-4-details.blade.php
  Step 4: Equipment & characteristics (tags)
--}}
@extends('layouts.listing-create')

@section('title', 'Détails - Publier une annonce')

@section('content')
  <div class="lc-step">
    <div class="lc-step-header">
      <h1 class="lc-title">Équipements & caractéristiques</h1>
      <p class="lc-subtitle">Cochez ce qui correspond à votre bien : les voyageurs s'en servent pour filtrer leurs recherches.</p>
    </div>

    <form action="{{ route('listings.create.details') }}" method="POST" class="lc-form">
      @csrf

      @php
        $listingType   = $listing->type ?? 'stays';
        $availableTags = array_merge(config('tags.common', []), config('tags.' . $listingType, []));
        $selectedTags  = old('tags', $listing->tags ?? []);

        $categoryOrder = [
          'type'        => 'Type de bateau',
          'emplacement' => 'Emplacement',
          'exterieur'   => 'Extérieur',
          'navigation'  => 'Navigation',
          'a-bord'      => 'À bord',
          'equipements' => 'Équipements',
          'activites'   => 'Activités',
          'services'    => 'Services',
          'regles'      => 'Règles',
        ];

        $grouped = [];
        foreach ($availableTags as $slug => $tag) {
          $grouped[$tag['category']][$slug] = $tag;
        }
      @endphp

      <div class="lc-tag-groups">
        @foreach($categoryOrder as $catKey => $catLabel)
          @if(isset($grouped[$catKey]))
            <div class="lc-tag-group">
              <h2 class="lc-tag-group-title">{{ $catLabel }}</h2>
              <div class="lc-tags">
                @foreach($grouped[$catKey] as $slug => $tag)
                  <label class="lc-tag {{ in_array($slug, $selectedTags) ? 'selected' : '' }}">
                    <input type="checkbox" name="tags[]" value="{{ $slug }}" {{ in_array($slug, $selectedTags) ? 'checked' : '' }}>
                    @svg('tabler-' . $tag['icon'])
                    {{ $tag['label'] }}
                  </label>
                @endforeach
              </div>
            </div>
          @endif
        @endforeach
      </div>

      <div class="lc-actions">
        <a href="{{ route('listings.create.index', ['step' => 3]) }}" class="lc-btn-back">@svg('tabler-arrow-left') Retour</a>
        <button type="submit" class="lc-btn-next">Continuer</button>
      </div>
    </form>
  </div>
@endsection

@push('styles')
  <style>
    .lc-tag-groups {
      display: flex;
      flex-direction: column;
      gap: 1.75rem;
    }

    .lc-tag-group-title {
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.07em;
      color: var(--clr-text-light);
      margin-bottom: 0.65rem;
    }

    .lc-tag {
      gap: 0.35rem;
    }

    .lc-tag svg {
      width: 1rem;
      height: 1rem;
      flex-shrink: 0;
    }
  </style>
@endpush

@push('scripts')
  <script>
    document.querySelectorAll('.lc-tag input[type="checkbox"]').forEach(cb => {
      cb.addEventListener('change', () => {
        cb.closest('.lc-tag').classList.toggle('selected', cb.checked)
      })
    })
  </script>
@endpush
