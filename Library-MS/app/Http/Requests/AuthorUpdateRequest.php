<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AuthorUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $authorId = $this->route('id');

        return [
            'name' => 'sometimes|required|string',
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                Rule::unique('authors')->ignore($authorId),
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Please enter a valid email.',
            'email.unique' => 'This email has already been used.',
        ];
    }
}
