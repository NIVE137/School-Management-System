<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    protected $fillable = [
        'staff_name',
        'staff_id',
        'mobile',
        'email',
        'password',
        'role_name',
        'address',
        'dob',
        'status',
        'image',
    ];

    protected $hidden = [
        'password',
    ];
}
