<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Vehiculo;
use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\Opcion;

class DemoVip2CarsSeeder extends Seeder
{
  public function run(): void
  {
    // Para que las fechas se vean "ayer 7pm" (03-03-2026 21:00)
    $demoStart = Carbon::create(2026, 3, 3, 21, 0, 0);

    // 1) Admin user
    User::updateOrCreate(
      ['email' => 'anibal.cayetano@gmail.com'],
      [
        'name' => 'Aníbal Cayetano',
        'password' => Hash::make('acme654123'),
        'email_verified_at' => now(),
        'created_at' => $demoStart,
        'updated_at' => $demoStart,
      ]
    );

    // 2) Clientes + Vehículos
    // (si ya tienes factories, puedes usar factories; aquí lo hago directo y simple)
    $clientes = [
      ['nombre' => 'Carlos', 'apellidos' => 'Pérez Ramos', 'nro_documento' => '44556677', 'correo' => 'carlos@example.com', 'telefono' => '987654321'],
      ['nombre' => 'María',  'apellidos' => 'Gómez Díaz',  'nro_documento' => '77889911', 'correo' => 'maria@example.com',  'telefono' => '912345678'],
      ['nombre' => 'Luis',   'apellidos' => 'Torres Vega', 'nro_documento' => '55667788', 'correo' => 'luis@example.com',   'telefono' => '956789123'],
      ['nombre' => 'Ana',    'apellidos' => 'Rojas León',  'nro_documento' => '66778899', 'correo' => 'ana@example.com',    'telefono' => '965432198'],
      ['nombre' => 'Jorge',  'apellidos' => 'Soto Ruiz',   'nro_documento' => '33445566', 'correo' => 'jorge@example.com',  'telefono' => '976543210'],
    ];

    $clienteIds = [];
    foreach ($clientes as $c) {
      $cli = Cliente::create(array_merge($c, [
        'created_at' => $demoStart,
        'updated_at' => $demoStart,
      ]));
      $clienteIds[] = $cli->id;
    }

    $vehiculos = [
      ['placa' => 'ABC-123', 'marca' => 'Toyota',   'modelo' => 'Corolla', 'anio_fabricacion' => 2020],
      ['placa' => 'DEF-456', 'marca' => 'Hyundai',  'modelo' => 'Accent',  'anio_fabricacion' => 2019],
      ['placa' => 'GHI-789', 'marca' => 'Kia',      'modelo' => 'Rio',     'anio_fabricacion' => 2021],
      ['placa' => 'JKL-321', 'marca' => 'Chevrolet', 'modelo' => 'Onix',    'anio_fabricacion' => 2022],
      ['placa' => 'MNO-654', 'marca' => 'Nissan',   'modelo' => 'Versa',   'anio_fabricacion' => 2018],
      ['placa' => 'PQR-987', 'marca' => 'Toyota',   'modelo' => 'Yaris',   'anio_fabricacion' => 2017],
      ['placa' => 'STU-246', 'marca' => 'Kia',      'modelo' => 'Sportage', 'anio_fabricacion' => 2023],
      ['placa' => 'VWX-135', 'marca' => 'Hyundai',  'modelo' => 'Tucson',  'anio_fabricacion' => 2024],
    ];

    $i = 0;
    foreach ($vehiculos as $v) {
      Vehiculo::create(array_merge($v, [
        'cliente_id' => $clienteIds[$i % count($clienteIds)],
        'created_at' => $demoStart,
        'updated_at' => $demoStart,
      ]));
      $i++;
    }

    // 3) Encuesta VIP2CARS (con preguntas y opciones)
    $encuesta = Encuesta::create([
      'titulo' => 'Encuesta de satisfacción VIP2CARS',
      'descripcion' => 'Encuesta anónima post-servicio para medir satisfacción y preferencias.',
      'fecha_inicio' => $demoStart,
      'fecha_cierre' => null,
      'publicada' => 1,
      'created_at' => $demoStart,
      'updated_at' => $demoStart,
    ]);

    $preguntas = [
      [
        'texto' => '¿Qué tan satisfecho estás con el servicio de mantenimiento de tu vehículo?',
        'tipo' => 'unica',
        'opciones' => ['Muy satisfecho', 'Satisfecho', 'Neutral', 'Insatisfecho', 'Muy insatisfecho'],
      ],
      [
        'texto' => '¿Qué marca de vehículo prefieres para tu próxima compra?',
        'tipo' => 'unica',
        'opciones' => ['Toyota', 'Hyundai', 'Kia', 'Chevrolet', 'Otra'],
      ],
      [
        'texto' => '¿Qué canal prefieres para recibir información de promociones?',
        'tipo' => 'unica',
        'opciones' => ['Correo electrónico', 'WhatsApp', 'Llamada telefónica', 'Redes sociales'],
      ],
      [
        'texto' => '¿Qué factor consideras más importante al elegir un vehículo?',
        'tipo' => 'unica',
        'opciones' => ['Precio', 'Consumo de combustible', 'Seguridad', 'Tecnología', 'Marca'],
      ],
      [
        'texto' => '¿Recomendarías VIP2CARS a un amigo o familiar?',
        'tipo' => 'unica',
        'opciones' => ['Sí', 'No'],
      ],
    ];

    $orden = 1;
    foreach ($preguntas as $p) {
      $preg = Pregunta::create([
        'encuesta_id' => $encuesta->id,
        'texto_pregunta' => $p['texto'],
        'tipo_pregunta' => $p['tipo'],
        'orden' => $orden,
        'requerida' => 1,
        'created_at' => $demoStart,
        'updated_at' => $demoStart,
      ]);

      $oOrden = 1;
      foreach ($p['opciones'] as $txt) {
        Opcion::create([
          'pregunta_id' => $preg->id,
          'texto_opcion' => $txt,
          'orden' => $oOrden,
          'created_at' => $demoStart,
          'updated_at' => $demoStart,
        ]);
        $oOrden++;
      }

      $orden++;
    }
  }
}
