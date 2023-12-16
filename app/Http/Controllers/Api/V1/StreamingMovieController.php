<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Streaming;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class StreamingMovieController extends Controller
{

    use HttpResponses;

    public function create(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'streaming_id' => 'required|exists:App\Models\Streaming,id',
                    'movie_ids' => 'required|array|exists:App\Models\Movie,id'
                ],
                [
                    'streaming_id.required' => "Please enter a streaming_id, field is required.",
                    'streaming_id.exists' => "Please enter a valid streaming_id.",
                    'movie_ids.array' => 'Please enter a array for movie_ids.',
                    'movie_ids.required' => 'Please enter one or more movie_ids, field is required.',
                    'movie_ids.exists' => "Please enter a valid movie_ids.",
                ]
            );

            if ($validator->fails()) {
                return $this->error(
                    'Please verify this errors',
                    422,
                    $validator->errors(),
                    $validator->getData()
                );
            }

            $Streaming = new Streaming();
            $result = $Streaming->getStreaming(data_get($validator->validate(), 'streaming_id'));

            if (!$result) return $this->error("No query results.", 202);


            if ($genreIds = data_get($validator->validate(), 'movie_ids')) {
                $result->movies()->sync($genreIds);
            }

            return $this->response('Movie vinculad with streaming', 201);
        } catch (\Exception $e) {
            return $this->error('Streaming not created', 500, (array)$e->getMessage());
        }
    }
}
