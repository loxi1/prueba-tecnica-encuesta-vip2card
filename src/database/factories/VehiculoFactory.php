<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehiculo>
 */
class VehiculoFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'placa'           => strtoupper($this->faker->bothify('???-###')),
      'marca'           => $this->faker->randomElement(['Toyota', 'Hyundai', 'Kia', 'Nissan', 'Chevrolet']),
      'modelo'          => $this->faker->word(),
      'anio_fabricacion' => $this->faker->numberBetween(2005, 2026),
      'cliente_id'      => Cliente::inRandomOrder()->value('id') ?? Cliente::factory(),
    ];
  }
}
