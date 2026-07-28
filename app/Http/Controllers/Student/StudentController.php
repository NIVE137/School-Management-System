<?php

namespace App\Http\Controllers\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
   public function studentprofile()
    {
        $student = Auth::guard('student')->user();

        return view('Student.studentprofile', compact('student'));
    }

}
