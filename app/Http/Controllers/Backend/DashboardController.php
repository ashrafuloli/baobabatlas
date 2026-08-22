<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Display Dashboard
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        return view('backend.pages.dashboard.index');
    }
}
