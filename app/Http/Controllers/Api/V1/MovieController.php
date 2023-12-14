<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MovieResource;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MovieResource::collection(Movie::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return $request->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'max:255',
                'release_date' => 'required|date_format:Y-m-d'
                // 'value' => 'required|numeric|between:1,5'
            ]);

            if ($validator->fails()) {
                // return response()->json(['message' => 'error'], 422);
                return $this->error('Data invalid', 422, $validator->errors(),  $validator->getData());
            }

            $create = Movie::create($validator->validate());

            if ($create) {
                return $this->response('Movie created', 200, $create);
            }
            return $this->error('Movie not created', 400);
        } catch (\Exception $e) {
            return $this->error('Movie not created', 500, (array)$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new MovieResource(Movie::where('id', $id)->first());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title'         => 'required',
                'description'   => 'max:255',
                'release_date'  => 'required|date_format:Y-m-d'
            ]);

            if ($validator->fails()) {
                // return response()->json(['message' => 'error'], 422);
                return $this->error('Data invalid', 422, $validator->errors(),  $validator->getData());
            }

            $validated = $validator->validate();

            $movie = Movie::findOrFail($id);

            $updated = $movie->update([
                'title'         => $validated['title'],
                'description'   => $validated['description'],
                'release_date'  => $validated['release_date']
            ]);

            if ($updated) {
                return $this->response('Movie updated', 200, $movie);
            }

            return $this->error('Movie not updated', 400);
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
            

            $movie = Movie::findOrFail($id);

            $deleted = $movie->delete();

            if ($deleted) {
                return $this->response('Movie deleted', 200, $movie);
            }

            return $this->error('Movie not deleted', 400);
        } catch (\Exception $e) {
            return $this->error('Movie not deleted', 500, (array)$e->getMessage());
        }
    }
}