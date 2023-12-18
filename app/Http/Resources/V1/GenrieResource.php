<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenrieResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'genre' => [
                'genre_id'    => $this->id,
                'description' => $this->description
            ],
            'movies' =>  MovieResource::collection($this->whenLoaded('movies')),
        ];
    }
}
