<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehiculoRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    $id = $this->route('vehiculo')?->id;
    return [
      'placa'            => ['required', 'string', 'max:12', "unique:vehiculos,placa," . $id, 'regex:/^[A-Z0-9-]{5,12}$/i'],
      'marca'            => ['required', 'string', 'max:60'],
      'modelo'           => ['required', 'string', 'max:100'],
      'anio_fabricacion' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
      'cliente_id'       => ['required', 'integer', 'exists:clientes,id'],
    ];
  }
}
