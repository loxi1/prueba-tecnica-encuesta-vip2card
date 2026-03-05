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
    Schema::create('clientes', function (Blueprint $table) {
      $table->id();
      $table->string('nombre', 100);
      $table->string('apellidos', 150);
      $table->string('nro_documento', 30)->nullable()->unique();
      $table->string('correo', 150)->nullable()->unique();
      $table->string('telefono', 30)->nullable();
      $table->timestamps();
      $table->softDeletes();
      $table->index(['apellidos', 'nombre']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('clientes');
  }
};
