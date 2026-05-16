<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
  protected $fillable = [
    'user_id',
    'type',
    'title',
    'description',
    'photos',
    'price_amount',
    'currency',
    'price_unit',
    'capacity',
    'min_duration',
    'max_duration',
    'duration_unit',
    'country',
    'region',
    'city',
    'address',
    'map_url',
    'is_active',
    'tags',
    'contact_email',
    'contact_phone',
    'contact_whatsapp',
    'contact_website',
    'contact_social_links',
  ];

  protected $casts = [
    'photos' => 'array',
    'tags' => 'array',
    'contact_social_links' => 'array',
    'is_active' => 'boolean',
  ];

  public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function typeLabel(): string
  {
    return match ($this->type) {
      'boats' => 'Bateau',
      'stays' => 'Séjour',
      default => 'Annonce',
    };
  }

  public function priceUnitLabel(): string
  {
    return match ($this->price_unit) {
      'day' => 'jour',
      'trip' => 'sortie',
      'week' => 'semaine',
      'month' => 'mois',
      'contact' => 'sur demande',
      default => 'nuit',
    };
  }

  public function currencySymbol(): string
  {
    return match ($this->currency) {
      'EUR' => '€',
      'USD' => '$',
      'GBP' => '£',
      default => $this->currency ?? '€',
    };
  }

  public function durationUnitLabel(): string
  {
    return match ($this->duration_unit) {
      'day' => 'jour',
      'week' => 'semaine',
      'month' => 'mois',
      default => 'nuit',
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

  public function getMapEmbedUrlAttribute(): ?string
  {
    if (!$this->map_url) {
      if ($this->city) {
        $q = urlencode($this->city . ($this->country ? ', ' . $this->country : ''));
        return "https://maps.google.com/maps?q={$q}&output=embed";
      }
      return null;
    }

    $url = $this->map_url;

    if (str_contains($url, 'maps.app.goo.gl')) {
      $cacheKey = 'map_url_' . md5($url);
      $url = \Illuminate\Support\Facades\Cache::remember($cacheKey, 86400, function() use ($url) {
        $headers = @get_headers($url, 1);
        if (!$headers) return $url;
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
    
    if (preg_match('/[\?&]q=([^&]+)/', $url, $matches)) {
      return "https://maps.google.com/maps?q=" . $matches[1] . "&output=embed";
    }

    $fallback = $this->city ? ($this->city . ($this->country ? ', ' . $this->country : '')) : 'France';
    return "https://maps.google.com/maps?q=" . urlencode($fallback) . "&output=embed";
  }
}
