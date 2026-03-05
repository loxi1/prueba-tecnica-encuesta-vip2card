<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pregunta extends Model
{
  use HasFactory;
  protected $table = 'preguntas';
  protected $fillable = ['encuesta_id', 'texto_pregunta', 'tipo_pregunta', 'orden', 'requerida'];

  public function encuesta()
  {
    return $this->belongsTo(Encuesta::class);
  }

  public function opciones()
  {
    return $this->hasMany(Opcion::class)->orderBy('orden');
  }

  public function respuestas()
  {
    return $this->hasMany(Respuesta::class);
  }
}
