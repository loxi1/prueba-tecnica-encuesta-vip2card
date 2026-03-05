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
    Schema::create('respuestas', function (Blueprint $table) {
      $table->id();
      // Agrupador anónimo por envío (no usuario): mismo UUID para todas las respuestas de una persona
      $table->uuid('envio_uuid')->index();
      $table->foreignId('encuesta_id')->constrained('encuestas')->cascadeOnDelete();
      $table->foreignId('pregunta_id')->constrained('preguntas')->cascadeOnDelete();
      $table->foreignId('opcion_id')->nullable()->constrained('opciones')->nullOnDelete();
      $table->text('respuesta_texto')->nullable();
      // metadatos opcionales, pero manteniendo anonimato (hash IP/UA si quisieras)
      $table->json('meta')->nullable();
      $table->timestamps();

      $table->index(['encuesta_id', 'pregunta_id']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('respuestas');
  }
};
