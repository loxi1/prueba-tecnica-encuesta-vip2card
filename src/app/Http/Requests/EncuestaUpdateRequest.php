<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EncuestaUpdateRequest extends FormRequest
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
      'titulo'       => ['required', 'string', 'max:255'],
      'descripcion'  => ['nullable', 'string'],
      'fecha_inicio' => ['nullable', 'date'],
      'fecha_cierre' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
      'publicada'    => ['nullable', 'boolean'],
    ];
  }
}
