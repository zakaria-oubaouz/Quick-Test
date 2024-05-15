<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculatorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'expression' => [
                'required',
                'string',
                'regex:/^(?=.*[0-9])([0-9]+|[\(][0-9]+[\)])([\+\-\*\/]([0-9]+|[\(][0-9]+[\)]))*$/' //S'assure que l'expression ne contient que des chiffres, signe d'operation et des parentheses
            ]
        ];
    }
    public function messages(): array
    {
        return [
            'expression.required' => "L'expression est obligatoire.",
            'expression.string' => "L'expression doit être une chaîne de caractères.",
            'expression.regex' => "Veuillez verifier votre expression"
        ];
    }
}
