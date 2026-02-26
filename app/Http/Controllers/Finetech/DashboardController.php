<?php

namespace App\Http\Controllers\Finetech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('finetech.pages.dashboard');
    }
}