<?php

namespace App\Http\Requests;

use App\Models\TipoAnimal;
use App\Models\Users;
use Illuminate\Foundation\Http\FormRequest;

class FormularioAnimalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'apelido' => 'required|string',
            'descricao' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpg,jpeg,png',
            'tipo' => "required|integer|exists:".TipoAnimal::class .",id",
            'sexo' => "required|integer|min:0|max:1",
            'ano' => "nullable|integer",
            'mes' => "nullable|integer",
        ];
    }
}
