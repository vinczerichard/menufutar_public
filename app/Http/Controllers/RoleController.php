<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class RoleController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasPermission('ManageRoles')){

            if(request()->ajax()){
                $sortBy = "role_name";
                $sortDirection = "ASC";
                $data = Role::orderBy($sortBy, $sortDirection)->get();
                return response()->json([
                    'success' => true,
                    'data' => $data
                ]);    
            }else{
                return view('roles');
            }

        }else{
            $message = "Nincs jogosultsága!";
            return view('denied', compact(['message']));
        }
    }

    public function getData(Request $request)
    {
        if(Auth::user()->hasPermission('ManageRoles')){
            $sortBy = $request->input('sortBy');
            $sortDirection = $request->input('sortDirection');

            $data = Role::orderBy($sortBy, $sortDirection)->get();


            return response()->json([
                'record' => $data,
                'success' => true
            ]);

        }else{
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
                'access' => Auth::user()->hasPermission('ManageRoles'),
            ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Responseadd_role
     */
    public function store(Request $request)
    {

        if(!Auth::user()->hasPermission('ManageRoles')){
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);

        }

        $record = new Role;
        $record->role_name =  $request->add_name;

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
        if(!Auth::user()->hasPermission('ManageRoles')){
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = Role::find($id);
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
        if(!Auth::user()->hasPermission('ManageRoles')){
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = Role::find($id);
        $record->role_name =  $request->edit_name;

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if(!Auth::user()->hasPermission('ManageRoles')){
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = Role::findOrFail($id);


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
