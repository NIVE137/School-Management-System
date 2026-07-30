<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        // GET request renders the view
        if ($request->isMethod('get')) {
            return view('Admin.login');
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
            Log::info('Admin Login Attempt', [
                'email' => $request->email,
                'ip'    => $request->ip(),
                'time'  => now(),
            ]);

            // Find Admin
            $admin = Admin::where('email', $request->email)->first();

            if (!$admin) {
                Log::warning('Admin Login Failed - Email Not Found', [
                    'email' => $request->email,
                    'ip'    => $request->ip(),
                ]);

                return response()->json([
                    'status'  => 'error',
                    'message' => 'Email not found.'
                ], 404);
            }

            // Check Password
            if (!Hash::check($request->password, $admin->password)) {
                Log::warning('Admin Login Failed - Incorrect Password', [
                    'admin_id' => $admin->id,
                    'email'    => $admin->email,
                    'ip'       => $request->ip(),
                ]);

                return response()->json([
                    'status'  => 'error',
                    'message' => 'Incorrect password.'
                ], 401);
            }

            // Login Admin
            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();

            Log::info('Admin Login Successful', [
                'admin_id' => $admin->id,
                'email'    => $admin->email,
                'ip'       => $request->ip(),
                'time'     => now(),
            ]);

            return response()->json([
                'status'       => 'success',
                'message'      => 'Login Successful.',
                'redirect_url' => route('admindashboard')
            ]);

        } catch (\Throwable $e) {
            Log::error('Admin Login Exception', [
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
    public function forgetpassword()
    {
        return view('Admin.forgetpassword');
    }
    public function createnewpassword()
    {
        if (!session()->has('reset_email')) {

            return redirect()->route('forgetpassword');

        }

        return view('Admin.createnewpassword');
    }
    public function checkEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $admin = Admin::where('email', $request->email)->first();

    if (!$admin) {

        return response()->json([
            'status' => 'error',
            'message' => 'Email not found.'
        ]);

    }

    session(['reset_email' => $request->email]);

    return response()->json([
        'status' => 'success',
        'redirect_url' => route('createnewpassword')
    ]);
}
     public function resetPassword(Request $request)
{
    $request->validate([
        'new_password' => 'required|min:8',
        'confirm_password' => 'required|same:new_password'
    ]);

    DB::beginTransaction();

    try {

        $email = session('reset_email');

        $admin = Admin::where('email', $email)->first();

        if (!$admin) {

            return response()->json([
                'status' => 'error',
                'message' => 'Admin not found.'
            ]);

        }

        $admin->password = Hash::make($request->new_password);

        $admin->save();

        session()->forget('reset_email');

        DB::commit();

        Log::info('Password Changed Successfully', [
            'email' => $admin->email
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password Changed Successfully',
            'redirect_url' => route('login')
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        Log::error('Password Change Failed', [
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong.'
        ]);
    }
}
public function logout()
{
    Auth::guard('admin')->logout();

    return redirect()->route('login');
}

}
