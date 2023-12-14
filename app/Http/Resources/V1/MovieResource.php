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
        // return parent::toArray($request);
        // foreach ($this->genries as $genre) {
        //     $genre->description;
        // }

        return [
            'title'         => $this->title,
            'description'   => $this->description,
            'month'         => Carbon::parse($this->release_date)->format('m'),
            'year'          => Carbon::parse($this->release_date)->format('Y'),
            'since'         => Carbon::parse($this->release_date)->diffForHumans(),
            'genries'       =>  $this::genries()->get()
        ];
    }
}
