<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
class DashboardController extends Controller
{
    // DashboardController.php
    public function index()
    {
        $hello = "Hello, world!";
        return view('dashboardLog.index', compact('hello'));
    }


}

