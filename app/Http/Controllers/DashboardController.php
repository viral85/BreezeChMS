<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Input;
use Redirect;;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Dashboard');
    }

    public function getLogout()
    {
        Auth::logout();

        return Redirect::to('/');
    }
}
