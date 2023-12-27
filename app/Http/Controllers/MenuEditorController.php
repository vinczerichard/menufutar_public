<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuType;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Location;
use Illuminate\Support\Facades\Validator;

class MenuEditorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:isAdmin');
    }

    public function index()
    {
        $locations = Location::all();
        $menutypes = MenuType::all();
        return view('menueditor', compact(['locations', 'menutypes']));
    }

    public function getlist(Request $request)
    {
        if(!empty($request->from)){
            $from = $request->from;
        }else{
            $from = "2023-12-01";
        }

        if(!empty($request->to)){
            $to = $request->to;
        }else{
            $to = "2050-12-01";
        }

        $data = Menu::where('delivery_date','>=',$from)->where('delivery_date','<=',$to)
                ->orWhere(function ($query) {
                    $query->whereNull('delivery_date');
                })->orderBy('delivery_date')->get();


        return response()->json([
            'data' => $data,
            'status' => true
        ]);
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
            'add_location' => 'required|max:64',
            'add_menutype' => 'required|max:64',
            'add_delivery_date' => 'required',
            'add_name' => 'required|max:256',
            'add_price' => 'required|numeric',
            'add_orderable' => 'required|numeric|max:1',
            'add_visible' => 'required|numeric|max:1'

        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ]);
        }

        $record = new Menu;
        if(Location::where('id',$request->add_location)->first()){
            $record->location = $request->add_location;
        }
        if(MenuType::where('id',$request->add_menutype)->first()){
            $record->menu_type = $request->add_menutype;
        }
        $record->menu_name = $request->add_name;
        $record->menu_price = $request->add_price;
        $record->delivery_date = $request->add_delivery_date;
        $record->visible = $request->add_visible;
        $record->orderable = $request->add_orderable;

        $save = $record->save();

        if ($save) {
            $success = true;
            $message = "Sikeres mentés!";
        } else {
            $success = false;
            $message = "Váratlan hiba történt!";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
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
        $record = Menu::find($id);
        return response()->json([
            'access' => true,
            'record' => $record,
        ]);
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
        $validator = Validator::make($request->all(), [
            'edit_id' => 'required|numeric',
            'edit_location' => 'required|max:64',
            'edit_menutype' => 'required|max:64',
            'edit_delivery_date' => 'required',
            'edit_name' => 'required|max:256',
            'edit_price' => 'required|numeric',
            'edit_orderable' => 'required|numeric|max:1',
            'edit_visible' => 'required|numeric|max:1'

        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ]);
        }

        $record = Menu::where('id',$request->edit_id)->first();

        if(Location::where('id',$request->edit_location)->first()){
            $record->location = $request->edit_location;
        }else{
            $record->location = null;
        }
        if(MenuType::where('id',$request->edit_menutype)->first()){
            $record->menu_type = $request->edit_menutype;
        }else{
            $record->menu_type = null;
        }
        $record->menu_name = $request->edit_name;
        $record->menu_price = $request->edit_price;
        $record->delivery_date = $request->edit_delivery_date;
        $record->visible = $request->edit_visible;
        $record->orderable = $request->edit_orderable;

        $save = $record->save();

        if ($save) {
            $success = true;
            $message = "Sikeres mentés!";
        } else {
            $success = false;
            $message = "Váratlan hiba történt!";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Menu::findOrFail($id);

        $save = $record->delete();
        if ($save) {
            $success = true;
            $message = "Törölve";
        } else {
            $success = false;
            $message = "Váratlan hiba történt!";
        }

        return response()->json([
            'access' => true,
            'success' => $success,
            'message' => $message,
        ]);
    }
}
