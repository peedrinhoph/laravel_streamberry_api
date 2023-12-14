<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {

            return $this->response('Access succeful authorizedd, welcome to Streamberry API', 200, [
                'token' => $request->user()->createToken('streamberry')
            ]);
        }

        return $this->response('Access not authorized', 403);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->response('Access succeful revoged', 200);
    }
}
