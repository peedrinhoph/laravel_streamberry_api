<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use App\Models\MovieRating;
use App\Models\StreamingMovie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    private function column($request, $column): bool
    {
        if (!$request->has('columns')) return true;

        return str($request->get('columns'))->contains($column);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $streamings_release = $this->streamings()->count();
        $vote_total         = $this->vote()->count();
        $vote_average       = $this->vote()->avg('value');
        $genries            = implode(", ", $this->genries()->get()->pluck('description')->toArray());

        return [
            'movie' => [
                'movie_id'      => $this->when(
                    $this->column($request, 'id'),
                    $this->id
                ),
                'title'         => $this->title,
                'description'   => $this->description,
                'month'         => Carbon::parse($this->release_date)->format('m'),
                'year'          => Carbon::parse($this->release_date)->format('Y'),
                'since'         => Carbon::parse($this->release_date)->diffForHumans(),
                'vote_average'  => number_format($vote_average, 1) ?? 0,
                'vote_total'    => number_format($vote_total) ?? 0,
                'vote_total_using_loadCount'   => $this->whenCounted('vote'),
                'streamings_release'  => number_format($streamings_release) ?? 0,
                'release_streamings'  => $this->whenCounted('streamings') ?? 0,
                'genries_string' => $genries
            ],

            'vote'          => MovieRatingResource::collection($this->whenLoaded('vote')),
            'genries'       => GenrieResource::collection($this->whenLoaded('genries')),
            'streamings'    => StreamingResource::collection($this->whenLoaded('streamings')),
        ];
    }
}
