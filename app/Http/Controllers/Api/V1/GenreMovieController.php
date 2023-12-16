<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Genrie;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\GenrieResource;

class GenreMovieController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 25;

        $genries = Genrie::with(['movies']);

        return GenrieResource::collection($genries->paginate($pageSize));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $Genre = new Genrie();
            $result = $Genre->getGenre($id);

            if (empty($result)) {
                return $this->response('No queries result', 201);
            }

            return new GenrieResource($result->loadMissing(['movies']));
        } catch (\Exception $e) {
            return $this->error('Error', 500, (array)$e->getMessage());
        }
    }
}
