<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $table = 'class_rooms';

    protected $fillable = [
        'class_name'
    ];
}