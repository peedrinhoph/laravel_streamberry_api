<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Genrie;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Request\GenreStoreRequest;
use App\Http\Resources\V1\GenrieResource;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    private GenreStoreRequest $genreStoreRequest;

    public function __construct()
    {
        $this->genreStoreRequest = new GenreStoreRequest();
    }

    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 25;

        return GenrieResource::collection(Genrie::paginate($pageSize));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $movie = $request->only([
                'description'
            ]);

            $validator = Validator::make(
                $movie,
                $this->genreStoreRequest->rules(),
                $this->genreStoreRequest->messages()
            );

            if ($validator->fails()) {
                return $this->error(
                    'Please verify this errors',
                    422,
                    $validator->errors(),
                    $validator->getData()
                );
            }

            $create = Genrie::create($validator->validate());

            if ($create) {
                return $this->response('Genrie created', 201, new GenrieResource($create));
            }

            return $this->error('Genrie not created', 202);
        } catch (\Exception $e) {
            return $this->error('Genrie not created', 500, (array)$e->getMessage());
        }
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

            return new GenrieResource($result);
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
                'description'
            ]);

            $validator = Validator::make(
                $movie,
                ['description'   => 'required'],
                $this->genreStoreRequest->messages()
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

            $Genrie = new Genrie();
            $result = $Genrie->getGenre($id);

            if (!$result) return $this->error("No query results for params {$id}.", 202);

            $updated = $result->update([
                'description'   => data_get($validate, 'description')
            ]);

            if ($updated) {
                return $this->response('Genre updated', 200, $result);
            }

            return $this->error('Genre not updated', 202);
        } catch (\Exception $e) {
            return $this->error('Genre not updated', 500, (array)$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {


            $Genre = new Genrie();
            $result = $Genre->getGenre($id);

            if (!$result) return $this->error("No query results for params {$id}.", 202);

            if ($result->movies->count()) return $this->error("Genre not this deleteted, verify the relationship with movies.", 202);

            $deleted = $result->delete();

            if ($deleted) {
                return $this->response('Genre deleted', 200, $result);
            }

            return $this->error('Genre not deleted', 202);
        } catch (\Exception $e) {
            return $this->error('Genre not deleted', 500, (array)$e->getMessage());
        }
    }
}
