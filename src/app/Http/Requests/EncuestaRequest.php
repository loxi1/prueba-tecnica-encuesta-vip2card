<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EncuestaRequest extends FormRequest
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
    return [
      'titulo'        => ['required', 'string', 'max:200'],
      'descripcion'   => ['nullable', 'string'],
      'fecha_inicio'  => ['nullable', 'date'],
      'fecha_cierre'  => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
      'publicada'     => ['boolean'],
      'preguntas'     => ['array'],
      'preguntas.*.texto_pregunta' => ['required', 'string', 'max:500'],
      'preguntas.*.tipo_pregunta'  => ['required', 'in:unica,opcion_multiple,texto,escala'],
      'preguntas.*.orden'          => ['nullable', 'integer', 'min:0'],
      'preguntas.*.requerida'      => ['boolean'],
      'preguntas.*.opciones'       => ['array'],
      'preguntas.*.opciones.*.texto_opcion' => ['required_with:preguntas.*.opciones', 'string', 'max:300'],
      'preguntas.*.opciones.*.orden'        => ['nullable', 'integer', 'min:0'],
    ];
  }
}
