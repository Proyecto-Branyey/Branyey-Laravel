<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'telefono' => ['nullable', 'string', 'max:30'],
            'nombre_completo' => ['nullable', 'string', 'max:255'],
            'direccion_defecto' => ['nullable', 'string', 'max:255'],
            'ciudad_defecto' => ['required', 'string', 'max:100'],
            'departamento_defecto' => ['required', 'string', 'max:100'],
        ];
    }
}
