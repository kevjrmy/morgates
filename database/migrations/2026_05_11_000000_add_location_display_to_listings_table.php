<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('listings', function (Blueprint $table) {
      $table->enum('location_display', ['exact', 'area'])->nullable()->after('longitude');
      $table->unsignedInteger('location_radius')->nullable()->after('location_display');
    });
  }

  public function down(): void
  {
    Schema::table('listings', function (Blueprint $table) {
      $table->dropColumn(['location_display', 'location_radius']);
    });
  }
};