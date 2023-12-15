<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MovieResource;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Http\Request\MovieStoreRequest;
use App\Models\MovieRating;

class MovieController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    private MovieStoreRequest $movieStoreRequest;

    public function __construct()
    {
        $this->movieStoreRequest = new MovieStoreRequest();
    }

    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 25;

        $movies = Movie::with(['genries', 'vote']);

        return MovieResource::collection($movies->paginate($pageSize));
        // return MovieResource::collection(Movie::with('movie_genre')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $movie = $request->only([
                'genre_id',
                'title',
                'description',
                'release_date',
                'genre_ids'
            ]);

            $validator = Validator::make(
                $movie,
                $this->movieStoreRequest->rules(),
                $this->movieStoreRequest->messages()
            );

            // $validator = Validator::make($request->all(), [
            //     'genre_id'      => 'required|array',
            //     'title'         => 'required',
            //     'description'   => 'max:255',
            //     'release_date'  => 'required|date_format:Y-m-d'
            //     // 'value' => 'required|numeric|between:1,5'
            // ]);

            if ($validator->fails()) {
                return $this->error(
                    'Please verify this errors',
                    422,
                    $validator->errors(),
                    $validator->getData()
                );
            }

            $create = Movie::create($validator->validate());

            // $movie = Movie::find($create->id);

            // if (!is_array($validator->attributes()['genre_ids'])) throw new Exception('genre_ids is not an array');

            // $movie->genries()->sync($validator->attributes()['genre_ids']);

            // // foreach ($validator->attributes()['genre_id'] as $value) {
            // //     $movie->genries()->attach($value);
            // // }

            if (!$create) return $this->error('Movie not created', 202);

            if ($genreIds = data_get($validator->attributes(), 'genre_ids')) {
                $create->genries()->sync($genreIds);
            }

            return $this->response('Movie created', 201, new MovieResource($create->load('genries')));
        } catch (\Exception $e) {
            return $this->error('Movie not created', 500, (array)$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $Movie = new Movie();
            $Vote = new MovieRating();
            
            $result = $Movie->getMovie($id);
            $result['vote_average'] = $Vote->vote_average($id);

            if (empty($result)) {
                return $this->response('No queries result', 201);
            }

            return new MovieResource($result->loadMissing(['genries', 'vote']));
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
                'genre_id',
                'title',
                'description',
                'release_date',
                'genre_ids'
            ]);

            $validator = Validator::make(
                $movie,
                $this->movieStoreRequest->rules(),
                $this->movieStoreRequest->messages()
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

            $Movie = new Movie();
            $result = $Movie->getMovie($id);

            if (!$result) return $this->error("No query results for params {$id}.", 202);

            $updated = $result->update([
                'title'         => data_get($validate, 'title'),
                'description'   => data_get($validate, 'description'),
                'release_date'  => data_get($validate, 'release_date')
            ]);

            if (!$updated) return $this->error('Movie not updated', 202);

            if ($genreIds = data_get($validate, 'genre_ids')) {
                $result->genries()->sync($genreIds);
            }
            return $this->response('Movie updated', 200, $result);
        } catch (\Exception $e) {
            return $this->error('Movie not updated', 500, (array)$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {


            $Movie = new Movie();
            $result = $Movie->getMovie($id);

            if (!$result) return $this->error("No query results for params {$id}.", 202);

            $result->genries()->detach();
            $deleted = $result->delete();

            if ($deleted) {
                return $this->response('Movie deleted', 200, $result);
            }

            return $this->error('Movie not deleted', 202);
        } catch (\Exception $e) {
            return $this->error('Movie not deleted', 500, (array)$e->getMessage());
        }
    }
}
