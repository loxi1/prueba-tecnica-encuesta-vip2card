<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
    $id = $this->route('cliente')?->id;
    return [
      'nombre'        => ['required', 'string', 'max:100'],
      'apellidos'     => ['required', 'string', 'max:150'],
      'nro_documento' => ['nullable', 'string', 'max:30', "unique:clientes,nro_documento," . $id],
      'correo'        => ['nullable', 'email', 'max:150', "unique:clientes,correo," . $id],
      'telefono'      => ['nullable', 'string', 'max:30'],
    ];
  }
}
