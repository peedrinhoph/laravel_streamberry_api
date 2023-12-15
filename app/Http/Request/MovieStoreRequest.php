<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class MovieStoreRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'max:255',
            'release_date'  => 'required|date_format:Y-m-d',
            'genre_ids' => [
                'array'
            ]
        ];
    }

    public function messages()
    {
        return [
            'release_date.required' => "Please enter a date release, field is required.",
            'release_date.date_format' => "Please enter a valid format date Y-m-d for release.",
            'title.required' => 'Movie title is required.',
            'genre_ids.array' => 'Please enter a array for genre_ids.',
            'genre_ids.required' => 'Please enter one or more genre_ids, field is required.'
        ];
    }
}
