<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\RolePermission;

class PermissionController extends Controller
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
        if(Auth::user()->hasPermission('ManagePermissions')){

            if(request()->ajax()){
                $sortBy = "permission_name";
                $sortDirection = "ASC";
                $data = Permission::orderBy($sortBy, $sortDirection)->get();
                return response()->json([
                    'success' => true,
                    'data' => $data
                ]); 
            }else{
                return view('permissions');
            }

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
                'access' => Auth::user()->hasPermission('ManagePermissions'),
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

        if(!Auth::user()->hasPermission('ManagePermissions')){
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);

        }

        $record = new Permission;

        $record->id =  $request->add_id;
        $record->permission_name =  $request->add_name;

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
        if(!Auth::user()->hasPermission('ManageRoles')){
            return response()->json([
                'access' => false,
                'data' => NULL
            ]);
        }

        $data = Permission::all();
        return response()->json([
            'access' => true,
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermission('ManagePermissions')){
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = Permission::find($id);
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
        if(!Auth::user()->hasPermission('ManagePermissions')){
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = Permission::find($id);
        $record->permission_name =  $request->edit_name;

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

        if(!Auth::user()->hasPermission('ManagePermissions')){
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = Permission::findOrFail($id);


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
