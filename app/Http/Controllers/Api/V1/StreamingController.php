<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Streaming;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Request\StreamingStoreRequest;
use App\Http\Resources\V1\StreamingResource;
use App\Repositories\StreamingRepository;

class StreamingController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    private StreamingStoreRequest $streamingStoreRequest;

    public function __construct()
    {
        $this->streamingStoreRequest = new StreamingStoreRequest();
    }

    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 25;

        return StreamingResource::collection(Streaming::paginate($pageSize));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, StreamingRepository $streamingRepository)
    {
        try {

            $streaming = $request->only([
                'name'
            ]);

            $validator = Validator::make(
                $streaming,
                $this->streamingStoreRequest->rules(),
                $this->streamingStoreRequest->messages()
            );

            if ($validator->fails()) {
                return $this->error(
                    'Please verify this errors',
                    422,
                    $validator->errors(),
                    $validator->getData()
                );
            }

            $create = Streaming::create($validator->validate());

            if ($create) {
                return $this->response('Streaming created', 201, new StreamingResource($create));
            }

            return $this->error('Streaming not created', 202);
        } catch (\Exception $e) {
            return $this->error('Streaming not created', 500, (array)$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $Streaming = new Streaming();
            $result = $Streaming->getStreaming($id);

            if (empty($result)) {
                return $this->response('No queries result', 201);
            }

            return new StreamingResource($result);
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
                'name'
            ]);

            $validator = Validator::make(
                $movie,
                ['name'   => 'required'],
                $this->streamingStoreRequest->messages()
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

            $Streaming = new Streaming();
            $result = $Streaming->getStreaming($id);

            if (!$result) return $this->error("No query results for params {$id}.", 202);

            $updated = $result->update([
                'name'   => data_get($validate, 'name')
            ]);

            if ($updated) {
                return $this->response('Streaming updated', 200, $result);
            }

            return $this->error('Streaming not updated', 202);
        } catch (\Exception $e) {
            return $this->error('Streaming not updated', 500, (array)$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {


            $Genre = new Streaming();
            $result = $Genre->getStreaming($id);

            if (!$result) return $this->error("No query results for params {$id}.", 202);

            $deleted = $result->delete();

            if ($deleted) {
                return $this->response('Streaming deleted', 200, $result);
            }

            return $this->error('Streaming not deleted', 202);
        } catch (\Exception $e) {
            return $this->error('Streaming not deleted', 500, (array)$e->getMessage());
        }
    }
}
