<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\Staff\StaffAuthController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\StudentAuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Admin Prefix
Route::prefix('Admin')->group(function () {

    // Public Routes
    Route::get('/login', [AdminAuthController::class, 'login'])->name('login');
    Route::get('/forgetpassword', [AdminAuthController::class, 'forgetpassword'])->name('forgetpassword');
    Route::post('/checkemail', [AdminAuthController::class, 'checkEmail'])->name('checkemail');
    Route::get('/createnewpassword', [AdminAuthController::class, 'createnewpassword'])->name('createnewpassword');
    Route::post('/resetpassword', [AdminAuthController::class, 'resetPassword'])->name('resetpassword');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Protected Routes (Login Required)
    Route::middleware('auth:admin')->group(function () {

        Route::get('/admindashboard', [AdminController::class, 'admindashboard'])->name('admindashboard');
        Route::get('/layout', [AdminController::class, 'layout'])->name('layout');

        // Staff Management
        Route::get('/staffmanagement', [AdminController::class, 'staffmanagement'])->name('staffmanagement');
        Route::post('/changeStatus/{id}', [AdminController::class, 'changeStatus'])->name('staff.changeStatus');
        Route::get('/createrole', [AdminController::class, 'createrole'])->name('createrole');
        Route::post('/storerole', [AdminController::class, 'storerole'])->name('storerole');
        Route::delete('/deleterole/{id}', [AdminController::class, 'deleterole'])->name('deleterole');
        Route::get('/createstaff', [AdminController::class, 'createstaff'])->name('createstaff');
        Route::post('/storestaff', [AdminController::class, 'storestaff'])->name('storestaff');
        Route::get('/editstaff/{id}', [AdminController::class, 'editstaff'])->name('editstaff');
        Route::post('/updatestaff/{id}', [AdminController::class, 'updatestaff'])->name('updatestaff');
        Route::delete('/deletestaff/{id}', [AdminController::class, 'deletestaff'])->name('deletestaff');

        // Student Management
        Route::get('/studentmanagement', [AdminController::class, 'studentmanagement'])->name('studentmanagement');
        Route::get('/createstudent', [AdminController::class, 'createstudent'])->name('createstudent');
        Route::post('/storestudent', [AdminController::class, 'storestudent'])->name('storestudent');
        Route::get('/editstudent/{id}', [AdminController::class, 'editstudent'])->name('editstudent');
        Route::post('/updatestudent/{id}', [AdminController::class, 'updatestudent'])->name('updatestudent');
        Route::delete('/deletestudent/{id}', [AdminController::class, 'deletestudent'])->name('deletestudent');
        Route::post('/savedocuments/{id}', [AdminController::class, 'savedocuments'])->name('savedocuments');
        Route::get('/uploaddocuments/{id}', [AdminController::class, 'uploaddocuments'])->name('uploaddocuments');
        Route::get('/deletedocument/{id}/{field}', [AdminController::class, 'deletedocument'])->name('deletedocument');
        Route::get('/createclass', [AdminController::class, 'createclass'])->name('createclass');
        Route::post('/storeclass', [AdminController::class, 'storeclass'])->name('storeclass');
        Route::delete('/deleteclass/{id}', [AdminController::class, 'deleteclass'])->name('deleteclass');

        // Attendance Modules
        Route::get('/studentattendance', [AdminController::class, 'studentattendance'])->name('studentattendance');
        Route::post('/markstudentattendance', [AdminController::class, 'markStudentAttendance'])->name('markstudentattendance');
        Route::get('/staffattendance', [AdminController::class, 'staffattendance'])->name('staffattendance');
        Route::post('/markstaffattendance', [AdminController::class, 'markStaffAttendance'])->name('markstaffattendance');

        // Leave Requests
        Route::get('/leaverequests', [AdminController::class, 'leaverequests'])->name('leaverequests');
        Route::post('/approveleaverequest/{id}', [AdminController::class, 'approveLeaveRequest'])->name('approveleaverequest');
        Route::post('/rejectleaverequest/{id}', [AdminController::class, 'rejectLeaveRequest'])->name('rejectleaverequest');
    });
});

// Staff Prefix
Route::prefix('/Staff')->group(function () {
    Route::get('/stafflogin', [StaffAuthController::class, 'stafflogin'])->name('stafflogin');
    Route::get('/staffforgetpassword', [StaffAuthController::class, 'staffforgetpassword'])->name('staffforgetpassword');
    Route::post('/staffcheckemail', [StaffAuthController::class, 'staffcheckEmail'])->name('staffcheckemail');
    Route::get('/staffcreatenewpassword', [StaffAuthController::class, 'staffcreatenewpassword'])->name('staffcreatenewpassword');
    Route::post('/staffresetpassword', [StaffAuthController::class, 'staffresetPassword'])->name('staffresetpassword');
    Route::post('/stafflogout', [StaffAuthController::class, 'stafflogout'])->name('stafflogout');

    Route::middleware('auth:staff')->group(function () {
        Route::get('/stafflayout', [StaffAuthController::class, 'stafflayout'])->name('stafflayout');
        Route::get('/staffprofile', [StaffController::class, 'staffprofile'])->name('staffprofile');

        // Student Management
        Route::get('/staffstudentmanagement', [StaffController::class, 'staffstudentmanagement'])->name('staffstudentmanagement');
        Route::get('/staffcreatestudent', [StaffController::class, 'staffcreatestudent'])->name('staffcreatestudent');
        Route::post('/staffstorestudent', [StaffController::class, 'staffstorestudent'])->name('staffstorestudent');
        Route::get('/staffeditstudent/{id}', [StaffController::class, 'staffeditstudent'])->name('staffeditstudent');
        Route::post('/staffupdatestudent/{id}', [StaffController::class, 'staffupdatestudent'])->name('staffupdatestudent');
        Route::delete('/staffdeletestudent/{id}', [StaffController::class, 'staffdeletestudent'])->name('staffdeletestudent');
        Route::get('/staffuploaddocuments/{id}', [StaffController::class, 'staffuploaddocuments'])->name('staffuploaddocuments');
        Route::get('/staffdeletedocument/{id}/{field}', [StaffController::class, 'staffdeletedocument'])->name('staffdeletedocument');
        Route::post('/staffsavedocuments/{id}', [StaffController::class, 'staffsavedocuments'])->name('staffsavedocuments');

        // Staff Student Attendance & Leave Requests
        Route::get('/staffstudentattendance', [StaffController::class, 'staffstudentattendance'])->name('staffstudentattendance');
        Route::get('/staffleaverequests', [StaffController::class, 'staffleaverequests'])->name('staffleaverequests');
        Route::post('/staffstoreleaverequest', [StaffController::class, 'staffstoreleaverequest'])->name('staffstoreleaverequest');
    });
});

// Student Prefix
Route::prefix('/Student')->group(function () {
    Route::get('/studentlogin', [StudentAuthController::class, 'studentlogin'])->name('studentlogin');
    Route::get('/studentforgetpassword', [StudentAuthController::class, 'studentforgetpassword'])->name('studentforgetpassword');
    Route::post('/studentcheckemail', [StudentAuthController::class, 'studentcheckemail'])->name('studentcheckemail');
    Route::get('/studentcreatenewpassword', [StudentAuthController::class, 'studentcreatenewpassword'])->name('studentcreatenewpassword');
    Route::post('/studentresetpassword', [StudentAuthController::class, 'studentresetpassword'])->name('studentresetpassword');
    Route::post('/studentlogout', [StudentAuthController::class, 'studentlogout'])->name('studentlogout');

    Route::middleware('auth:student')->group(function () {
        Route::get('/studentprofile', [StudentController::class, 'studentprofile'])->name('studentprofile');
    });
});
