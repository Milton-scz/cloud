<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Permite que cualquier usuario haga la solicitud
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
            // Validación para el campo 'name'
            'name' => 'required|string|max:255',

            // Validación para el campo 'cedula' (por ejemplo, un número de cédula único y válido)
            'cedula' => 'required|numeric|digits_between:7,10|unique:users,cedula',

            // Validación para el campo 'celular' (número de celular válido)
            'celular' => 'required|numeric|digits:8|unique:users,celular',

            // Validación para el campo 'direccion'
            'direccion' => 'required|string|max:255',

            // Validación para el campo 'email' (correo electrónico con formato válido)
            'email' => 'required|email|unique:users,email',

            // Validación para la contraseña (mínimo 8 caracteres, al menos una letra y un número)
         'password' => [
                            'required',
                            'string',
                            'confirmed',
                            'min:8',
                            'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', // Validación para mayúsculas, minúsculas, números y caracteres especiales
                        ],





            // Validación para el campo 'role' (asumiendo que es un id de un rol válido)
            'role' => 'required|exists:roles,id',
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
            'name.required' => 'El nombre es obligatorio.',
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.numeric' => 'La cédula debe ser un número válido.',
            'cedula.digits_between' => 'La cédula debe tener entre 7 y 10 dígitos.',
            'celular.required' => 'El número de celular es obligatorio.',
            'celular.numeric' => 'El número de celular debe ser un número válido.',
            'celular.digits' => 'El número de celular debe tener 8 dígitos.',
            'direccion.required' => 'La dirección es obligatoria.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'El correo electrónico ya existe.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        'password.regex' => 'La contraseña debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial.',
            'role.required' => 'El rol es obligatorio.',
            'role.exists' => 'El rol seleccionado no es válido.',
        ];
    }

}
