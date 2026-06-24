<?php

return [

  'common' => [
    'proche-plage'         => ['icon' => 'beach',          'label' => 'Proche plage',                    'category' => 'emplacement'],
    'vue-panoramique'      => ['icon' => 'viewfinder',     'label' => 'Vue panoramique',                 'category' => 'emplacement'],
    'sans-vis-a-vis'       => ['icon' => 'eye-off',        'label' => 'Sans vis-à-vis',                  'category' => 'emplacement'],
    'proche-restaurants'   => ['icon' => 'chef-hat',       'label' => 'Proche restaurants',              'category' => 'emplacement'],
    'bluetooth-audio'      => ['icon' => 'bluetooth',      'label' => 'Audio Bluetooth',                 'category' => 'equipements'],
    'assurance-incluse'    => ['icon' => 'shield-check',   'label' => 'Assurance incluse',               'category' => 'services'],
    'nettoyage-inclus'     => ['icon' => 'sparkles',       'label' => 'Nettoyage inclus',                'category' => 'services'],
    'linge-fourni'         => ['icon' => 'hanger',         'label' => 'Linge fourni',                    'category' => 'services'],
    'arrivee-flexible'     => ['icon' => 'calendar-time',  'label' => 'Arrivée flexible',                'category' => 'services'],
    'ideal-debutants'      => ['icon' => 'star',           'label' => 'Idéal débutants',                 'category' => 'services'],
    'transfert-disponible' => ['icon' => 'transfer',       'label' => 'Transfert disponible',            'category' => 'services'],
    'chargeur-ve'          => ['icon' => 'charging-pile',  'label' => 'Chargeur véhicule électrique',    'category' => 'services'],
    'animaux-bienvenus'    => ['icon' => 'paw',            'label' => 'Animaux bienvenus',               'category' => 'regles'],
    'caution-requise'      => ['icon' => 'shield',         'label' => 'Caution requise',                 'category' => 'regles'],
    'eco-responsable'      => ['icon' => 'leaf',           'label' => 'Éco-responsable',                 'category' => 'regles'],
  ],

  'stays' => [
    // Emplacement
    'bord-de-mer'      => ['icon' => 'ripple',          'label' => 'Bord de mer',           'category' => 'emplacement'],
    'vue-mer'          => ['icon' => 'binoculars',       'label' => 'Vue mer',               'category' => 'emplacement'],
    'vue-montagne'     => ['icon' => 'mountain',         'label' => 'Vue montagne',          'category' => 'emplacement'],
    'bord-de-lac'      => ['icon' => 'swimming',         'label' => 'Bord de lac',           'category' => 'emplacement'],
    'vue-jardin'       => ['icon' => 'trees',            'label' => 'Vue jardin',            'category' => 'emplacement'],
    'au-calme'         => ['icon' => 'moon',             'label' => 'Au calme',              'category' => 'emplacement'],
    'central'          => ['icon' => 'map-pin',          'label' => 'Central',               'category' => 'emplacement'],
    // Extérieur
    'jardin'           => ['icon' => 'flower',           'label' => 'Jardin',                'category' => 'exterieur'],
    'terrasse'         => ['icon' => 'sun',              'label' => 'Terrasse / Balcon',     'category' => 'exterieur'],
    'piscine'          => ['icon' => 'pool',             'label' => 'Piscine',               'category' => 'exterieur'],
    'piscine-chauffee' => ['icon' => 'temperature-plus', 'label' => 'Piscine chauffée',      'category' => 'exterieur'],
    'jacuzzi'          => ['icon' => 'bath',             'label' => 'Jacuzzi',               'category' => 'exterieur'],
    'sauna'            => ['icon' => 'massage',          'label' => 'Sauna',                 'category' => 'exterieur'],
    'hammam'           => ['icon' => 'wave-sine',        'label' => 'Hammam',                'category' => 'exterieur'],
    'barbecue'         => ['icon' => 'grill',            'label' => 'Barbecue',              'category' => 'exterieur'],
    // Équipements
    'wifi'             => ['icon' => 'wifi',             'label' => 'Wi-Fi',                 'category' => 'equipements'],
    'climatisation'    => ['icon' => 'air-conditioning', 'label' => 'Clim',                  'category' => 'equipements'],
    'chauffage'        => ['icon' => 'flame',            'label' => 'Chauffage',             'category' => 'equipements'],
    'cheminee'         => ['icon' => 'flame',            'label' => 'Cheminée',              'category' => 'equipements'],
    'television'       => ['icon' => 'device-tv',        'label' => 'TV',                    'category' => 'equipements'],
    'home-cinema'      => ['icon' => 'movie',            'label' => 'Home cinéma',           'category' => 'equipements'],
    'cuisine'          => ['icon' => 'cooker',           'label' => 'Cuisine équipée',       'category' => 'equipements'],
    'lave-vaisselle'   => ['icon' => 'tools-kitchen-2',  'label' => 'Lave-vaisselle',        'category' => 'equipements'],
    'micro-ondes'      => ['icon' => 'microwave',        'label' => 'Micro-ondes',           'category' => 'equipements'],
    'cave-a-vin'       => ['icon' => 'bottle',           'label' => 'Cave à vin',            'category' => 'equipements'],
    'lave-linge'       => ['icon' => 'wash-machine',     'label' => 'Lave-linge',            'category' => 'equipements'],
    'espace-travail'   => ['icon' => 'desk',             'label' => 'Espace travail',        'category' => 'equipements'],
    'business'         => ['icon' => 'briefcase',        'label' => 'Équipé business',       'category' => 'equipements'],
    'prise-electrique' => ['icon' => 'bolt',             'label' => 'Prises électriques',    'category' => 'equipements'],
    'lit-bebe'         => ['icon' => 'baby-carriage',    'label' => 'Lit bébé',              'category' => 'equipements'],
    'equipement-bebe'  => ['icon' => 'baby-bottle',      'label' => 'Équipement bébé',       'category' => 'equipements'],
    // Activités
    'salle-sport'      => ['icon' => 'barbell',          'label' => 'Salle de sport',        'category' => 'activites'],
    'velos'            => ['icon' => 'bike',             'label' => 'Vélos disponibles',     'category' => 'activites'],
    // Services
    'parking'          => ['icon' => 'parking',          'label' => 'Parking',               'category' => 'services'],
    'acces-autonome'   => ['icon' => 'door',             'label' => 'Accès autonome',        'category' => 'services'],
    'concierge'        => ['icon' => 'bell',             'label' => 'Conciergerie',          'category' => 'services'],
    'ascenseur'        => ['icon' => 'elevator',         'label' => 'Ascenseur',             'category' => 'services'],
    'alarme'           => ['icon' => 'shield-checkered', 'label' => 'Alarme',                'category' => 'services'],
    'sejours-longs'    => ['icon' => 'bed-flat',         'label' => 'Séjours longs OK',      'category' => 'services'],
    'luxe'             => ['icon' => 'diamond',          'label' => 'Luxe',                  'category' => 'services'],
    // Règles
    'prive'            => ['icon' => 'lock',             'label' => 'Privé',                 'category' => 'regles'],
    'accessible'       => ['icon' => 'wheelchair',       'label' => 'Accessible',            'category' => 'regles'],
    'animaux-acceptes' => ['icon' => 'dog',              'label' => 'Animaux acceptés',      'category' => 'regles'],
    'non-fumeur'       => ['icon' => 'smoking-no',       'label' => 'Non-fumeur',            'category' => 'regles'],
    'famille'          => ['icon' => 'mood-kid',         'label' => 'Idéal famille',         'category' => 'regles'],
  ],

  'boats' => [
    // Type de bateau
    'voilier'            => ['icon' => 'sailboat',        'label' => 'Voilier',               'category' => 'type'],
    'catamaran'          => ['icon' => 'sailboat-2',      'label' => 'Catamaran',             'category' => 'type'],
    'moteur'             => ['icon' => 'engine',          'label' => 'À moteur',              'category' => 'type'],
    'semi-rigide'        => ['icon' => 'speedboat',       'label' => 'Semi-rigide',           'category' => 'type'],
    'electrique-bord'    => ['icon' => 'bolt',            'label' => 'Électrique',            'category' => 'type'],
    // Emplacement
    'port'               => ['icon' => 'ship',            'label' => 'Au port',               'category' => 'emplacement'],
    // Navigation
    'gps'                => ['icon' => 'gps',             'label' => 'GPS',                   'category' => 'navigation'],
    'pilote-automatique' => ['icon' => 'steering-wheel',  'label' => 'Pilote auto',           'category' => 'navigation'],
    'vhf'                => ['icon' => 'antenna-bars-5',  'label' => 'VHF',                   'category' => 'navigation'],
    'radar'              => ['icon' => 'radar',           'label' => 'Radar',                 'category' => 'navigation'],
    'sondeur'            => ['icon' => 'radar-2',         'label' => 'Sondeur',               'category' => 'navigation'],
    // À bord
    'coucher'            => ['icon' => 'bed',             'label' => 'Couchages',             'category' => 'a-bord'],
    'cuisine-bord'       => ['icon' => 'tools-kitchen',   'label' => 'Cuisine à bord',        'category' => 'a-bord'],
    'wc-bord'            => ['icon' => 'toilet-paper',    'label' => 'WC à bord',             'category' => 'a-bord'],
    'refrigerateur-bord' => ['icon' => 'fridge',          'label' => 'Réfrigérateur',         'category' => 'a-bord'],
    'douche-pont'        => ['icon' => 'droplets',        'label' => 'Douche pont',           'category' => 'a-bord'],
    'bimini'             => ['icon' => 'umbrella',        'label' => 'Bimini / Ombrage',      'category' => 'a-bord'],
    'climatisation-bord' => ['icon' => 'air-conditioning','label' => 'Climatisation à bord',  'category' => 'a-bord'],
    // Équipements
    'annexe'             => ['icon' => 'lifebuoy',        'label' => 'Annexe',                'category' => 'equipements'],
    'panneaux-solaires'  => ['icon' => 'solar-panel',     'label' => 'Solaire',               'category' => 'equipements'],
    // Activités
    'ile'                => ['icon' => 'map',             'label' => 'Vers îles / côtes',     'category' => 'activites'],
    'peche'              => ['icon' => 'fish',            'label' => 'Pêche',                 'category' => 'activites'],
    'plaisir'            => ['icon' => 'ship',            'label' => 'Plaisir / balade',      'category' => 'activites'],
    'jet-ski'            => ['icon' => 'speedboat',       'label' => 'Jet-ski',               'category' => 'activites'],
    'paddle'             => ['icon' => 'ripple',          'label' => 'Paddle',                'category' => 'activites'],
    'kayak'              => ['icon' => 'kayak',           'label' => 'Kayak',                 'category' => 'activites'],
    'plongee'            => ['icon' => 'scuba-mask',      'label' => 'Plongée',               'category' => 'activites'],
    // Services
    'skipper'            => ['icon' => 'user-star',       'label' => 'Avec skipper',          'category' => 'services'],
    'sans-skipper'       => ['icon' => 'anchor',          'label' => 'Sans skipper',          'category' => 'services'],
    'equipage'           => ['icon' => 'users',           'label' => 'Avec équipage',         'category' => 'services'],
    'formation-incluse'  => ['icon' => 'school',          'label' => 'Formation incluse',     'category' => 'services'],
    'nuit-a-bord'        => ['icon' => 'stars',           'label' => 'Nuit à bord autorisée', 'category' => 'services'],
    'plein-carburant'    => ['icon' => 'gas-station',     'label' => 'Plein carburant inclus','category' => 'services'],
    'week-end'           => ['icon' => 'calendar-check',  'label' => 'Week-end',              'category' => 'services'],
  ],

];
