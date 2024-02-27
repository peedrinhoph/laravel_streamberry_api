<?php

namespace App\Http\Controllers;

use NFePHP\DA\NFe\Danfe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $x = 'teste';
        return response($x);
    }
}
