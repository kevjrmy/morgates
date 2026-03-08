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
      $table->enum('type', ['house', 'boat', 'garage']);
      $table->string('title');
      $table->longText('description')->nullable();
      $table->decimal('price_per_night', 8, 2);
      $table->char('currency', 3)->default('EUR');
      $table->integer('max_guests')->default(1);
      $table->integer('min_nights')->default(1);
      $table->integer('max_nights')->nullable();
      $table->char('country', 2)->index();
      $table->string('city');
      $table->string('address')->nullable();
      $table->decimal('latitude', 10, 7)->nullable();
      $table->decimal('longitude', 10, 7)->nullable();
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
