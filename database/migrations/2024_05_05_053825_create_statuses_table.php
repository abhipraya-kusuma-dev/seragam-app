<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('statuses', function (Blueprint $table) {
      $table->id();
      $table->foreignId('seragam_id')->references('id')->on('seragams')->cascadeOnDelete();
      $table->foreignId('order_id')->references('id')->on('orders')->cascadeOnDelete();
      $table->boolean('tersedia')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('statuses');
  }
};
