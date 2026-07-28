<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class StudentAuthController extends Controller
{
    public function studentlogin(Request $request)
{
    // First time opening the page
    if (!$request->has('email')) {
        return view('Student.studentlogin');
    }

    DB::beginTransaction();

    try {

        // Validate Request
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        Log::info('Student Login Attempt', [
            'email' => $request->email,
            'ip'    => $request->ip(),
            'time'  => now(),
        ]);

        // Find Student
        $student = Student::where('email', $request->email)->first();

        if (!$student) {

            Log::warning('Student Login Failed - Email Not Found', [
                'email' => $request->email,
                'ip'    => $request->ip(),
            ]);

            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Email does not exist.'
            ]);
        }

        // Check Status
        if ($student->status != 'active') {

            Log::warning('Student Login Failed - Inactive Account', [
                'student_id' => $student->id,
                'email'      => $student->email,
            ]);

            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Your account is inactive. Please contact the administrator.'
            ]);
        }

        // Check Password
        if (!Hash::check($request->password, $student->password)) {

            Log::warning('Student Login Failed - Incorrect Password', [
                'student_id' => $student->id,
                'email'      => $student->email,
                'ip'         => $request->ip(),
            ]);

            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Incorrect password.'
            ]);
        }

        // Login Student
        Auth::guard('student')->login($student);
        $request->session()->regenerate();

        DB::commit();

        Log::info('Student Login Successful', [
            'student_id' => $student->id,
            'email'      => $student->email,
            'ip'         => $request->ip(),
            'time'       => now(),
        ]);

        return response()->json([
            'status'       => 'success',
            'message'      => 'Login Successful.',
            'redirect_url' => route('studentprofile')
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        Log::error('Student Login Error', [
            'message' => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile(),
            'ip'      => $request->ip(),
        ]);

        return response()->json([
            'status'  => 'error',
            'message' => 'Something went wrong. Please try again.'
        ]);
    }
}
    public function studentlayout()
    {
        return view('studentlayout');
    }

    public function studentforgetpassword()
    {
        return view('Student.studentforgetpassword');
    }
    public function studentcheckEmail(Request $request)
{
    DB::beginTransaction();

    try {

        // Validate Request
        $request->validate([
            'email' => 'required|email'
        ]);

        Log::info('Student Forgot Password - Email Verification Started', [
            'email' => $request->email,
            'ip'    => $request->ip(),
            'time'  => now(),
        ]);

        // Check Student Email
        $student = Student::where('email', $request->email)->first();

        if (!$student) {

            Log::warning('Student Forgot Password - Email Not Found', [
                'email' => $request->email,
                'ip'    => $request->ip(),
            ]);

            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Email does not exist.'
            ]);
        }

        // Store Email in Session
        session([
            'student_reset_email' => $student->email
        ]);

        DB::commit();

        Log::info('Student Forgot Password - Email Verified Successfully', [
            'student_id' => $student->id,
            'email'      => $student->email,
            'ip'         => $request->ip(),
            'time'       => now(),
        ]);

        return response()->json([
            'status'       => 'success',
            'redirect_url' => route('studentcreatenewpassword')
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        Log::error('Student Forgot Password Error', [
            'message' => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile(),
            'ip'      => $request->ip(),
            'time'    => now(),
        ]);

        return response()->json([
            'status'  => 'error',
            'message' => 'Something went wrong. Please try again.'
        ]);
    }
}
    public function studentcreatenewpassword()
    {
        return view('Student.studentcreatenewpassword');
    }

    public function studentresetpassword(Request $request)
{
    $request->validate([
        'new_password' => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
    ]);

    $email = session('student_reset_email');

    if (!$email) {
        return response()->json([
            'status' => 'error',
            'message' => 'Session expired. Please try again.'
        ]);
    }

    $student = Student::where('email', $email)->first();

    if (!$student) {
        return response()->json([
            'status' => 'error',
            'message' => 'Student not found.'
        ]);
    }

    $student->password = Hash::make($request->new_password);
    $student->save();

    session()->forget('student_reset_email');

    return response()->json([
        'status' => 'success',
        'message' => 'Password updated successfully.',
        'redirect_url' => route('studentlogin')
    ]);
}
   public function studentlogout(Request $request)
{
    Auth::guard('student')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('studentlogin')
                     ->with('success', 'Logged out successfully.');
}
}
