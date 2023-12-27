<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    //use SoftDeletes;
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'permissions';
    public $incrementing = false;

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_permission', 'permission', 'user');
    }


}
