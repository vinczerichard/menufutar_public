<?php

namespace App\Http\Controllers;

use App\Models\RolePermission;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getRolePermission($role)
    {
        if (Auth::user()->hasPermission('ManageRoles')) {

            $sortBy = "permission_name";
            $sortDirection = "ASC";

            $data = Permission::all();
            foreach ($data as $d) {
                if (RolePermission::where('role', $role)->where('permission', '=', $d->id)->first()) {
                    $hasrole = true;
                } else {
                    $hasrole = false;
                }
                $d->setAttribute('hasrole', $hasrole);
            }

            return response()->json([
                'access' => true,
                'data' => $data,
                'success' => true
            ]);
        } else {
            return response()->json([
                'access' => false,
                'data' => null,
                'success' => true
            ]);
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
        if (Auth::user()->hasPermission('ManageRoles')) {

            $message = "";

            if (!Role::where('id', $request->role)->first() || !Permission::where('id', $request->permission)->first()) {
                return response()->json([
                    'access' => true,
                    'message' => "Nem valid hivatkozás! Nem teljesíthető művelet!",
                    'success' => false
                ]);
            }

            if ($request->checked == 1) {
                if (!RolePermission::where('role', $request->role)->where('permission', '=', $request->permission)->first()) {
                    $item = new RolePermission;
                    $item->role = $request->role;
                    $item->permission = $request->permission;
                    $save = $item->save();

                    if ($save) {
                        $success = true;
                        $message = "Módosítva!";
                    } else {
                        $success = false;
                        $message = "Váratlan hiba történt! Nem sikerült módosítani.";
                    }
                }
            } else {
                $items = RolePermission::where('role', $request->role)->where('permission', '=', $request->permission)->get();
                $message = "Módosítva!";
                $success = true;
                foreach ($items as $item) {
                    $save = $item->delete();
                    if (!$save) {
                        $success = false;
                        $message = "Váratlan hiba történt! Nem sikerült módosítani.";
                    }
                }
            }

            if (RolePermission::where('role', $request->role)->where('permission', '=', $request->permission)->first()) {
                $status = true;
            } else {
                $status = false;
            }

            return response()->json([
                'access' => true,
                'status' => $status,
                'message' => $message,
                'success' => true
            ]);
        } else {
            return response()->json([
                'access' => false,
                'success' => true
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RolePermission  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RolePermission $id)
    {
        if (!Auth::user()->hasPermission('ManageRoles')) {
            return response()->json([
                'access' => false,
                'data' => NULL
            ]);
        }

        $data = RolePermission::where('Role', $id)->get();
        return response()->json([
            'access' => true,
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RolePermission  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(RolePermission $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RolePermission  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RolePermission $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RolePermission  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RolePermission $id)
    {
        //
    }
}
