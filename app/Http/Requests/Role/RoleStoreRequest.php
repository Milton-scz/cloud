<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; // Importa el facade Auth
class RoleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Aquí deberías decidir si el usuario tiene permiso para hacer la solicitud.
        // Si no quieres permitir a todos, cambia esto a `return false;` o haz una validación de permisos.
        if (Auth::check() && Auth::user()->roles->contains('name', 'gerente')) {
           return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Validación para el campo 'nombre'
            'name' => 'required|string|max:255|unique:roles,name',

            // Validación para el campo 'descripcion' (opcional, pero si se proporciona debe ser un string)
            'guard_name' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom error messages for the validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.string' => 'El nombre del rol debe ser una cadena de texto.',
            'name.max' => 'El nombre del rol no debe exceder los 255 caracteres.',
            'name.unique' => 'Ya existe un rol con ese nombre.',
            'guard_name.string' => 'La descripción debe ser una cadena de texto.',
            'guard_name.max' => 'La descripción no debe exceder los 500 caracteres.',
        ];
    }
}
