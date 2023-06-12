<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id'=> [
                'integer',
                Rule::exists('users', 'id')
            ],
            'title'=> 'string|max:100',
            'slug'=> 'string|max:150',
            'excerpt'=> 'string|max:150',
            'description'=> 'string',
            'is_published'=> 'boolean',
            'min_to_read'=> 'string|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.integer' => 'The user ID must be an integer.',
            'user_id.exists' => 'The selected user does not exist.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than :max characters.',
            'slug.string' => 'The slug must be a string.',
            'slug.max' => 'The slug may not be greater than :max characters.',
            'excerpt.string' => 'The excerpt must be a string.',
            'excerpt.max' => 'The excerpt may not be greater than :max characters.',
            'description.string' => 'The description must be a string.',
            'is_published.boolean' => 'The is_published field must be a boolean.',
            'min_to_read.string' => 'The min_to_read must be a string.',
            'min_to_read.max' => 'The min_to_read may not be greater than :max characters.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(Response()->json([
            'success' => false,
            'message' => 'The given data is invalid.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
