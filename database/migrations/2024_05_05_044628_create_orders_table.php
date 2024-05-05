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
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->foreignId('seragam_id')->references('id')->on('seragams');
      $table->string('nomor_urut');
      $table->string('jenjang');
      $table->string('nama_lengkap');
      $table->string('jenis_kelamin');
      $table->string('status'); // Enum: on-progress, draft
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('orders');
  }
};
