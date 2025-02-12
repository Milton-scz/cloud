<?php

namespace App\Http\Requests\Producto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; // Importa el facade Auth

class ProductoStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Verificar si el usuario está autenticado y tiene el rol adecuado
       // if (Auth::check() && (Auth::user()->roles->contains('nombre', 'Almacenero') || Auth::user()->roles->contains('nombre', 'Rol_Gerente'))) {
         //   return true; // El usuario tiene permiso para hacer la solicitud
       // }
        return true; // Denegar la solicitud si no tiene el rol adecuado
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
            'nombre' => 'required|string|max:255|unique:productos,nombre',

            // Validación para el campo 'precio'
            'precio' => 'required|numeric|min:0',

            // Validación para el campo 'stock'
            'stock' => 'required|integer|min:0',

            // Validación para el campo 'categoria_id' (debe existir en la tabla de categorías)
            'categoria_id' => 'required|exists:categorias,id',

            // Validación para el campo 'imagen' (opcional, si se proporciona debe ser una imagen válida)
            'imagen' => 'nullable|required|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Validación para el campo 'descripcion'
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
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.string' => 'El nombre del producto debe ser una cadena de texto.',
            'nombre.max' => 'El nombre del producto no debe exceder los 255 caracteres.',
            'nombre.unique' => 'Ya existe un producto con ese nombre.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser menor que 0.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser menor que 0.',
            'categoria_id.required' => 'La categoría es obligatoria.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'imagen.image' => 'El archivo de imagen debe ser una imagen válida.',
            'imagen.required' => 'La imagen es obligatorio.',
            'imagen.mimes' => 'La imagen debe tener uno de los siguientes formatos: jpeg, png, jpg, gif.',
            'imagen.max' => 'La imagen no debe pesar más de 2MB.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'descripcion.max' => 'La descripción no debe exceder los 500 caracteres.',
        ];
    }
}
