<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Staff;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\StaffAttendance;
use App\Models\LeaveRequest;

echo "--- DATABASE VERIFICATION ---\n";
echo "Staff Count: " . Staff::count() . "\n";
echo "Student Count: " . Student::count() . "\n";
echo "Student Attendance Count: " . StudentAttendance::count() . "\n";
echo "Staff Attendance Count: " . StaffAttendance::count() . "\n";
echo "Leave Requests Count: " . LeaveRequest::count() . "\n";

echo "\n--- TESTING STUDENT ATTENDANCE ---\n";
print_r(StudentAttendance::all()->toArray());

echo "\n--- TESTING LEAVE REQUESTS ---\n";
print_r(LeaveRequest::all()->toArray());
