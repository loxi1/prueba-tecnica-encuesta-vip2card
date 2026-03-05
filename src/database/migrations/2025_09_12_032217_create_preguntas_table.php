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
    Schema::create('preguntas', function (Blueprint $table) {
      $table->id();
      $table->foreignId('encuesta_id')->constrained('encuestas')->cascadeOnDelete();
      $table->string('texto_pregunta', 500);
      // tipos sugeridos: opcion_multiple, unica, texto, escala
      $table->string('tipo_pregunta', 30)->default('unica');
      $table->unsignedInteger('orden')->default(0);
      $table->boolean('requerida')->default(true);
      $table->timestamps();
      $table->index(['encuesta_id', 'orden']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('preguntas');
  }
};
