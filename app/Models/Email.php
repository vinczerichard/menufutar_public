<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use \App\Mail\LoginVerify;

class Email extends Model
{
    use HasFactory;

    public static function loginVerify($email,$code)
    {
        $data = null;
        $page = URL::to('');
        $subject = "Megerősítő kód";
        $content =
            "
        <h4>Térjen vissza a <b>".$page."</b> oldalra, és bejelentkezésnél adja meg az alábbi egyszer használatos elleőrző kódot:</h4>
        <h3><b>".$code."</b></h3>
        ";

        try {
            Mail::to($email)->send(new LoginVerify($data, $subject, $content));

            return true;

        } catch (\Exception $e) {
            
            return false;

        }
    }

    public static function forgotPassCode($email,$id,$code)
    {

        $expminutes = Company::where('app_name',config('app.name'))->first()->email_expiration_time;

        $data = null;
        $page = URL::to('');
        $subject = "Jelszó visszaállítása";
        $content =
            "
        <h4>Azt a jelzést kaptuk, hogy elfelejtette jelszavát és vissza kívánja állítani. 
        <b class='text-danger'>Fontos: ".$expminutes." perce van a visszaállításra.</b></h4>
        <h5>Amennyiben nem Ön jelezte nincs más teendője, valószínűleg valaki más tévesen adta meg az Ön email címét.</h5>
        <p><a href='" . $page . "/resetpass/" . $id . "/" . $code . "' class='btn btn-outline-primary'>Visszaállítom a jelszavam</a></p>
        ";
        
        try {
            Mail::to($email)->send(new LoginVerify($data, $subject, $content));

            return true;

        } catch (\Exception $e) {
            
            return false;

        }
    }

}
