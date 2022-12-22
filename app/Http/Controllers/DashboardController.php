<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin_dashboard_page(Request $request)
    {
        return view('be_page.dashboard');
    }
}
