<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StreamingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:50|unique:streamings',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Streaming name is required.',
            'name.unique' => 'The streaming exists in database.'
        ];
    }
}
