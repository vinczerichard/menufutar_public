<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserPermission;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'user_permission', 'user', 'permission');
    }

    public function hasPermission($permissionTo)
    {
        if (UserPermission::where('user', $this->id)->where('permission', 'Admin')->first()) {
            return true;
        }

        $hasAccess = false;

        if (UserPermission::where('user', $this->id)->where('permission', $permissionTo)->first()) {
            $hasAccess = true;
        } else {
            $hasAccess = false;
        }



        return $hasAccess;
    }
}
