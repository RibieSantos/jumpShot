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
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],

            // For member
            'birthdate' => ['nullable', 'date'],
            'age' => ['nullable', 'integer'],
            'address' => ['nullable', 'string'],
            'contact' => ['nullable', 'string'],
            'position' => ['nullable', 'string'],
            'height' => ['nullable', 'string'],
            'weight' => ['nullable', 'string'],

            // For coach
            'experience' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
            'specialty' => ['nullable', 'string'],
        ];
    }
}
