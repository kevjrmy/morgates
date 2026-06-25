<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'account_type',
    'first_name',
    'last_name',
    'company_name',
    'host_name',
    'email',
    'password',
    'phone',
    'profile_picture',
    'bio',
    'country',
    'locale',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function getNameAttribute($value): ?string
  {
    return $this->display_host_name ?? $value;
  }

  public function isCompany(): bool
  {
    return $this->account_type === 'company';
  }

  public function getDisplayHostNameAttribute(): ?string
  {
    $rawName = $this->getRawOriginal('name');

    if (filled($this->host_name)) {
      return $this->host_name;
    }

    if ($this->isCompany()) {
      return $this->company_name ?: $rawName ?: null;
    }

    if (filled($this->first_name) && filled($this->last_name)) {
      return trim($this->first_name) . ' ' . mb_strtoupper(mb_substr(trim($this->last_name), 0, 1)) . '.';
    }

    if (filled($this->first_name)) {
      return $this->first_name;
    }

    return $rawName ?: null;
  }

  public function getGreetingNameAttribute(): ?string
  {
    $rawName = $this->getRawOriginal('name');

    if ($this->isCompany()) {
      return $this->company_name ?: $this->host_name ?: $rawName ?: null;
    }

    return $this->first_name ?: $this->host_name ?: $rawName ?: null;
  }

  public function getFullNameAttribute(): ?string
  {
    $rawName = $this->getRawOriginal('name');

    if ($this->isCompany()) {
      return $this->company_name ?: $rawName ?: null;
    }

    return trim(collect([$this->first_name, $this->last_name])->filter()->implode(' ')) ?: ($rawName ?: null);
  }

  public function listings(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Listing::class);
  }
}
