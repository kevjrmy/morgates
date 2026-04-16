@php
  $tags = [
    ['label' => 'Bord de mer', 'icon' => 'mdi-waves', 'query' => 'bord-de-mer'],
    ['label' => 'Piscine', 'icon' => 'mdi-pool', 'query' => 'piscine'],
    ['label' => 'Vue montagne', 'icon' => 'mdi-image-filter-hdr', 'query' => 'vue-montagne'],
    ['label' => 'Climatisation', 'icon' => 'mdi-air-conditioner', 'query' => 'climatisation'],
    ['label' => 'Animaux', 'icon' => 'mdi-paw', 'query' => 'animaux'],
    ['label' => 'Wifi', 'icon' => 'mdi-wifi', 'query' => 'wifi'],
    ['label' => 'Parking', 'icon' => 'mdi-parking', 'query' => 'parking'],
    ['label' => 'Terrasse', 'icon' => 'mdi-table-furniture', 'query' => 'terrasse'],
    ['label' => 'Barbecue', 'icon' => 'mdi-grill', 'query' => 'barbecue'],
    ['label' => 'Jacuzzi', 'icon' => 'mdi-hot-tub', 'query' => 'jacuzzi'],
    ['label' => 'Calme', 'icon' => 'mdi-leaf', 'query' => 'calme'],
    ['label' => 'Centre-ville', 'icon' => 'mdi-city', 'query' => 'centre-ville'],
    ['label' => 'Famille', 'icon' => 'mdi-human-male-female-child', 'query' => 'famille'],
    ['label' => 'Coup de cœur', 'icon' => 'mdi-heart', 'query' => 'coup-de-coeur'],
    ['label' => 'Nouveauté', 'icon' => 'mdi-star', 'query' => 'nouveaute'],
  ];
@endphp

<section class="tags-section">
  <h2>Spécificités</h2>
  <div class="tags-scroll">
    @foreach($tags as $tag)
      <a href="{{ route('listings', ['tag' => $tag['query']]) }}" class="tag">
        @svg($tag['icon'])
        {{ $tag['label'] }}
      </a>
    @endforeach
  </div>
</section>

@push('styles')
  <style>
    .tags-section {
      padding: 1rem;
      text-align: center;
    }

    .tags-scroll {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      justify-content: center;
    }

    .tag {
      box-shadow: var(--box-shadow);
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.4rem 0.85rem;
      border-radius: 120px;
      font-size: 0.85rem;
      color: var(--clr-text-medium);
      transition: background-color 0.2s ease, color 0.2s ease;
    }

    .tag:hover {
      background-color: var(--clr-primary);
      color: #fff;
    }

    .tag:hover {
      background-color: var(--clr-primary);
      color: #fff;
    }
  </style>
@endpush