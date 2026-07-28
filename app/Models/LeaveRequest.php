<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_type',
        'applicant_id',
        'applicant_name',
        'leave_type',
        'start_date',
        'end_date',
        'reason',
        'status',
        'rejection_reason',
    ];
}
