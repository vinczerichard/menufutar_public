<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;


class UserController extends Controller
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
        if (Auth::user()->hasPermission('ManageUsers')) {

            if (request()->ajax()) {
                $sortBy = "id";
                $sortDirection = "ASC";
                $data = User::leftJoin('roles', 'roles.id', '=', 'users.role')
                    ->select(
                        'users.id as id',
                        'users.name as name',
                        'users.email as email',
                        'roles.id as roleid',
                        'roles.role_name as role_name',
                    )->orderBy($sortBy, $sortDirection)->get();
                $roles = Role::all();

                return response()->json([
                    'success' => true,
                    'data' => $data,
                    'roles' => $roles
                ]);
            } else {
                $roles = Role::all();
                return view('users', compact(['roles']));
            }
        } else {
            $message = "Nincs jogosultsága!";
            return view('denied', compact(['message']));
        }
    }

    public function getData(Request $request)
    {
        if (Auth::user()->hasPermission('ManageUsers')) {
            $sortBy = $request->input('sortBy');
            $sortDirection = $request->input('sortDirection');
            $data = User::leftJoin('roles', 'roles.id', '=', 'users.role')
                ->select(
                    'users.id as id',
                    'users.name as name',
                    'users.email as email',
                    'roles.id as roleid',
                    'roles.role_name as role_name',
                )->orderBy($sortBy, $sortDirection)->get();

            return response()->json([
                'record' => $data,
                'success' => true
            ]);
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
            'access' => Auth::user()->hasPermission('ManageUsers'),
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

        if (!Auth::user()->hasPermission('ManageUsers')) {
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = new User;
        $record->name =  $request->add_name;
        $record->email = $request->add_email;
        $record->role = $request->add_role;

        $random_password = Str::random(12);
        $hashed_random_password = Hash::make($random_password);

        $record->password = $hashed_random_password;

        $save = $record->save();

        if ($save) {
            $success = true;
            $message = "Hozzáadva! Első belépéshez a jelszó: " . $random_password;
        } else {
            $success = false;
            $message = "Váratlan hiba történt!";
        }
        return response()->json([
            'access' => true,
            'pwd' => $random_password,
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
        if (!Auth::user()->hasPermission('ManageUsers')) {
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = User::find($id);
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
        if (!Auth::user()->hasPermission('ManageUsers')) {
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = User::find($id);
        $record->name =  $request->edit_name;
        $record->email = $request->edit_email;
        $record->role = $request->edit_role;

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

        if (!Auth::user()->hasPermission('ManageUsers')) {
            return response()->json([
                'access' => false,
                'record' => NULL
            ]);
        }

        $record = User::findOrFail($id);


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
