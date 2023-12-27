<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //session()->forget('location');
        return view('index');
    }

    public function getlocations()
    {

        $locations = Location::all();
        $currentlocation = session()->get('location');
        $loggedIn = Auth::check();
        return response()->json([
            'locations' => $locations,
            'currentlocation' => $currentlocation,
            'loggedIn' => $loggedIn
        ]);
    }

    public function purgelocation()
    {
        session()->forget('location');
        return view('index');
    }



    public function change($id)
    {
        if(Location::where('id','=',$id)->first()){
            session()->put('location', $id);
            $session = session()->get('location');
            $success=true;
            $message="";
        }else{
            $success=false;
            $message="Nincs ilyen város a rendszerünkben!";
        }
       

        return response()->json([
            'id' => $id,
            'session' => $session,
            'success' => true,
            'message' => $message
        ]);
    }

    public function miskolc()
    {
        $location = "Miskolc";
        if(Location::where('id','=',$location)->first()){
            session()->put('location', $location);
            return view('home');
        }else{
            return view('location');
        }
    }

    public function kazincbarcika()
    {
        $location = "Kazincbarcika";
        if(Location::where('id','=',$location)->first()){
            session()->put('location', $location);
            return view('home');
        }else{
            return view('location');
        }
    }

    public function eger()
    {
        $location = "Eger";
        if(Location::where('id','=',$location)->first()){
            session()->put('location', $location);
            return view('home');
        }else{
            return view('location');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
