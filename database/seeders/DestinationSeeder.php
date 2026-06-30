<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
  public function run(): void
  {
    $destinations = [
      ['name' => 'Cannes',                 'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.5528, 'longitude' => 7.0174],
      ['name' => 'Antibes',                'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.5804, 'longitude' => 7.1252],
      ['name' => 'Mandelieu-la-Napoule',   'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.5334, 'longitude' => 6.9180],
      ['name' => 'Marseille',              'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.2965, 'longitude' => 5.3698],
      ['name' => 'Quiberon',               'type' => 'city', 'region' => 'Bretagne',                    'country' => 'FR', 'latitude' => 47.4820, 'longitude' => -3.1197],
      ['name' => 'Rennes',                 'type' => 'city', 'region' => 'Bretagne',                    'country' => 'FR', 'latitude' => 48.1173, 'longitude' => -1.6778],
      ['name' => 'Vannes',                 'type' => 'city', 'region' => 'Bretagne',                    'country' => 'FR', 'latitude' => 47.6559, 'longitude' => -2.7603],
      ['name' => 'Annecy',                 'type' => 'city', 'region' => 'Auvergne-Rhône-Alpes',        'country' => 'FR', 'latitude' => 45.8992, 'longitude' => 6.1294],
      ['name' => 'Chamonix',               'type' => 'city', 'region' => 'Auvergne-Rhône-Alpes',        'country' => 'FR', 'latitude' => 45.9237, 'longitude' => 6.8694],
    ];

    foreach ($destinations as $destination) {
      Destination::firstOrCreate(
        ['name' => $destination['name'], 'country' => $destination['country']],
        $destination
      );
    }
  }
}
