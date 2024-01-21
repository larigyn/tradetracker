<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
    public function rules()
    {
        return [
            'user_id'       => ['required', 'exists:users,id'],
            'name'          => ['required', 'max:256'],
            'description'   => ['required', 'max:256'],
            'address'       => ['required', 'max:256'],
            'logo'          => ['mimes:jpeg,png,jpg,doc,pdf,docx,xlx,xlsx|max:2048'],
        ];
    }
}
