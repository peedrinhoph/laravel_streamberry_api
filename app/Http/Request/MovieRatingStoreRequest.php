<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class MovieRatingStoreRequest extends FormRequest
{

    public function rules()
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

    public function messages()
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
