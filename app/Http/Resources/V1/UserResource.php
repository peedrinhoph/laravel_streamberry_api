<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'name' => $this->name,
            'email' => $this->email,
            'month' => Carbon::parse($this->created_at)->format('m'),
            'year' => Carbon::parse($this->created_at)->format('Y'),
            'since' => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
