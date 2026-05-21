<?php

namespace App\Support;

use App\Models\Destination;

class NearbyDestinationResolver
{
    public function resolveCityNames(string $city, int $radiusKm = 20): array
    {
        $normalizedCity = trim($city);

        if ($normalizedCity === '') {
            return [];
        }

        $origin = Destination::query()
            ->where('type', 'city')
            ->whereRaw('LOWER(name) = ?', [mb_strtolower($normalizedCity)])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->first();

        if (!$origin) {
            return [];
        }

        $nearbyCities = Destination::query()
            ->where('type', 'city')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['name', 'latitude', 'longitude'])
            ->filter(function (Destination $destination) use ($origin, $radiusKm) {
                return $this->distanceInKm(
                    $origin->latitude,
                    $origin->longitude,
                    $destination->latitude,
                    $destination->longitude,
                ) <= $radiusKm;
            })
            ->pluck('name')
            ->unique()
            ->values()
            ->all();

        return in_array($origin->name, $nearbyCities, true)
            ? $nearbyCities
            : [$origin->name, ...$nearbyCities];
    }

    private function distanceInKm(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadiusKm = 6371;

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) ** 2
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($lonDelta / 2) ** 2;

        return $earthRadiusKm * (2 * atan2(sqrt($a), sqrt(1 - $a)));
    }
}
