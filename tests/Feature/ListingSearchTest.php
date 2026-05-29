<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListingSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_city_search_is_strict_by_default(): void
    {
        $this->seedNearbyDestinations();

        $strictListing = $this->createListing('Cannes', 'Annonce Cannes', 43.5528, 7.0174);
        $nearbyListing = $this->createListing('Mandelieu-la-Napoule', 'Annonce Mandelieu', 43.5464, 6.9399);

        $response = $this->get(route('listings', ['city' => 'Cannes']));

        $response->assertOk();
        $response->assertSee($strictListing->title);
        $response->assertDontSee($nearbyListing->title);
    }

    public function test_city_search_can_include_nearby_destinations_when_enabled(): void
    {
        $this->seedNearbyDestinations();

        $strictListing = $this->createListing('Cannes', 'Annonce Cannes', 43.5528, 7.0174);
        $nearbyListing = $this->createListing('Mandelieu-la-Napoule', 'Annonce Mandelieu', 43.5464, 6.9399);

        $response = $this->get(route('listings', [
            'city' => 'Cannes',
            'include_nearby' => '1',
        ]));

        $response->assertOk();
        $response->assertSee($strictListing->title);
        $response->assertSee($nearbyListing->title);
    }

    private function createListing(string $city, string $title, float $latitude, float $longitude): Listing
    {
        return Listing::create([
            'user_id' => User::factory()->create()->id,
            'type' => 'stays',
            'title' => $title,
            'photos' => ['https://example.com/photo.jpg'],
            'description' => 'Description',
            'price_amount' => 120,
            'price_unit' => 'day',
            'duration_unit' => 'day',
            'country' => 'FR',
            'region' => "Provence-Alpes-Côte d'Azur",
            'city' => $city,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'is_active' => true,
        ]);
    }

    private function seedNearbyDestinations(): void
    {
        Destination::insert([
            [
                'name' => 'Cannes',
                'type' => 'city',
                'region' => "Provence-Alpes-Côte d'Azur",
                'country' => 'FR',
                'latitude' => 43.5528,
                'longitude' => 7.0174,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mandelieu-la-Napoule',
                'type' => 'city',
                'region' => "Provence-Alpes-Côte d'Azur",
                'country' => 'FR',
                'latitude' => 43.5464,
                'longitude' => 6.9399,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nice',
                'type' => 'city',
                'region' => "Provence-Alpes-Côte d'Azur",
                'country' => 'FR',
                'latitude' => 43.7102,
                'longitude' => 7.2620,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
