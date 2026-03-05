<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResponderEncuestaRequest extends FormRequest
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
      'envio_uuid'                => ['required', 'uuid'],
      'respuestas'                => ['required', 'array', 'min:1'],
      'respuestas.*.pregunta_id'  => ['required', 'integer', 'exists:preguntas,id'],
      'respuestas.*.opcion_id'    => ['nullable', 'integer', 'exists:opciones,id'],
      'respuestas.*.respuesta'    => ['nullable', 'string'],
      'meta'                      => ['nullable', 'array'],
    ];
  }
}
