<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StaffAuthController extends Controller
{
    public function stafflogin(Request $request)
{
    // Show login page
    if (!$request->has('email')) {
        return view('Staff.stafflogin');
    }

    // Validate Request
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    // Find Staff
    $staff = Staff::where('email', $request->email)->first();

    // Check Email
    if (!$staff) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Email does not exist.'
        ]);
    }

    // Check Status
    if ($staff->status != 'active') {
        return response()->json([
            'status'  => 'error',
            'message' => 'Your account is inactive. Please contact the administrator.'
        ]);
    }

    // Check Password
    if (!Hash::check($request->password, $staff->password)) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Incorrect password.'
        ]);
    }

    // Login Staff
    Auth::guard('staff')->login($staff);
    $request->session()->regenerate();

    Log::info('Staff Login', [
        'staff_id' => $staff->id,
        'email'    => $staff->email,
        'time'     => now(),
        'ip'       => $request->ip(),
    ]);

    return response()->json([
        'status'       => 'success',
        'message'      => 'Login Successful.',
        'redirect_url' => route('staffprofile')
    ]);
}
    public function stafflayout()
    {
        return view('Staff.stafflayout');
    }
    public function staffforgetpassword()
    {
        return view('Staff.staffforgetpassword');
    }
    public function staffcheckEmail(Request $request)
{
    DB::beginTransaction();

    try {

        $request->validate([
            'email' => 'required|email'
        ]);

        Log::info('Staff forgot password - Email verification started.', [
            'email' => $request->email,
            'ip' => $request->ip(),
        ]);

        $staff = Staff::where('email', $request->email)->first();

        if (!$staff) {

            Log::warning('Staff forgot password - Email not found.', [
                'email' => $request->email,
            ]);

            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Email does not exist.'
            ]);
        }

        session([
            'staff_reset_email' => $staff->email
        ]);

        Log::info('Staff forgot password - Email verified successfully.', [
            'staff_id' => $staff->id,
            'email' => $staff->email,
        ]);

        DB::commit();

        return response()->json([
            'status' => 'success',
            'redirect_url' => route('staffcreatenewpassword')
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        Log::error('Staff forgot password error.', [
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong. Please try again.'
        ]);
    }
}
    public function studentresetpassword(Request $request)
{
    DB::beginTransaction();

    try {

        // Validate Request
        $request->validate([
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        Log::info('Student Password Reset Attempt', [
            'ip'   => $request->ip(),
            'time' => now(),
        ]);

        // Get Email from Session
        $email = session('student_reset_email');

        if (!$email) {

            Log::warning('Student Password Reset Failed - Session Expired', [
                'ip' => $request->ip(),
            ]);

            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Session expired. Please try again.'
            ]);
        }

        // Find Student
        $student = Student::where('email', $email)->first();

        if (!$student) {

            Log::warning('Student Password Reset Failed - Student Not Found', [
                'email' => $email,
                'ip'    => $request->ip(),
            ]);

            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Student not found.'
            ]);
        }

        // Update Password
        $student->password = Hash::make($request->new_password);
        $student->save();

        // Remove Session
        session()->forget('student_reset_email');

        DB::commit();

        Log::info('Student Password Reset Successful', [
            'student_id' => $student->id,
            'email'      => $student->email,
            'ip'         => $request->ip(),
            'time'       => now(),
        ]);

        return response()->json([
            'status'       => 'success',
            'message'      => 'Password updated successfully.',
            'redirect_url' => route('studentlogin')
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        Log::error('Student Password Reset Error', [
            'message' => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile(),
            'ip'      => $request->ip(),
            'time'    => now(),
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong. Please try again.'
        ]);
    }
}
    public function staffcreatenewpassword()
    {
        return view('Staff.staffcreatenewpassword');
    }
    public function stafflogout(Request $request)
{
    Auth::guard('staff')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('stafflogin')
                     ->with('success', 'Logged out successfully.');
}
}
