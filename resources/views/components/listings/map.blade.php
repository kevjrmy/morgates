@if($listing->location_display && $listing->latitude && $listing->longitude)
  <section class="listing-location">
    <h2>
      @if($listing->location_display === 'exact')
        Localisation exacte
      @else
        Localisation approximative
      @endif
    </h2>
    <div id="listing-map" data-lat="{{ $listing->latitude }}" data-lng="{{ $listing->longitude }}"
      data-display="{{ $listing->location_display }}" data-radius="{{ $listing->location_radius ?? 2000 }}"></div>
  </section>

  @push('styles')
    <style>
      .listing-location {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
      }

      .listing-location h2 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
      }

      #listing-map {
        height: 250px;
        width: 100%;
        border-radius: 0.75rem;
        overflow: hidden;
        display: block;
      }

      #listing-map .leaflet-container {
        height: 100%;
        width: 100%;
        display: block;
      }

      .leaflet-bottom.leaflet-right {
        display: none;
      }

      .custom-pin {
        width: 32px;
        height: 42px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
      }
    </style>
  @endpush

  @push('scripts')
    <script>
      if (!window.L) {
        var script = document.createElement('script');
        script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
        script.crossOrigin = '';
        script.onload = initMap;
        document.head.appendChild(script);
      } else {
        initMap();
      }

      function initMap() {
        const mapEl = document.getElementById('listing-map')
        if (mapEl) {
          const lat = parseFloat(mapEl.dataset.lat)
          const lng = parseFloat(mapEl.dataset.lng)
          const display = mapEl.dataset.display
          const radius = parseInt(mapEl.dataset.radius) || 2000

          try {
            const map = L.map('listing-map', { scrollWheelZoom: false }).setView([lat, lng], 13)
            map.invalidateSize()

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
              attribution: ''
            }).addTo(map)

            const customIcon = L.divIcon({
              className: '',
              html: `<svg class="custom-pin" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="#0044aa"/>
                    <circle cx="12" cy="9" r="2.5" fill="white"/>
                  </svg>`,
              iconSize: [24, 28],
              iconAnchor: [12, 28],
              popupAnchor: [0, -28]
            })

            if (display === 'exact') {
              L.marker([lat, lng], { icon: customIcon }).addTo(map)
            }
          } catch (e) {
            console.error('Map error:', e)
          }
        }
      }
    </script>
  @endpush
@endif