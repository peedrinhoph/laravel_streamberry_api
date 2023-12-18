<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StreamingResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'streaming_id'  => $this->id,
            'name'          => $this->name,
            'movies'        =>  MovieResource::collection($this->whenLoaded('movies')),
        ];
    }
}
