<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class GenreStoreRequest extends FormRequest
{

    public function rules()
    {
        return [
            'description' => 'max:50|unique:genries',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Movie title is required.',
            'description.unique' => 'The genre exists in database.'
        ];
    }
}
