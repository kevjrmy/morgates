@php
  $destinations = [
    [
      'city' => 'Nice',
      'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/62/Nice_from_Castle_Hill_01.jpg/960px-Nice_from_Castle_Hill_01.jpg',
      'count' => \App\Models\Listing::where('is_active', true)->where('city', 'Nice')->count(),
    ],
    [
      'city' => 'Paris',
      'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4b/La_Tour_Eiffel_vue_de_la_Tour_Saint-Jacques%2C_Paris_ao%C3%BBt_2014_%282%29.jpg/960px-La_Tour_Eiffel_vue_de_la_Tour_Saint-Jacques%2C_Paris_ao%C3%BBt_2014_%282%29.jpg',
      'count' => \App\Models\Listing::where('is_active', true)->where('city', 'Paris')->count(),
    ],
    [
      'city' => 'Marseille',
      'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/1024_Cath%C3%A9drale_Notre-Dame-de-la-Major_in_Marseille_Photo_by_Giles_Laurent.jpg/960px-1024_Cath%C3%A9drale_Notre-Dame-de-la-Major_in_Marseille_Photo_by_Giles_Laurent.jpg',
      'count' => \App\Models\Listing::where('is_active', true)->where('city', 'Marseille')->count(),
    ],
    [
      'city' => 'Bordeaux',
      'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Bordeaux_Place_de_la_Bourse_de_nuit.jpg/960px-Bordeaux_Place_de_la_Bourse_de_nuit.jpg',
      'count' => \App\Models\Listing::where('is_active', true)->where('city', 'Bordeaux')->count(),
    ],
    [
      'city' => 'Bretagne',
      'photo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f8/Ch%C3%A2teau_Suscinio.jpg/960px-Ch%C3%A2teau_Suscinio.jpg',
      'count' => \App\Models\Listing::where('is_active', true)->where('region', 'Bretagne')->count(),
    ],
  ];
@endphp

<section id="destinations">
  <h2>Suggestions de destinations</h2>
  <div class="destinations-grid">
    @foreach($destinations as $destination)
      @php
        $params = $destination['city'] === 'Bretagne' ? ['region' => 'Bretagne'] : ['city' => $destination['city']];
      @endphp
      <a href="{{ route('listings', $params) }}" class="destination-card">
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
      padding: 0 1.25rem;
    }

    .destinations-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.625rem;
    }

    .destination-card {
      position: relative;
      border-radius: 0.875rem;
      overflow: hidden;
      aspect-ratio: 1 / 1;
      cursor: pointer;
    }

    .destination-card:first-child {
      grid-column: 1 / -1;
      aspect-ratio: 16 / 9;
    }

    .destination-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .destination-card:hover img {
      transform: scale(1.04);
    }

    .destination-card-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.52) 0%, transparent 55%);
    }

    .destination-card-label {
      position: absolute;
      bottom: 0.875rem;
      left: 0.875rem;
      color: #fff;
      font-weight: 600;
      font-size: 0.95rem;
      text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    }

    .destination-card:first-child .destination-card-label {
      font-size: 1.1rem;
    }

    .destination-card-count {
      display: block;
      font-size: 0.72rem;
      font-weight: 400;
      opacity: 0.85;
      margin-top: 0.125rem;
    }
  </style>
@endpush