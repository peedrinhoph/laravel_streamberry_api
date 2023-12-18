<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Movie;
use App\Models\Genrie;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MovieResource;
use App\Http\Resources\V1\GenrieResource;

class MovieSearchController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 25;
        // $filters = $request->filter;
        // $posts = Post::query()->paginate($pageSize);

        $movies = Movie::with(['genries', 'vote', 'streamings']);

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
            // $resulta = $result->withCount([
            //     'vote' => function ($query) {
            //         $query->select(DB::raw("avg(value)"));
            //     }
            // ]);
            // dd($resulta);
            if (empty($result)) {
                return $this->response('No queries result', 201);
            }

            return new MovieResource($result->loadMissing(['genries', 'vote', 'streamings']));
        } catch (\Exception $e) {
            return $this->error('Error', 500, (array)$e->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            $pageSize = $request->page_size ?? 25;

            $Movie = new Movie();
            $result = $Movie->retornaMovies($request->all())->paginate($pageSize);
            if (empty($result)) {
                return $this->response('No queries result', 201);
            }

            return MovieResource::collection($result);
        } catch (\Exception $e) {
            return $this->error('Error', 500, (array)$e->getMessage());
        }
    }

    public function release(Request $request)
    {
        try {
            $pageSize = $request->page_size ?? 25;

            $Movie = new Movie();
            $result = $Movie->retornaMoviesPerYear($request->all())->paginate($pageSize);
            if (empty($result)) {
                return $this->response('No queries result', 201);
            }
            
            return MovieResource::collection($result);
        } catch (\Exception $e) {
            return $this->error('Error', 500, (array)$e->getMessage());
        }
    }

    public function genre(Request $request)
    {
        $pageSize = $request->page_size ?? 25;

        return GenrieResource::collection(Genrie::with(['movies'])->paginate($pageSize));
    }
}
