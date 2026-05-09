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
    'city',
    'address',
    'latitude',
    'longitude',
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
}
