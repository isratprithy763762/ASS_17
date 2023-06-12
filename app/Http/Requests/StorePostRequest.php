<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
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
                'required',
                'integer',
                Rule::exists('users', 'id')
            ],
            'title'=> 'required|string|max:100',
            'slug'=> 'required|string|max:150',
            'excerpt'=> 'required|string|max:150',
            'description'=> 'required|string',
            'is_published'=> 'required|boolean',
            'min_to_read'=> 'required|string|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID field is required.',
            'user_id.integer' => 'The user ID must be an integer.',
            'user_id.exists' => 'The selected user does not exist.',
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than :max characters.',
            'slug.required' => 'The slug field is required.',
            'slug.string' => 'The slug must be a string.',
            'slug.max' => 'The slug may not be greater than :max characters.',
            'excerpt.required' => 'The excerpt field is required.',
            'excerpt.string' => 'The excerpt must be a string.',
            'excerpt.max' => 'The excerpt may not be greater than :max characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'is_published.required' => 'The is_published field is required.',
            'is_published.boolean' => 'The is_published field must be a boolean.',
            'min_to_read.required' => 'The min_to_read field is required.',
            'min_to_read.string' => 'The min_to_read must be a string.',
            'min_to_read.max' => 'The min_to_read may not be greater than :max characters.',
        ];
    }

    protected function failedValidation(ValidationValidator $validator)
    {
        throw new HttpResponseException(Response()->json([
            'success' => false,
            'message' => 'The given data is invalid.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
