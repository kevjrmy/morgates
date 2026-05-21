<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationsSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Brittany - regions
            ['name' => 'Bretagne', 'type' => 'region', 'region' => 'Bretagne', 'country' => 'FR'],
            ['name' => 'Côte d\'Émeraude', 'type' => 'region', 'region' => 'Bretagne', 'country' => 'FR'],
            ['name' => 'Golfe du Morbihan', 'type' => 'region', 'region' => 'Bretagne', 'country' => 'FR'],
            ['name' => 'Presqu\'île de Crozon', 'type' => 'region', 'region' => 'Bretagne', 'country' => 'FR'],
            ['name' => 'Baie de Quiberon', 'type' => 'region', 'region' => 'Bretagne', 'country' => 'FR'],
            ['name' => 'Paimpolais', 'type' => 'region', 'region' => 'Bretagne', 'country' => 'FR'],
            ['name' => 'Léon', 'type' => 'region', 'region' => 'Bretagne', 'country' => 'FR'],
            ['name' => 'Trégor', 'type' => 'region', 'region' => 'Bretagne', 'country' => 'FR'],
            ['name' => 'Pays de Fougères', 'type' => 'region', 'region' => 'Bretagne', 'country' => 'FR'],
            ['name' => 'Pays de Vitré', 'type' => 'region', 'region' => 'Bretagne', 'country' => 'FR'],
            ['name' => 'Pays de Redon', 'type' => 'region', 'region' => 'Bretagne', 'country' => 'FR'],
            ['name' => 'Centre Bretagne', 'type' => 'region', 'region' => 'Bretagne', 'country' => 'FR'],

            // Brittany - cities
            ['name' => 'Brest', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.3904, 'longitude' => -4.4861],
            ['name' => 'Rennes', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.1173, 'longitude' => -1.6779],
            ['name' => 'Quimper', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 47.9977, 'longitude' => -4.1022],
            ['name' => 'Saint-Malo', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.6497, 'longitude' => -2.0257],
            ['name' => 'Lorient', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 47.7478, 'longitude' => -3.3699],
            ['name' => 'Vannes', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 47.6585, 'longitude' => -2.7610],
            ['name' => 'Concarneau', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 47.8758, 'longitude' => -3.9130],
            ['name' => 'Dinard', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.6348, 'longitude' => -2.0615],
            ['name' => 'Morlaix', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.5774, 'longitude' => -3.8310],
            ['name' => 'Lannion', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.7318, 'longitude' => -3.4522],
            ['name' => 'Fouesnant', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 47.8997, 'longitude' => -4.0061],
            ['name' => 'Auray', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 47.6688, 'longitude' => -2.9955],
            ['name' => 'Pont-Aven', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 47.8232, 'longitude' => -3.7495],
            ['name' => 'Cancale', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.7174, 'longitude' => -1.8551],
            ['name' => 'Paimpol', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.7782, 'longitude' => -3.0452],
            ['name' => 'Douarnenez', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.0947, 'longitude' => -4.3312],
            ['name' => 'Bénodet', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 47.8738, 'longitude' => -4.1058],
            ['name' => 'Crozon', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.2449, 'longitude' => -4.2884],
            ['name' => 'Camaret-sur-Mer', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.2743, 'longitude' => -4.5968],
            ['name' => 'Perros-Guirec', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.8146, 'longitude' => -3.4416],
            ['name' => 'Quiberon', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 47.5841, 'longitude' => -3.0882],
            ['name' => 'Belle-Île-en-Mer', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 47.3287, 'longitude' => -3.1898],
            ['name' => 'Guimiliau', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.4657, 'longitude' => -3.9382],
            ['name' => 'Saint-Pol-de-Léon', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.6726, 'longitude' => -3.9868],
            ['name' => 'Roscoff', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.7259, 'longitude' => -3.9835],
            ['name' => 'Plougonven', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.5892, 'longitude' => -3.7283],
            ['name' => 'Carantec', 'type' => 'city', 'region' => 'Bretagne', 'country' => 'FR', 'latitude' => 48.6605, 'longitude' => -3.8231],

            // Vendée / Loire Valley
            ['name' => 'La Baule-Escoublac', 'type' => 'city', 'region' => 'Pays de la Loire', 'country' => 'FR', 'latitude' => 47.3265, 'longitude' => -2.3920],
            ['name' => 'Noirmoutier-en-l\'Île', 'type' => 'city', 'region' => 'Pays de la Loire', 'country' => 'FR', 'latitude' => 46.9832, 'longitude' => -2.2441],
            ['name' => 'Sainte-Marie-de-Ré', 'type' => 'city', 'region' => 'Nouvelle-Aquitaine', 'country' => 'FR', 'latitude' => 46.1376, 'longitude' => -1.2993],
            ['name' => 'Les Sables-d\'Olonne', 'type' => 'city', 'region' => 'Pays de la Loire', 'country' => 'FR', 'latitude' => 46.5000, 'longitude' => -1.7833],
            ['name' => 'Saint-Jean-de-Monts', 'type' => 'city', 'region' => 'Pays de la Loire', 'country' => 'FR', 'latitude' => 46.7833, 'longitude' => -2.0500],
            ['name' => 'Pornic', 'type' => 'city', 'region' => 'Pays de la Loire', 'country' => 'FR', 'latitude' => 47.0159, 'longitude' => -1.9460],
            ['name' => 'Île de Ré', 'type' => 'region', 'region' => 'Nouvelle-Aquitaine', 'country' => 'FR'],
            ['name' => 'Oléron', 'type' => 'region', 'region' => 'Nouvelle-Aquitaine', 'country' => 'FR'],
            ['name' => 'Noirmoutier', 'type' => 'region', 'region' => 'Pays de la Loire', 'country' => 'FR'],

            // Normandie
            ['name' => 'Deauville', 'type' => 'city', 'region' => 'Normandie', 'country' => 'FR', 'latitude' => 49.3545, 'longitude' => 0.0187],
            ['name' => 'Caen', 'type' => 'city', 'region' => 'Normandie', 'country' => 'FR', 'latitude' => 49.1829, 'longitude' => -0.3707],
            ['name' => 'Honfleur', 'type' => 'city', 'region' => 'Normandie', 'country' => 'FR', 'latitude' => 49.4197, 'longitude' => 0.2327],
            ['name' => 'Le Havre', 'type' => 'city', 'region' => 'Normandie', 'country' => 'FR', 'latitude' => 49.4944, 'longitude' => 0.1079],
            ['name' => 'Rouen', 'type' => 'city', 'region' => 'Normandie', 'country' => 'FR', 'latitude' => 49.4432, 'longitude' => 1.0990],
            ['name' => 'Bayeux', 'type' => 'city', 'region' => 'Normandie', 'country' => 'FR', 'latitude' => 49.2752, 'longitude' => -0.7012],
            ['name' => 'Mont-Saint-Michel', 'type' => 'city', 'region' => 'Normandie', 'country' => 'FR', 'latitude' => 48.6360, 'longitude' => -1.5114],
            ['name' => 'Cherbourg-en-Cotentin', 'type' => 'city', 'region' => 'Normandie', 'country' => 'FR', 'latitude' => 49.6377, 'longitude' => -1.6236],
            ['name' => 'Cabourg', 'type' => 'city', 'region' => 'Normandie', 'country' => 'FR', 'latitude' => 49.2951, 'longitude' => -0.1180],
            ['name' => 'Trouville-sur-Mer', 'type' => 'city', 'region' => 'Normandie', 'country' => 'FR', 'latitude' => 49.3656, 'longitude' => 0.0795],

            // Pays de la Loire
            ['name' => 'Nantes', 'type' => 'city', 'region' => 'Pays de la Loire', 'country' => 'FR', 'latitude' => 47.2186, 'longitude' => -1.5541],
            ['name' => 'Saint-Nazaire', 'type' => 'city', 'region' => 'Pays de la Loire', 'country' => 'FR', 'latitude' => 47.2641, 'longitude' => -2.3624],
            ['name' => 'Angers', 'type' => 'city', 'region' => 'Pays de la Loire', 'country' => 'FR', 'latitude' => 47.4784, 'longitude' => -0.5636],
            ['name' => 'Le Mans', 'type' => 'city', 'region' => 'Pays de la Loire', 'country' => 'FR', 'latitude' => 47.9960, 'longitude' => 0.1970],

            // Nouvelle-Aquitaine
            ['name' => 'Bordeaux', 'type' => 'city', 'region' => 'Nouvelle-Aquitaine', 'country' => 'FR', 'latitude' => 44.8378, 'longitude' => -0.5792],
            ['name' => 'Biarritz', 'type' => 'city', 'region' => 'Nouvelle-Aquitaine', 'country' => 'FR', 'latitude' => 43.4832, 'longitude' => -1.5586],
            ['name' => 'Arcachon', 'type' => 'city', 'region' => 'Nouvelle-Aquitaine', 'country' => 'FR', 'latitude' => 44.6618, 'longitude' => -1.1509],
            ['name' => 'Royan', 'type' => 'city', 'region' => 'Nouvelle-Aquitaine', 'country' => 'FR', 'latitude' => 45.6232, 'longitude' => -0.9797],
            ['name' => 'Limoges', 'type' => 'city', 'region' => 'Nouvelle-Aquitaine', 'country' => 'FR', 'latitude' => 45.8354, 'longitude' => 1.2646],
            ['name' => 'Poitiers', 'type' => 'city', 'region' => 'Nouvelle-Aquitaine', 'country' => 'FR', 'latitude' => 46.5820, 'longitude' => 0.3406],
            ['name' => 'La Rochelle', 'type' => 'city', 'region' => 'Nouvelle-Aquitaine', 'country' => 'FR', 'latitude' => 46.1607, 'longitude' => -1.1511],
            ['name' => 'Îles Charentes', 'type' => 'region', 'region' => 'Nouvelle-Aquitaine', 'country' => 'FR'],
            ['name' => 'Côte Atlantique', 'type' => 'region', 'region' => 'Nouvelle-Aquitaine', 'country' => 'FR'],
            ['name' => 'Périgord', 'type' => 'region', 'region' => 'Nouvelle-Aquitaine', 'country' => 'FR'],

            // Occitanie
            ['name' => 'Toulouse', 'type' => 'city', 'region' => 'Occitanie', 'country' => 'FR', 'latitude' => 43.6043, 'longitude' => 1.4429],
            ['name' => 'Montpellier', 'type' => 'city', 'region' => 'Occitanie', 'country' => 'FR', 'latitude' => 43.6118, 'longitude' => 3.8767],
            ['name' => 'Perpignan', 'type' => 'city', 'region' => 'Occitanie', 'country' => 'FR', 'latitude' => 42.6887, 'longitude' => 2.8947],
            ['name' => 'Nîmes', 'type' => 'city', 'region' => 'Occitanie', 'country' => 'FR', 'latitude' => 43.8382, 'longitude' => 4.3601],
            ['name' => 'Carcassonne', 'type' => 'city', 'region' => 'Occitanie', 'country' => 'FR', 'latitude' => 43.1829, 'longitude' => 2.3521],
            ['name' => ' Cévennes', 'type' => 'region', 'region' => 'Occitanie', 'country' => 'FR'],

            // Provence-Alpes-Côte d'Azur
            ['name' => 'Marseille', 'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.2965, 'longitude' => 5.3698],
            ['name' => 'Nice', 'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.7102, 'longitude' => 7.2620],
            ['name' => 'Antibes', 'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.5808, 'longitude' => 7.1237],
            ['name' => 'Cannes', 'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.5528, 'longitude' => 7.0174],
            ['name' => 'Mandelieu-la-Napoule', 'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.5464, 'longitude' => 6.9399],
            ['name' => 'Avignon', 'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.9493, 'longitude' => 4.8050],
            ['name' => 'Aix-en-Provence', 'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.5297, 'longitude' => 5.4474],
            ['name' => 'Saint-Tropez', 'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.2728, 'longitude' => 6.6407],
            ['name' => 'Hyères', 'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.1237, 'longitude' => 6.1283],
            ['name' => 'Cassis', 'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.2167, 'longitude' => 5.5500],
            ['name' => 'Bandol', 'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 43.1369, 'longitude' => 5.7573],
            ['name' => 'Grignan', 'type' => 'city', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR', 'latitude' => 44.4111, 'longitude' => 4.7711],
            ['name' => 'Côte d\'Azur', 'type' => 'region', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR'],
            ['name' => 'Alpes-de-Haute-Provence', 'type' => 'region', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR'],
            ['name' => 'Luberon', 'type' => 'region', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR'],
            ['name' => 'Camargue', 'type' => 'region', 'region' => 'Provence-Alpes-Côte d\'Azur', 'country' => 'FR'],

            // Auvergne-Rhône-Alpes
            ['name' => 'Lyon', 'type' => 'city', 'region' => 'Auvergne-Rhône-Alpes', 'country' => 'FR', 'latitude' => 45.7640, 'longitude' => 4.8357],
            ['name' => 'Annecy', 'type' => 'city', 'region' => 'Auvergne-Rhône-Alpes', 'country' => 'FR', 'latitude' => 45.8992, 'longitude' => 6.1287],
            ['name' => 'Grenoble', 'type' => 'city', 'region' => 'Auvergne-Rhône-Alpes', 'country' => 'FR', 'latitude' => 45.1876, 'longitude' => 5.7355],
            ['name' => 'Clermont-Ferrand', 'type' => 'city', 'region' => 'Auvergne-Rhône-Alpes', 'country' => 'FR', 'latitude' => 45.7772, 'longitude' => 3.0826],
            ['name' => 'Saint-Étienne', 'type' => 'city', 'region' => 'Auvergne-Rhône-Alpes', 'country' => 'FR', 'latitude' => 45.4404, 'longitude' => 4.3872],
            ['name' => 'Valence', 'type' => 'city', 'region' => 'Auvergne-Rhône-Alpes', 'country' => 'FR', 'latitude' => 44.9332, 'longitude' => 4.8917],
            ['name' => 'Chamonix-Mont-Blanc', 'type' => 'city', 'region' => 'Auvergne-Rhône-Alpes', 'country' => 'FR', 'latitude' => 45.9237, 'longitude' => 6.8694],
            ['name' => 'Vichy', 'type' => 'city', 'region' => 'Auvergne-Rhône-Alpes', 'country' => 'FR', 'latitude' => 46.1250, 'longitude' => 3.4269],
            ['name' => 'Mont Drome', 'type' => 'region', 'region' => 'Auvergne-Rhône-Alpes', 'country' => 'FR'],

            // Île-de-France
            ['name' => 'Paris', 'type' => 'city', 'region' => 'Île-de-France', 'country' => 'FR', 'latitude' => 48.8566, 'longitude' => 2.3522],
            ['name' => 'Versailles', 'type' => 'city', 'region' => 'Île-de-France', 'country' => 'FR', 'latitude' => 48.8014, 'longitude' => 2.1301],
            ['name' => 'Disneyland Paris', 'type' => 'city', 'region' => 'Île-de-France', 'country' => 'FR', 'latitude' => 48.8674, 'longitude' => 2.7836],
            ['name' => 'Fontainebleau', 'type' => 'city', 'region' => 'Île-de-France', 'country' => 'FR', 'latitude' => 48.4069, 'longitude' => 2.7047],
            ['name' => 'Saint-Germain-en-Laye', 'type' => 'city', 'region' => 'Île-de-France', 'country' => 'FR', 'latitude' => 48.8992, 'longitude' => 2.0937],

            // Hauts-de-France
            ['name' => 'Lille', 'type' => 'city', 'region' => 'Hauts-de-France', 'country' => 'FR', 'latitude' => 50.6292, 'longitude' => 3.0573],
            ['name' => 'Amiens', 'type' => 'city', 'region' => 'Hauts-de-France', 'country' => 'FR', 'latitude' => 49.8951, 'longitude' => 2.3022],
            ['name' => 'Calais', 'type' => 'city', 'region' => 'Hauts-de-France', 'country' => 'FR', 'latitude' => 50.9513, 'longitude' => 1.8587],
            ['name' => 'Le Touquet-Paris-Plage', 'type' => 'city', 'region' => 'Hauts-de-France', 'country' => 'FR', 'latitude' => 50.4655, 'longitude' => 1.5880],
            ['name' => 'Compiegne', 'type' => 'city', 'region' => 'Hauts-de-France', 'country' => 'FR', 'latitude' => 49.4179, 'longitude' => 2.8268],

            // Grand Est
            ['name' => 'Strasbourg', 'type' => 'city', 'region' => 'Grand Est', 'country' => 'FR', 'latitude' => 48.5734, 'longitude' => 7.7521],
            ['name' => 'Metz', 'type' => 'city', 'region' => 'Grand Est', 'country' => 'FR', 'latitude' => 49.1193, 'longitude' => 6.1741],
            ['name' => 'Reims', 'type' => 'city', 'region' => 'Grand Est', 'country' => 'FR', 'latitude' => 49.2583, 'longitude' => 4.0317],
            ['name' => 'Colmar', 'type' => 'city', 'region' => 'Grand Est', 'country' => 'FR', 'latitude' => 48.0808, 'longitude' => 7.3558],
            ['name' => 'Alsace', 'type' => 'region', 'region' => 'Grand Est', 'country' => 'FR'],
            ['name' => 'Vosges', 'type' => 'region', 'region' => 'Grand Est', 'country' => 'FR'],
            ['name' => 'Ardennes', 'type' => 'region', 'region' => 'Grand Est', 'country' => 'FR'],

            // Corsica
            ['name' => 'Bastia', 'type' => 'city', 'region' => 'Corse', 'country' => 'FR', 'latitude' => 42.7033, 'longitude' => 9.4500],
            ['name' => 'Porto-Vecchio', 'type' => 'city', 'region' => 'Corse', 'country' => 'FR', 'latitude' => 41.5912, 'longitude' => 9.2786],
            ['name' => 'Bonifacio', 'type' => 'city', 'region' => 'Corse', 'country' => 'FR', 'latitude' => 41.3877, 'longitude' => 9.1589],
            ['name' => 'Ajaccio', 'type' => 'city', 'region' => 'Corse', 'country' => 'FR', 'latitude' => 41.9192, 'longitude' => 8.7386],
            ['name' => 'Calvi', 'type' => 'city', 'region' => 'Corse', 'country' => 'FR', 'latitude' => 42.6193, 'longitude' => 8.7563],
            ['name' => 'Corse', 'type' => 'region', 'region' => 'Corse', 'country' => 'FR'],
        ];

        foreach ($data as $row) {
            Destination::create($row);
        }
    }
}
