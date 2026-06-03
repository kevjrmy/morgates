<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListingDestinationCacheTest extends TestCase
{
    use RefreshDatabase;

    public function test_listing_creation_caches_destination_coordinates(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->withSession([
                'listing_create' => [
                    'type' => 'stays',
                    'country' => 'FR',
                    'region' => 'Bretagne',
                    'city' => 'Vannes',
                    'latitude' => 47.6582,
                    'longitude' => -2.7608,
                    'title' => 'Cabane à Vannes',
                    'price_amount' => 90,
                    'price_unit' => 'day',
                    'capacity' => 2,
                    'min_duration' => 1,
                    'description' => 'Une annonce de test.',
                ],
            ])
            ->post(route('listings.create.photos'))
            ->assertRedirect(route('account'));

        $this->assertDatabaseHas('listings', [
            'city' => 'Vannes',
            'latitude' => 47.6582,
            'longitude' => -2.7608,
        ]);

        $this->assertDatabaseHas('destinations', [
            'name' => 'Vannes',
            'type' => 'city',
            'region' => 'Bretagne',
            'country' => 'FR',
            'latitude' => 47.6582,
            'longitude' => -2.7608,
        ]);
    }

    public function test_listing_cities_endpoint_returns_cached_listing_cities_only(): void
    {
        Destination::create([
            'name' => 'Vannes',
            'type' => 'city',
            'region' => 'Bretagne',
            'country' => 'FR',
            'latitude' => 47.6582,
            'longitude' => -2.7608,
        ]);

        Destination::create([
            'name' => 'Valencia',
            'type' => 'city',
            'region' => 'Comunitat Valenciana',
            'country' => 'ES',
            'latitude' => 39.4699,
            'longitude' => -0.3763,
        ]);

        $this
            ->getJson(route('api.listings.cities', ['q' => 'Van']))
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'name' => 'Vannes',
                'region' => 'Bretagne',
            ]);
    }
}
