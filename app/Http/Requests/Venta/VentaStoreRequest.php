<?php

namespace App\Http\Requests\Venta;

use Illuminate\Foundation\Http\FormRequest;

class VentaStoreRequest extends FormRequest
{
    /**
     * Determine si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true; // Cambia a 'false' si no deseas permitir a todos los usuarios
    }

    /**
     * Obtener las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Validación para el campo 'producto_id'
            'producto_id' => 'required|exists:productos,id',

            // Validación para el campo 'cantidad'
            'cantidad' => 'required|integer|min:1',

            // Validación para el campo 'precio'
            'precio' => 'required|numeric|min:0',

            // Validación para el campo 'cliente_id'
            'cliente_id' => 'required|exists:clientes,id',

            // Validación para el campo 'fecha'
            'fecha' => 'required|date|after:today',

            // Nuevas validaciones
            'tnTelefono' => 'required|regex:/^\+?[0-9]{7,15}$/', // Validación para el teléfono (formato internacional opcional)
            'tcCorreo' => 'required|email', // Validación para el correo (debe ser un correo válido)
            'tcCiNit' => 'required|string|min:5', // Validación para CI/NIT, mínimo 5 caracteres
            'tnMonto' => 'required|numeric|min:0.01', // Validación para el monto (debe ser mayor a 0)
            'tnTipoServicio' => 'required|in:1,2', // Validación para el tipo de servicio (solo puede ser 1 o 2)
        ];
    }

    /**
     * Obtener mensajes personalizados de error para las reglas de validación.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'producto_id.required' => 'El campo producto es obligatorio.',
            'producto_id.exists' => 'El producto seleccionado no existe.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.min' => 'La cantidad debe ser al menos 1.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio debe ser mayor o igual a 0.',
            'cliente_id.required' => 'El cliente es obligatorio.',
            'cliente_id.exists' => 'El cliente seleccionado no existe.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser una fecha válida.',
            'fecha.after' => 'La fecha debe ser posterior al día de hoy.',
            'tnTelefono.required' => 'El teléfono es obligatorio.',
            'tnTelefono.regex' => 'El teléfono debe tener un formato válido.',
            'tcCorreo.required' => 'El correo es obligatorio.',
            'tcCorreo.email' => 'El correo debe ser válido.',
            'tcCiNit.required' => 'El CI/NIT es obligatorio.',
            'tcCiNit.string' => 'El CI/NIT debe ser una cadena de texto.',
            'tcCiNit.min' => 'El CI/NIT debe tener al menos 5 caracteres.',
            'tnMonto.required' => 'El monto es obligatorio.',
            'tnMonto.numeric' => 'El monto debe ser un número.',
            'tnMonto.min' => 'El monto debe ser mayor o igual a 0.01.',
            'tnTipoServicio.required' => 'El tipo de servicio es obligatorio.',
            'tnTipoServicio.in' => 'El tipo de servicio debe ser 1 (Servicio QR) o 2 (Tigo Money).',
        ];
    }
}
