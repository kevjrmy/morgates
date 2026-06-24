<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Listing extends Model
{
  protected $fillable = [
    'user_id',
    'type',
    'title',
    'slug',
    'description',
    'photos',
    'price_amount',
    'price_unit',
    'capacity',
    'min_duration',
    'max_duration',
    'country',
    'region',
    'city',
    'latitude',
    'longitude',
    'address',
    'show_exact_address',
    'map_url',
    'is_active',
    'tags',
    'contact_email',
    'contact_phone',
    'contact_whatsapp',
    'contact_website',
    'contact_social_links',
    'preferred_contact',
  ];

  protected static function booted(): void
  {
    static::saving(function (Listing $listing) {
      if (!$listing->title) {
        return;
      }

      if ($listing->slug && !$listing->isDirty('title')) {
        return;
      }

      $listing->slug = static::generateUniqueSlug($listing->title, $listing->getKey());
    });
  }

  protected $casts = [
    'photos' => 'array',
    'tags' => 'array',
    'contact_social_links' => 'array',
    'latitude' => 'float',
    'longitude' => 'float',
    'is_active' => 'boolean',
    'show_exact_address' => 'boolean',
  ];

  public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function getRouteKeyName(): string
  {
    return 'slug';
  }

  public function typeLabel(): string
  {
    return match ($this->type) {
      'boats' => 'Bateau',
      'stays' => 'Hébergement',
      default => 'Annonce',
    };
  }

    public function priceUnitLabel(): string
    {
      return match ($this->price_unit) {
        'hour' => 'heure',
        'half-day' => 'demi-journée',
        'day' => 'jour',
        'week' => 'semaine',
        'month' => 'mois',
        'contact' => 'sur demande',
        default => 'jour',
      };
    }

  public function primaryContactUrl(): string
  {
    if ($this->contact_email) {
      return 'mailto:' . $this->contact_email;
    }

    if ($this->contact_phone) {
      return 'tel:' . $this->contact_phone;
    }

    if ($this->contact_whatsapp) {
      return 'https://wa.me/' . preg_replace('/\D+/', '', $this->contact_whatsapp);
    }

    if ($this->contact_website) {
      return $this->contact_website;
    }

    return 'mailto:' . $this->user->email;
  }

  public function resolveTags(): array
  {
    $map = config('tags') ?? [];
    return collect($this->tags ?? [])->map(fn($tag) => [
      'icon' => $map[$tag]['icon'] ?? 'tag',
      'label' => $map[$tag]['label'] ?? $tag,
    ])->all();
  }

  public function getMapEmbedUrlAttribute(): ?string
  {
    if (!$this->map_url) {
      $fallbackParts = array_filter([$this->city, $this->region, $this->country]);
      if ($fallbackParts) {
        $q = urlencode(implode(', ', $fallbackParts));
        return "https://maps.google.com/maps?q={$q}&output=embed";
      }
      return null;
    }

    $url = $this->map_url;

    if (str_contains($url, 'maps.app.goo.gl')) {
      $cacheKey = 'map_url_' . md5($url);
      $url = \Illuminate\Support\Facades\Cache::remember($cacheKey, 86400, function () use ($url) {
        $headers = @get_headers($url, 1);
        if (!$headers)
          return $url;
        $location = $headers['Location'] ?? $headers['location'] ?? $url;
        return is_array($location) ? end($location) : $location;
      });
    }

    if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
      return "https://maps.google.com/maps?q={$matches[1]},{$matches[2]}&output=embed";
    }

    if (preg_match('/\/place\/([^\/\?]+)/', $url, $matches)) {
      return "https://maps.google.com/maps?q=" . $matches[1] . "&output=embed";
    }

    if (preg_match('/[\?&](?:q|query)=([^&]+)/', $url, $matches)) {
      return "https://maps.google.com/maps?q=" . $matches[1] . "&output=embed";
    }

    $fallbackParts = array_filter([$this->city, $this->region, $this->country]);
    $fallback = $fallbackParts ? implode(', ', $fallbackParts) : 'France';
    return "https://maps.google.com/maps?q=" . urlencode($fallback) . "&output=embed";
  }

  protected static function generateUniqueSlug(string $title, mixed $ignoreId = null): string
  {
    $baseSlug = Str::slug($title);

    if ($baseSlug === '') {
      $baseSlug = 'annonce';
    }

    $slug = $baseSlug;
    $suffix = 2;

    while (
      static::query()
        ->when($ignoreId, fn($query) => $query->whereKeyNot($ignoreId))
        ->where('slug', $slug)
        ->exists()
    ) {
      $slug = $baseSlug . '-' . $suffix;
      $suffix++;
    }

    return $slug;
  }
}
