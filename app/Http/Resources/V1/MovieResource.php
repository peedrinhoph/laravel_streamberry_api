<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use App\Models\MovieRating;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $Vote = new MovieRating();
        $vote_average = $Vote->vote_average($this->id);

        return [
            'movie' => [
                'movie_id'      => $this->id,
                'title'         => $this->title,
                'description'   => $this->description,
                'month'         => Carbon::parse($this->release_date)->format('m'),
                'year'          => Carbon::parse($this->release_date)->format('Y'),
                'since'         => Carbon::parse($this->release_date)->diffForHumans(),
                'vote_average'  => $vote_average ?? 0,
            ],

            'vote'          => MovieRatingResource::collection($this->whenLoaded('vote')),
            'genries'       => GenrieResource::collection($this->whenLoaded('genries')),
            'streamings'    => StreamingResource::collection($this->whenLoaded('streamings')),
        ];
    }
}
