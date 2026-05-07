<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                  => 'required|string|max:100',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'role'                  => 'required|in:client,provider',
            'phone'                 => 'nullable|string|max:20',
            'city'                  => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique'          => 'Cet email est déjà utilisé',
            'role.in'               => 'Le rôle doit être client ou prestataire',
            'password.min'          => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed'    => 'Les mots de passe ne correspondent pas',
        ];
    }
}