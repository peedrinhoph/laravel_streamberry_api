<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class ApiReadExampleHelper
{
    private $apiRead;
    public function __construct()
    {
        $this->apiRead  = Http::withHeaders([
            'Authorization' => 'Bearer ',
        ]);
    }

    public function getApi()
    {
        return $this->apiRead;
    }
}
