<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class StaffAuthController extends Controller
{
    public function stafflogin(Request $request)
    {
        // GET request renders the view
        if ($request->isMethod('get')) {
            return view('Staff.stafflogin');
        }

        // Validate Request
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            Log::info('Staff Login Attempt', [
                'email' => $request->email,
                'ip'    => $request->ip(),
                'time'  => now(),
            ]);

            // Find Staff
            $staff = Staff::where('email', $request->email)->first();

            // Check Email
            if (!$staff) {
                Log::warning('Staff Login Failed - Email Not Found', [
                    'email' => $request->email,
                    'ip'    => $request->ip(),
                ]);

                return response()->json([
                    'status'  => 'error',
                    'message' => 'Email does not exist.'
                ], 404);
            }

            // Check Status
            if ($staff->status != 'active') {
                Log::warning('Staff Login Failed - Account Inactive', [
                    'staff_id' => $staff->id,
                    'email'    => $staff->email,
                ]);

                return response()->json([
                    'status'  => 'error',
                    'message' => 'Your account is inactive. Please contact the administrator.'
                ], 403);
            }

            // Check Password
            if (!Hash::check($request->password, $staff->password)) {
                Log::warning('Staff Login Failed - Incorrect Password', [
                    'staff_id' => $staff->id,
                    'email'    => $staff->email,
                    'ip'       => $request->ip(),
                ]);

                return response()->json([
                    'status'  => 'error',
                    'message' => 'Incorrect password.'
                ], 401);
            }

            // Login Staff
            Auth::guard('staff')->login($staff);
            $request->session()->regenerate();

            Log::info('Staff Login Successful', [
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

        } catch (\Throwable $e) {
            Log::error('Staff Login Exception', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
                'ip'      => $request->ip(),
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Login error: ' . $e->getMessage()
            ], 500);
        }
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
    public function staffresetPassword(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password',
            ]);

            Log::info('Staff Password Reset Attempt', [
                'ip'   => $request->ip(),
                'time' => now(),
            ]);

            // Get Email from Session
            $email = session('staff_reset_email');

            if (!$email) {
                Log::warning('Staff Password Reset Failed - Session Expired', [
                    'ip' => $request->ip(),
                ]);

                DB::rollBack();

                return response()->json([
                    'status' => 'error',
                    'message' => 'Session expired. Please try again.'
                ]);
            }

            // Find Staff
            $staff = Staff::where('email', $email)->first();

            if (!$staff) {
                Log::warning('Staff Password Reset Failed - Staff Not Found', [
                    'email' => $email,
                    'ip'    => $request->ip(),
                ]);

                DB::rollBack();

                return response()->json([
                    'status' => 'error',
                    'message' => 'Staff account not found.'
                ]);
            }

            // Update Password
            $staff->password = Hash::make($request->new_password);
            $staff->save();

            // Remove Session
            session()->forget('staff_reset_email');

            DB::commit();

            Log::info('Staff Password Reset Successful', [
                'staff_id' => $staff->id,
                'email'    => $staff->email,
                'ip'       => $request->ip(),
                'time'     => now(),
            ]);

            return response()->json([
                'status'       => 'success',
                'message'      => 'Password updated successfully.',
                'redirect_url' => route('stafflogin')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Staff Password Reset Error', [
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
        if (!session()->has('staff_reset_email')) {
            return redirect()->route('staffforgetpassword');
        }
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
