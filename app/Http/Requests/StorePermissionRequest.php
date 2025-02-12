<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Permitir la solicitud, si es necesario puedes agregar lógica aquí.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255', // Ajusta según lo que necesites.
            'guard_name' => 'nullable|string|max:255', // Ajusta según lo que necesites.
        ];
    }
}
