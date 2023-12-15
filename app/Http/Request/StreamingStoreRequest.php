<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StreamingStoreRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required|max:50|unique:streamings',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Streaming name is required.',
            'name.unique' => 'The streaming exists in database.'
        ];
    }
}
