<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            "name" => "string|required",
            "email" => "string|email|required",
            "password" => "string|required",
            "foto" => "nullable|file|image|mimes:jpg,jpeg,png",
            "data_aniversario "=> "string",
            "rua" => "required|string",
            "numero" => "required|integer",
            "complemento" => "nullable|string",
            "bairro" => "required|string",
            "cidade" => "required|string",
            "estado" => "required|string",
            "cep" => "required|string",
        ];
    }
}
