<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
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
        if (Auth::user()->hasPermission('ManageUnits')) {
            if(request()->ajax()){
                $sortBy = "id";
                $sortDirection = "ASC";
                $data = Unit::orderBy($sortBy, $sortDirection)->get();
                return response()->json([
                    'success' => true,
                    'data' => $data
                ]);             
            }else{
                return view('units');               
            }

        } else {
            $message = "Nincs jogosultsága!";
            return view('denied', compact(['message']));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'access' => Auth::user()->hasPermission('ManageUnits'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('ManageUnits')) {
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = new Unit;
        $record->unit_name =  $request->add_name;

        $save = $record->save();

        if ($save) {
            $success = true;
            $message = "Hozzáadva!";
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermission('ManageUnits')) {
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = Unit::find($id);
        return response()->json([
            'access' => true,
            'record' => $record,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasPermission('ManageUnits')) {
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = Unit::find($id);
        $record->unit_name =  $request->edit_name;

        $save = $record->save();

        if ($save) {
            $success = true;
            $message = "Módosítva!";
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->hasPermission('ManageUnits')) {
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = Unit::findOrFail($id);


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
