<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cambia esto si necesitas lógica de autorización.
    }

    public function rules(): array
    {
        return [
            'nit' => 'required|string|max:255', // El NIT es requerido.
            'razonsocial' => 'required|string|max:255|unique:proveedors,razonsocial', // Razón social como cadena única.
            'celular' => 'nullable|string|max:15', // Celular opcional.
            'email' => 'nullable|email|max:255|unique:proveedors,email', // Email opcional, único y debe ser válido.
        ];
    }
}
