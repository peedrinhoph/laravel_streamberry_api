<?php

namespace App\Http\Controllers;

use App\Facades\ApiReadExampleFacade;
use App\Helpers\ApiReadExampleHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
{
    public function show()
    {
        return ApiReadExampleFacade::get('/posts')->json();
    }
}
