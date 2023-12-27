<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Email;
use App\Models\Company;
use Carbon\Carbon;
use DateTime;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function check()
    {
        return response()->json([
            "status" => Auth::check(),
            "username" => Auth::user()->name,
            "userid" => Auth::user()->id
        ]);
    }

    /**  
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.register');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors(),
                "noverify" => false,
                "message" => "Helytelen bejelentkezési adatok!"
            ]);
        } else {
            if (Auth::attempt($request->only(["email", "password"]))) {
                if (Auth::user()->email_verified_at != null) {
                    return response()->json([
                        "status" => true,
                        "noverify" => false,
                        "isadmin" => Auth::user()->hasPermission('Admin'),
                        "name" => Auth::user()->name
                    ]);
                } else {
                    $codevalidator = Validator::make($request->all(), [
                        'verifycode' => 'required|min:8|max:8'
                    ]);
                    if ($codevalidator->fails()) {
                        $status = true;
                        Auth::logout();
                        if (!Auth::check()) {
                            $status = false;
                            return response()->json([
                                "status" => $status,
                                "noverify" => true,
                                "errors" => $validator->errors(),
                                "message" => "Még nem erősítette meg az email címét, ellenőrizze a leveleit!"
                            ]);
                        }
                    } else {
                        $hashIsCorrect = Hash::check($request->verifycode, Auth::user()->verify_hash);
                        if ($hashIsCorrect) {
                            $thisuser = User::where('id', Auth::user()->id)->first();
                            $thisuser->email_verified_at = now();
                            $thisuser->verify_hash = null;
                            $save = $thisuser->save();
                            if ($save) {
                                return response()->json([
                                    "status" => true,
                                    "noverify" => false,
                                    "name" => Auth::user()->name
                                ]);
                            }
                        } else {
                            $status = true;
                            Auth::logout();
                            if (!Auth::check()) {
                                $status = false;
                                return response()->json([
                                    "status" => $status,
                                    "noverify" => true,
                                    "message" => "Helytelen megerősítő kódot adott meg!"
                                ]);
                            }
                        }
                    }
                }
            } else {
                return response()->json([
                    "status" => false,
                    "noverify" => false,
                    "errors" => ["Invalid credentials"],
                    "message" => "Helytelen bejelentkezési adatok!"
                ]);
            }
        }
    }

    public function verifyCodeResend(Request $request)
    {

        $expminutes = Company::where('app_name',config('app.name'))->first()->email_expiration_time;

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors(),
                "noverify" => true,
                "message" => "Helytelen bejelentkezési adatok!"
            ]);
        }
        if (Auth::attempt($request->only(["email", "password"]))) {
            if (Auth::user()->email_verified_at != null) {
                Auth::logout();
                return response()->json([
                    "status" => true,
                    "noverify" => true,
                    "message" => "Már vissza van igazolva az email címe!"
                ]);
            } else {
                $verify_hash = Str::random(8);
                $thisuser = User::where('id', Auth::user()->id)->first();

                if (is_null($thisuser->verify_hash_expiration)) {
                    $ready = true;
                } else {
                    $expire = new Carbon($thisuser->verify_hash_expiration);
                    $expire->addMinutes($expminutes);
                    $now = Carbon::now()->setTimezone('Europe/Stockholm');

                    if ($now < $expire) {
                        return response()->json([
                            "status" => false,
                            "message" => "Ilyen gyakran nem kérhet megerősítő kódot!"
                        ]);
                    }
                    $ready = true;
                }

                $thisuser->verify_hash = Hash::make($verify_hash);
                $thisuser->verify_hash_expiration = now();
                $save = $thisuser->save();
                $status = false;
                if ($save) {
                    $status = Email::loginVerify($thisuser->email, $verify_hash);
                }
                Auth::logout();
                $message = "";
                if ($status) {
                    $message = "Sikeresen elküldtük az új megerősítő kódot!";
                } else {
                    $message = "Nem sikerült a kódot újra kiköldeni, próbálja később!";
                }
                return response()->json([
                    "status" => $status,
                    "noverify" => true,
                    "message" => $message
                ]);
            }
        }
    }

    public function forgotPassCodeSend(Request $request)
    {
        $expminutes = Company::where('app_name',config('app.name'))->first()->email_expiration_time;

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors(),
                "message" => "Helytelen email cím!"
            ]);
        }

        $ready = false;
        $user = User::where('email', $request->email)->first();
        if (is_null($user->forgot_hash_expiration)) {
            $ready = true;
        } else {
            $expire = new Carbon($user->forgot_hash_expiration);
            $expire->addMinutes($expminutes);
            $now = Carbon::now()->setTimezone('Europe/Stockholm');


            if ($now < $expire) {
                return response()->json([
                    "status" => false,
                    "message" => "Ilyen gyakran nem küldhet új emlékeztető email-t!"
                ]);
            }
            $ready = true;
        }

        if ($ready) {

            $message = "";
            $verify_hash = Str::random(64);
            $user->forgot_hash = Hash::make($verify_hash);
            $user->forgot_hash_expiration = now();
            $save = $user->save();
            if ($save) {
                $status = Email::forgotPassCode($user->email, $user->id, $verify_hash);
                if ($status) {
                    $message = "A visszaállításhoz szükséges levelet elküldtük!";
                } else {
                    $message = "A levél kiküldése sikertelen, próbálja később!";
                }
                return response()->json([
                    "status" => $status,
                    "message" => $message
                ]);
            }
        }
    }

    public function forgotPassChange(Request $request)
    {

        $id = $request->id;
        $hash = $request->hash;

        $expminutes = Company::where('app_name',config('app.name'))->first()->email_expiration_time;
        $ready = 0;
        if ($user = User::where('id', $request->id)->first()) {
            if (is_null($user->forgot_hash_expiration)) {
                $ready = 1;
            } else {
                $expire = new Carbon($user->forgot_hash_expiration);
                $expire->addMinutes($expminutes);
                $now = Carbon::now()->setTimezone('Europe/Stockholm');

                if ($now < $expire) {
                    $ready = 1;
                } else {
                    $ready = 0;
                }
            }
        }

        return view('reset', compact(['id', 'hash', 'ready']));
    }

    public function saveNewPass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'newpass' => 'min:6|required_with:newpass2|same:newpass',
            'newpass2' => 'min:6',
            'userid' => 'required',
            'hash' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "errors" => $validator->errors(),
                "noverify" => false,
                "message" => "Helytelen adatok!"
            ]);
        }

        $expminutes = Company::where('app_name',config('app.name'))->first()->email_expiration_time;
        $ready = false;
        if ($user = User::where('id', $request->userid)->first()) {
            if (is_null($user->forgot_hash_expiration)) {
                $ready = true;
            } else {
                $expire = new Carbon($user->forgot_hash_expiration);
                $expire->addMinutes($expminutes);
                $now = Carbon::now()->setTimezone('Europe/Stockholm');

                if ($now < $expire) {
                    $ready = true;
                } else {
                    $ready = false;
                    return response()->json([
                        "success" => false,
                        "message" => "Sajnos lejárt a kérelem érvényessége!"
                    ]);
                }
            }
        } else {
            return response()->json([
                "success" => false,
                "message" => "Nem tudtuk azonosítani a felhasználót!"
            ]);
        }


        if (Hash::check($request->hash, $user->forgot_hash)) {

            $user->password = Hash::make($request->newpass);
            $user->forgot_hash = null;
            $save = $user->save();

            if($save){
                return response()->json([
                    "success" => true,
                    "message" => "Új jelszava beállítva!"
                ]);
            }else{
                return response()->json([
                    "success" => false,
                    "message" => "Váratlan hiba történt"
                ]);
            }

        } else {
            return response()->json([
                "success" => false,
                "message" => "Hibás helyreállító link!"
            ]);
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'reg_name' => 'required|min:3|max:64',
            'reg_email' => 'required|email|',
            'reg_pass' => 'min:6|required_with:reg_pass2|same:reg_pass',
            'reg_pass2' => 'min:6',
            'reg_city' => 'required',
            'reg_inv_name' => 'required|min:3|max:64',
            'reg_inv_postal' => 'required|min:3|max:20',
            'reg_inv_city' => 'required|min:3|max:64',
            'reg_inv_address' => 'required|min:3|max:64',
            'reg_accept' => 'required'
        ]);

        if (User::where('email', $request->reg_email)->first()) {
            return response()->json([
                "success" => false,
                "errors" => "",
                "message" => "Már van regisztrálva ilyen email cím!"
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "errors" => $validator->errors(),
                "message" => "Helytelen vagy hiányos regisztrációs adatok!"
            ]);
        }

        if (User::where('email', $request->reg_email)->first()) {
            return response()->json([
                "success" => false,
                "errors" => "",
                "message" => "Már van regisztrálva ilyen email cím!"
            ]);
        }

        $record = new User;
        $record->name =  $request->reg_name;
        $record->email =  $request->reg_email;
        $record->location =  $request->reg_city;
        $record->inv_name =  $request->reg_inv_name;
        $record->inv_postal =  $request->reg_inv_postal;
        $record->inv_city =  $request->reg_inv_city;
        $record->inv_address = $request->reg_inv_address;
        $record->password = Hash::make($request->reg_pass);
        $verify_hash = Str::random(8);
        $record->verify_hash = Hash::make($verify_hash);

        $save = $record->save();

        if ($save) {
            Email::loginVerify($record->email, $verify_hash);
            $success = true;
            $message = "Utolsó lépésben erősítse meg " . $record->email . " email címét a kiküldött levélben található kóddal! (Ha nem találja, ellenőrizze a levélszemét mappát is!)";
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
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout()
    {
        //Session::flush();
        Auth::logout();
        $status = false;
        if (!Auth::check()) {
            $status = true;
        }

        return response()->json([
            "status" => $status,
        ]);
    }
}
