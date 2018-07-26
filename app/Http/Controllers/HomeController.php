<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   //  public function __construct()
   //  {
   //      $this->middleware('auth');
   //  }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function testitout()
    {
      $output = shell_exec('node ../../../nodediningscript/index.js');
      
      return $output;


    }
}
