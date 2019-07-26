<?php

namespace App\Http\Requests\User;

use App\Rules\CurrentPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'alpha_dash|max:255',
            'email' => [
                'email',
                'max:255',
                Rule::unique('users')->ignore(auth()->user()->id),
            ],
            'current_password' => [
                'required_with:password',
                new CurrentPassword
            ],
            'password' => 'string|min:8|confirmed'
        ];
    }
}
