<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlmacenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'capacidad' => 'required|integer|min:1',
            'descripcion' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del almacén es obligatorio.',
            'direccion.required' => 'La dirección del almacén es obligatoria.',
            'capacidad.required' => 'La capacidad del almacén es obligatoria.',
            'capacidad.integer' => 'La capacidad debe ser un número entero.',
            'capacidad.min' => 'La capacidad debe ser al menos 1.',
        ];
    }
}
