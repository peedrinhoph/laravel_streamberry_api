<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MovieResource;

class MovieRatedController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 25;

        $movies = Movie::with(['genries', 'vote']);

        return MovieResource::collection($movies->paginate($pageSize));
        // return MovieResource::collection(Movie::with('movie_genre')->get());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $Movie = new Movie();

            $result = $Movie->getMovie($id);

            if (empty($result)) {
                return $this->response('No queries result', 201);
            }

            return new MovieResource($result->loadMissing(['genries', 'vote']));
        } catch (\Exception $e) {
            return $this->error('Error', 500, (array)$e->getMessage());
        }
    }
}
