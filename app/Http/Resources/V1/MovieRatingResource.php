<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieRatingResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'comment' => [
                'rate_id'            => $this->id,
                'value'         => $this->value,
                'comment'       => $this->comment,
                'user_name'     => $this->user_name ? $this->user_name : 'Anonime',
                'user_email'    => $this->user_email ? $this->user_email : ''
            ],
            // 'streaming'         => StreamingResource::collection($this->whenLoaded('streaming')),
        ];
    }
}
