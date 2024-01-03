<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRatingStoreRequest extends FormRequest
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
            'value'         => 'required|int|between:1,5',
            'comment'       => 'max:255',
            'user_name'     => '',
            'user_email'    => 'email',
            'movie_id'      => 'required|exists:App\Models\Movie,id',
            'streaming_id'  => 'required|exists:App\Models\Streaming,id'
        ];
    }

    public function messages(): array
    {
        return [
            'value.required' => "Please enter a note.",
            'value.integer' => "Please enter a integer note.",
            'value.between' => "Please enter a note between 1 and 5.",
            'comment.max' => "The comment field must not be greater than 255 characters.",
            'user_email.email' => "The user email field must be a valid email address.",
        ];
    }
}
