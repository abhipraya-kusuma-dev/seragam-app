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
      $table->string('nomor_urut');
      $table->string('jenjang');
      $table->string('nama_lengkap');
      $table->string('jenis_kelamin');
      $table->dateTime('complete_timestamp')->nullable();
      $table->string('status')->default('on-process'); // Enum: on-process, draft, complete
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
