<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Vehiculo extends Model
{
  use SoftDeletes;
  use HasFactory;

  protected $table = 'vehiculos';
  protected $fillable = ['placa', 'marca', 'modelo', 'anio_fabricacion', 'cliente_id'];

  public function cliente()
  {
    return $this->belongsTo(Cliente::class);
  }
}
