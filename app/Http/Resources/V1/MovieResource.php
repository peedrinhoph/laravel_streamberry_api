<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
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

        // $vote_average = MovieRatingResource::collection($this->whenLoaded('vote'));
        // dd($vote_average->items());
        // foreach ($vote_average as $value) {
        //     var_dump($value);
        // }
        // dd('here');
        
        return [
            'movie' => [
                'title'         => $this->title,
                'description'   => $this->description,
                'month'         => Carbon::parse($this->release_date)->format('m'),
                'year'          => Carbon::parse($this->release_date)->format('Y'),
                'since'         => Carbon::parse($this->release_date)->diffForHumans(),
                'vote_average'  => $this->vote_average ?? 0
            ],

            'genries'       => GenrieResource::collection($this->whenLoaded('genries')),
            'streamings'    => StreamingResource::collection($this->whenLoaded('streamings')),
            'vote'          => MovieRatingResource::collection($this->whenLoaded('vote')),
        ];
    }
}
