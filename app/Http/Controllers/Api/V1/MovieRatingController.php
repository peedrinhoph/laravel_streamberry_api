<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\MovieRating;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Request\MovieRatingStoreRequest;
use App\Http\Resources\V1\MovieRatingResource;

class MovieRatingController extends Controller
{
    use HttpResponses;

    private MovieRatingStoreRequest $movieRatingStoreRequest;

    public function __construct()
    {
        $this->movieRatingStoreRequest = new MovieRatingStoreRequest();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 25;

        return MovieRatingResource::collection(MovieRating::paginate($pageSize));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $movie = $request->only([
                'value',
                'comment',
                'user_name',
                'user_email',
                'movie_id',
                'streaming_id'
            ]);

            $validator = Validator::make(
                $movie,
                $this->movieRatingStoreRequest->rules(),
                $this->movieRatingStoreRequest->messages()
            );

            if ($validator->fails()) {
                return $this->error(
                    'Please verify this errors',
                    422,
                    $validator->errors(),
                    $validator->getData()
                );
            }

            $create = MovieRating::create($validator->validate());

            if (!$create) return $this->error('Comment not created', 202);


            return $this->response('Comment created', 201, new MovieRatingResource($create));
        } catch (\Exception $e) {
            return $this->error('Comment not created', 500, (array)$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $Rating = new MovieRating();
            $result = $Rating->getRating($id);

            if (empty($result)) {
                return $this->response('No queries result', 201);
            }

            return new MovieRatingResource($result);
        } catch (\Exception $e) {
            return $this->error('Error', 500, (array)$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $movie = $request->only([
                'value',
                'comment',
                'user_name',
                'user_email',
                'movie_id',
                'streaming_id'
            ]);

            $validator = Validator::make(
                $movie,
                $this->movieRatingStoreRequest->rules(),
                $this->movieRatingStoreRequest->messages()
            );

            if ($validator->fails()) {
                return $this->error(
                    'Data invalid',
                    422,
                    $validator->errors(),
                    $validator->getData()
                );
            }
            $validate = $validator->validate();

            $Rating = new MovieRating();
            $result = $Rating->getRating($id);

            if (!$result) return $this->error("No query results for params {$id}.", 202);

            $updated = $result->update([
                'value'         => data_get($validate, 'value'),
                'comment'       => data_get($validate, 'comment'),
                'user_name'     => data_get($validate, 'user_name'),
                'user_email'    => data_get($validate, 'user_email'),
                'movie_id'      => data_get($validate, 'movie_id'),
                'streaming_id'  => data_get($validate, 'streaming_id')
            ]);

            if ($updated) {
                return $this->response('Rating updated', 200, $result);
            }

            return $this->error('Rating not updated', 202);
        } catch (\Exception $e) {
            return $this->error('Rating not updated', 500, (array)$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
