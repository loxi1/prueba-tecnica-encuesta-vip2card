<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Encuesta extends Model
{
  use SoftDeletes;
  use HasFactory;

  protected $table = 'encuestas';
  protected $fillable = ['titulo', 'descripcion', 'fecha_inicio', 'fecha_cierre', 'publicada'];
  public function preguntas()
  {
    return $this->hasMany(Pregunta::class)->orderBy('orden');
  }
  public function respuestas()
  {
    return $this->hasMany(Respuesta::class);
  }
}
