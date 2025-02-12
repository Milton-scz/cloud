<?php

namespace App\Http\Requests\Categoria;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; // Importa el facade Auth
class CategoriaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Aquí deberías decidir si el usuario tiene permiso para hacer la solicitud.
        // Si no quieres permitir a todos, cambia esto a `return false;` o haz una validación de permisos.
        if (Auth::check() && (Auth::user()->roles->contains('name', 'almacenero') || Auth::user()->roles->contains('name', 'gerente'))) {
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
            'nombre' => 'required|string|max:255|unique:categorias,nombre',

            // Validación para el campo 'descripcion' (opcional, pero si se proporciona debe ser un string)
            'descripcion' => 'nullable|string|max:500',
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
            'nombre.required' => 'El nombre de la categoria es obligatorio.',
            'nombre.string' => 'El nombre de la categoria debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
            'nombre.unique' => 'Ya existe categoria con ese nombre.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'descripcion.max' => 'La descripción no debe exceder los 500 caracteres.',
        ];
    }
}
