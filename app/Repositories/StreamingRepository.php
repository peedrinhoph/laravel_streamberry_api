<?php

namespace App\Repositories;

use App\Models\Streaming;

class StreamingRepository extends BaseRepository
{

    public function create(array $attributes)
    {

        return Streaming::create($attributes);
    }

    public function update($streaming, array $attributes)
    {

        $Streaming = new Streaming();
        $result = $Streaming->getStreaming($streaming);

        if (!$result) return false;

        $result->update([
            'name'   => data_get($attributes, 'name')
        ]);

        return $attributes;
    }
    
    public function delete($streaming)
    {
    }
}
