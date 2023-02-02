<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Dashboardcontroller extends Controller
{
    public function index()
    {
        if (Auth::user()->name == 'admin') {
            # code...
            return redirect(route('dashboard.admin'));
        }
    }
}
