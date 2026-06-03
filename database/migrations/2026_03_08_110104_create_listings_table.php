<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('listings', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->enum('type', ['boats', 'stays'])->index();
      $table->string('title');
      $table->string('slug')->unique();
      $table->json('photos')->nullable();
      $table->longText('description')->nullable();
      $table->decimal('price_amount', 8, 2)->nullable();
      $table->enum('price_unit', ['hour', 'half-day', 'day', 'week', 'month', 'contact'])->default('day');
      $table->unsignedSmallInteger('capacity')->nullable();
      $table->unsignedSmallInteger('min_duration')->nullable();
      $table->unsignedSmallInteger('max_duration')->nullable();
      $table->char('country', 2)->index();
      $table->string('region')->nullable()->index();
      $table->string('city');
      $table->json('tags')->nullable();
      $table->string('address')->nullable();
      $table->string('map_url')->nullable();
      $table->string('contact_email')->nullable();
      $table->string('contact_phone')->nullable();
      $table->string('contact_whatsapp')->nullable();
      $table->string('contact_website')->nullable();
      $table->json('contact_social_links')->nullable();
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('listings');
  }
};
