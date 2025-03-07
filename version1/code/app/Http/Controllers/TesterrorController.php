<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesterrorController extends Controller
{
    //
    public function index()
    {
        throw new \Exception("This is a test error!");
    }
}
