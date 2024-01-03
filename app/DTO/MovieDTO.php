<?php

namespace App\DTO;

use Illuminate\Contracts\Validation\Validator;



class MovieDTO extends AbstractDTO implements InterfaceDTO
{

    public function __construct(
        // public readonly int $genre_id,
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly string $release_date,
        public readonly array $genre_ids
    ) {
        $this->validate();
    }

    public function rules(): array
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

    public function messages(): array
    {
        return [
            'release_date.required' => "Please enter a date release, field is required.",
            'release_date.date_format' => "Please enter a valid format date Y-m-d for release, ok.",
            'title.required' => 'Movie title is required.',
            'genre_ids.array' => 'Please enter a array for genre_ids.',
            'genre_ids.required' => 'Please enter one or more genre_ids, field is required.'
        ];
    }

    public function validator(): Validator
    {
        return validator(
            $this->toArray(),
            $this->rules(),
            $this->messages()
        );
    }

    public function validate(): array
    {
        return $this->validator()->validate();
    }
}
