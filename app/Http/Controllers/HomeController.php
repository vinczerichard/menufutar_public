<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            if(session()->has('location')){
                return view('home');
            }else{
                if(!empty(Auth::user()->location)){
                    session()->put('location', Auth::user()->location); 
                    return view('home');
                }else{
                    return view('index');
                    // return view('home');
                }
                return view('home');
            }
        }else{
            if(session()->has('location')){
                return view('home');
            }else{
                return view('index');
                // return view('home');
            }
        }
        
    }
}
