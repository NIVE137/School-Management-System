<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    protected $fillable = [
        'image',
        'student_name',
        'student_id',
        'mobile',
        'email',
        'password',
        'class_name',
        'address',
        'dob',
        'parent_name',
        'parent_mobile',
        'status',
        'birth_certificate',
        'aadher',
        'parent_idproof',
        'address_proof',
        'tc',
        'mark_sheet'
    ];

    protected $hidden = [
        'password',
    ];
}