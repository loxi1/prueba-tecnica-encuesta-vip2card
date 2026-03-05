<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
  use SoftDeletes;
  use HasFactory;

  protected $table = 'clientes';
  protected $fillable = ['nombre', 'apellidos', 'nro_documento', 'correo', 'telefono'];

  public function vehiculos()
  {
    return $this->hasMany(Vehiculo::class);
  }
}
