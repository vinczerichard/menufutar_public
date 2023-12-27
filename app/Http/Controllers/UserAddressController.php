<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\AviableStreet;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('myaddresses');
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

        $validator = Validator::make($request->all(), [
            'add_name' => 'required|max:64',
            'add_location' => 'required|max:64',
            'add_city' => 'required|numeric',
            'add_street' => 'required|max:64',
            'add_number' => 'required|max:64',
            'add_description' => 'max:128'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ]);
        }

        $record = new UserAddress;
        $record->address_name =  $request->add_name;
        $record->user_id =  Auth::user()->id;
        $record->location =  $request->add_location;
        $record->postal =  $request->add_city;
        $thiscity = $data = AviableStreet::where('postal',$request->add_city)->first()->city;
        $record->city = $thiscity;
        $record->street =  $request->add_street;
        $record->number =  $request->add_number;
        $record->description =  $request->add_description;

        $save = $record->save();

        if ($save) {
            $success = true;
            $message = "Hozzáadva!";
        } else {
            $success = false;
            $message = "Váratlan hiba történt!";
        }
        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function show($userAddress)
    {
        $success = false;

        $data = UserAddress::where('user_id', Auth::user()->id)->get();
        if(count($data) > 0){
            $success = true;
        }


        return response()->json([
            'data' => $data,
            'success' => $success
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAddress $userAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAddress $userAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = UserAddress::findOrFail($id);

        $save = $record->delete();
        if ($save) {
            $success = true;
            $message = "Törölve";
        } else {
            $success = false;
            $message = "Váratlan hiba történt!";
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
