<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = Status::where('name', '=', 'Open')->first();

        $open_tickets = $status->ticket()->count();
        return view('home');
    }

    public function getDataTable(Request $request)
    {
        return true;
    }
}
