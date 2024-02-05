<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\ApiReadExampleFacade;
use App\Helpers\ApiReadExampleHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ExternalApiController extends Controller
{
    // public function index()
    // {
    //     return Http::withHeaders(['Authorization' => 'Bearer  '])
    //         ->get('https://jsonplaceholder.typicode.com/posts')
    //         ->json();
    // }

    // public function index()
    // {
    //     return (new ApiReadExampleHelper())->getApi()
    //         ->get('https://jsonplaceholder.typicode.com/posts')
    //         ->json();
    // }

    public function __invoke()
    {
        return ApiReadExampleFacade::get('/posts')->json();
    }
}
