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
    Schema::create('vehiculos', function (Blueprint $table) {
      $table->id();
      $table->string('placa', 12)->unique();
      $table->string('marca', 60);
      $table->string('modelo', 100);
      $table->unsignedSmallInteger('anio_fabricacion')->nullable(); // 1900..2100
      $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
      $table->timestamps();
      $table->softDeletes();

      $table->index(['marca', 'modelo']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('vehiculos');
  }
};
