<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Opcion;

class DemoVip2CarsEncuestaSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    DB::transaction(function () {

      // Si quieres evitar duplicados por título:
      $encuesta = Encuesta::firstOrCreate(
        ['titulo' => 'Encuesta de satisfacción VIP2CARS'],
        [
          'descripcion'  => 'Encuesta anónima post-servicio para medir satisfacción y preferencias.',
          'publicada'    => true,
          'fecha_inicio' => now()->subDay()->setTime(19, 0, 0), // “ayer 7pm”
          'fecha_cierre' => null,
        ]
      );

      // Limpia preguntas/opciones si ya existían (opcional)
      $encuesta->preguntas()->delete();

      $preguntas = [
        [
          'texto' => '¿Qué tan satisfecho estás con el servicio de mantenimiento de tu vehículo?',
          'tipo'  => 'unica',
          'opciones' => ['Muy satisfecho', 'Satisfecho', 'Neutral', 'Insatisfecho', 'Muy insatisfecho'],
        ],
        [
          'texto' => '¿Qué marca de vehículo prefieres para tu próxima compra?',
          'tipo'  => 'unica',
          'opciones' => ['Toyota', 'Hyundai', 'Kia', 'Chevrolet', 'Otra'],
        ],
        [
          'texto' => '¿Qué canal prefieres para recibir información de promociones?',
          'tipo'  => 'unica',
          'opciones' => ['Correo electrónico', 'WhatsApp', 'Llamada telefónica', 'Redes sociales'],
        ],
        [
          'texto' => '¿Qué factor consideras más importante al elegir un vehículo?',
          'tipo'  => 'unica',
          'opciones' => ['Precio', 'Consumo de combustible', 'Seguridad', 'Tecnología', 'Marca'],
        ],
        [
          'texto' => '¿Recomendarías VIP2CARS a un amigo o familiar?',
          'tipo'  => 'unica',
          'opciones' => ['Sí', 'No'],
        ],
      ];

      foreach ($preguntas as $i => $p) {
        $preg = Pregunta::create([
          'encuesta_id'    => $encuesta->id,
          'texto_pregunta' => $p['texto'],
          'tipo_pregunta'  => $p['tipo'],
          'orden'          => $i + 1,
          'requerida'      => true,
        ]);

        foreach ($p['opciones'] as $j => $textoOpcion) {
          Opcion::create([
            'pregunta_id'   => $preg->id,
            'texto_opcion'  => $textoOpcion,
            'orden'         => $j + 1,
          ]);
        }
      }
    });
  }
}
