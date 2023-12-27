<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermission extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    //use SoftDeletes;
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'role_permission';

    public function hasPermission($permissionTo)
    {

        if (RolePermission::where('role', $this->id)->where('permission', $permissionTo)->first()) {
            $hasAccess = true;
        } else {
            $hasAccess = false;
        }

        return $hasAccess;
    }

}
