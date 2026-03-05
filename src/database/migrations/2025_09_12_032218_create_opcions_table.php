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
    Schema::create('opciones', function (Blueprint $table) {
      $table->id();
      $table->foreignId('pregunta_id')->constrained('preguntas')->cascadeOnDelete();
      $table->string('texto_opcion', 300);
      $table->unsignedInteger('orden')->default(0);
      $table->timestamps();
      $table->index(['pregunta_id', 'orden']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('opcions');
  }
};
