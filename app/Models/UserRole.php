<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    //use SoftDeletes;
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $table = 'user_role';
}
