<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;


class CreateUserRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name'    => 'required|max:256',
            'last_name'     => 'required|max:256|unique:users',
            'email'         => 'required|email|max:256|unique:users',
            'password'      => 'required|string|min:8',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'Firstname is required',
            'last_name.required' => 'Lastname is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
        ];
    }
}
