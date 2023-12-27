<?php

namespace App\Http\Controllers;

use App\Models\UserPermission;
use Illuminate\Http\Request;

use App\Models\RolePermission;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getUserPermission($user)
    {
        if (Auth::user()->hasPermission('ManageUsers')) {

            $sortBy = "permission_name";
            $sortDirection = "ASC";

            $data = Permission::all();
            foreach ($data as $d) {
                if (UserPermission::where('user', $user)->where('permission', '=', $d->id)->first()) {
                    $can = true;
                } else {
                    $can = false;
                }
                $d->setAttribute('can', $can);
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

    public function index()
    {
        //
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
        if (Auth::user()->hasPermission('ManageUsers')) {

            $message = "";

            if (!User::where('id', $request->user)->first() || !Permission::where('id', $request->permission)->first()) {
                return response()->json([
                    'access' => true,
                    'message' => "Nem valid hivatkozás! Nem teljesíthető művelet!",
                    'success' => false
                ]);
            }

            if ($request->checked == 1) {
                if (!UserPermission::where('user', $request->user)->where('permission', '=', $request->permission)->first()) {
                    $item = new UserPermission;
                    $item->user = $request->user;
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
                $items = UserPermission::where('user', $request->user)->where('permission', '=', $request->permission)->get();
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

            if (UserPermission::where('user', $request->user)->where('permission', '=', $request->permission)->first()) {
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
     * @param  \App\Models\UserPermission  $userPermission
     * @return \Illuminate\Http\Response
     */
    public function show(UserPermission $userPermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserPermission  $userPermission
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPermission $userPermission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserPermission  $userPermission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPermission $userPermission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserPermission  $userPermission
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPermission $userPermission)
    {
        //
    }
}
