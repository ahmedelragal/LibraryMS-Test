<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
        $bookId = $this->route('id');
        return [
            'title' => 'sometimes|required|string|max:255',
            'isbn' => 'sometimes|required|string|max:13|unique:books,isbn,' . $bookId,
            'published_date' => 'sometimes|required|date',
            'author_id' => [
                'sometimes',
                'required',
                Rule::exists('authors', 'id')->whereNull('deleted_at'),
            ],
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Please enter Title.',
            'isbn.required' => 'Please enter ISBN.',
            'isbn.unique' => 'This ISBN has already been used.',
            'published_date.required' => 'Please enter published date.',
            'author_id.required' => 'Please enter author ID.',
            'author_id.exists' => 'The selected author does not exist or has been deleted.',
        ];
    }
}
