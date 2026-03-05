<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
  protected $table = 'respuestas';
  protected $fillable = [
    'envio_uuid',
    'encuesta_id',
    'pregunta_id',
    'opcion_id',
    'respuesta_texto',
    'meta'
  ];

  protected $casts = [
    'meta' => 'array',
  ];

  public function encuesta()
  {
    return $this->belongsTo(Encuesta::class);
  }

  public function pregunta()
  {
    return $this->belongsTo(Pregunta::class);
  }

  public function opcion()
  {
    return $this->belongsTo(Opcion::class);
  }
}
