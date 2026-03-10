@php
  $destinations = [
    [
      'city' => 'Nice',
      'count' => 12,
      'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/62/Nice_from_Castle_Hill_01.jpg/960px-Nice_from_Castle_Hill_01.jpg',
      'type' => null,
    ],
    [
      'city' => 'Paris',
      'count' => 24,
      'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/La_Tour_Eiffel_vue_de_la_Tour_Saint-Jacques%2C_Paris_ao%C3%BBt_2014_%282%29.jpg/960px-La_Tour_Eiffel_vue_de_la_Tour_Saint-Jacques%2C_Paris_ao%C3%BBt_2014_%282%29.jpg',
      'type' => null,
    ],
    [
      'city' => 'Marseille',
      'count' => 8,
      'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/1024_Cath%C3%A9drale_Notre-Dame-de-la-Major_in_Marseille_Photo_by_Giles_Laurent.jpg/960px-1024_Cath%C3%A9drale_Notre-Dame-de-la-Major_in_Marseille_Photo_by_Giles_Laurent.jpg',
      'type' => null,
    ],
    [
      'city' => 'Bordeaux',
      'count' => 6,
      'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Bordeaux_Place_de_la_Bourse_de_nuit.jpg/960px-Bordeaux_Place_de_la_Bourse_de_nuit.jpg',
      'type' => null,
    ],
    [
      'city' => 'Bretagne',
      'count' => 5,
      'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f8/Ch%C3%A2teau_Suscinio.jpg/960px-Ch%C3%A2teau_Suscinio.jpg',
      'type' => null,
    ],
  ];
@endphp

<section id="destinations">
  <h2>Destinations tendance</h2>
  <div class="destinations-grid">
    @foreach($destinations as $destination)
      <a href="{{ route('search', ['city' => $destination['city']]) }}" class="destination-card">
        <img src="{{ $destination['photo'] }}" alt="{{ $destination['city'] }}" loading="lazy">
        <div class="destination-card-overlay"></div>
        <div class="destination-card-label">
          {{ $destination['city'] }}
          <span class="destination-card-count">
            {{ $destination['count'] }} {{ Str::plural('location', $destination['count']) }}
          </span>
        </div>
      </a>
    @endforeach
  </div>
</section>

@push('styles')
  <style>
    #destinations {
      padding: 0 1rem;
    }

    .destinations-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-rows: auto;
      gap: 0.75rem;
    }

    .destination-card {
      position: relative;
      border-radius: 1rem;
      overflow: hidden;
      aspect-ratio: 1 / 1;
      cursor: pointer;
    }

    /* First card spans full width */
    .destination-card:first-child {
      grid-column: 1 / -1;
      aspect-ratio: 16 / 9;
    }

    .destination-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .destination-card:hover img {
      transform: scale(1.05);
    }

    .destination-card-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.55) 0%, transparent 60%);
      transition: opacity 0.3s ease;
    }

    .destination-card:hover .destination-card-overlay {
      opacity: 0.8;
    }

    .destination-card-label {
      position: absolute;
      bottom: 0.85rem;
      left: 0.85rem;
      color: #fff;
      font-weight: 600;
      font-size: 1rem;
      text-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
    }

    .destination-card:first-child .destination-card-label {
      font-size: 1.2rem;
    }

    .destination-card-count {
      display: block;
      font-size: 0.75rem;
      font-weight: 400;
      opacity: 0.85;
      margin-top: 0.1rem;
    }
  </style>
@endpush