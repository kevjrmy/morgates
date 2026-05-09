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
      $table->json('photos')->nullable();
      $table->longText('description')->nullable();
      $table->decimal('price_amount', 8, 2)->nullable();
      $table->char('currency', 3)->default('EUR');
      $table->enum('price_unit', ['night', 'day', 'trip', 'week', 'month', 'contact'])->default('night');
      $table->unsignedSmallInteger('capacity')->nullable();
      $table->unsignedSmallInteger('min_duration')->nullable();
      $table->unsignedSmallInteger('max_duration')->nullable();
      $table->enum('duration_unit', ['night', 'day', 'week', 'month'])->default('night');
      $table->char('country', 2)->index();
      $table->string('city');
      $table->json('tags')->nullable();
      $table->string('address')->nullable();
      $table->decimal('latitude', 10, 7)->nullable();
      $table->decimal('longitude', 10, 7)->nullable();
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
