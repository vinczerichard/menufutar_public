<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class DeliveryRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('can:isAdmin');
    }

    public function index()
    {

        //$news = Address::whereNull('sortnumber')->get();
        $news = Address::whereNull('sortnumber')->orWhere(function ($query) {
            $query->where('sortnumber', 0);
        })->get();
        $ordered = Address::where('sortnumber', '!=', null)->where('sortnumber', '>', 0)->get();
        return view('deliveryroute', compact(['news', 'ordered']));
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
        $record = Address::findOrFail($request->id);
        $record->sortnumber = $request->value;
        $success = $record->save();

        return response()->json([
            'data' => $record,
            'success' => $success
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
