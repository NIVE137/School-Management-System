<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\Role;
use App\Models\StudentAttendance;
use App\Models\StaffAttendance;
use App\Models\LeaveRequest;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        Admin::firstOrCreate(
            ['email' => 'nivetha.novelx@gmail.com'],
            [
                'name' => 'School Administrator',
                'password' => Hash::make('12345678'),
            ]
        );

        // Roles
        $roles = ['Mathematics Teacher', 'Science Teacher', 'English Teacher', 'Principal', 'Accountant'];
        foreach ($roles as $r) {
            Role::firstOrCreate(['role_name' => $r]);
        }

        // Classes
        $classes = ['Class 10-A', 'Class 10-B', 'Class 9-A', 'Class 11-Science', 'Class 12-Commerce'];
        foreach ($classes as $c) {
            ClassRoom::firstOrCreate(['class_name' => $c]);
        }

        // Staff
        $staff1 = Staff::firstOrCreate(
            ['email' => 'robert@school.com'],
            [
                'staff_name' => 'Robert Johnson',
                'staff_id'   => 'STF-1001',
                'mobile'     => '9876543210',
                'password'   => Hash::make('password123'),
                'role_name'  => 'Mathematics Teacher',
                'address'    => '123 Tech Park, Suite 4',
                'dob'        => '1985-05-15',
                'status'     => 'active',
            ]
        );

        $staff2 = Staff::firstOrCreate(
            ['email' => 'sarah@school.com'],
            [
                'staff_name' => 'Sarah Williams',
                'staff_id'   => 'STF-1002',
                'mobile'     => '9876543211',
                'password'   => Hash::make('password123'),
                'role_name'  => 'Science Teacher',
                'address'    => '456 Green Valley Rd',
                'dob'        => '1990-08-22',
                'status'     => 'active',
            ]
        );

        // Students
        $stu1 = Student::firstOrCreate(
            ['email' => 'alex@student.com'],
            [
                'student_name'  => 'Alexander Pierce',
                'student_id'    => 'STU-2001',
                'mobile'        => '9123456789',
                'password'      => Hash::make('password123'),
                'class_name'    => 'Class 10-A',
                'address'       => '789 Sunset Blvd',
                'dob'           => '2008-03-10',
                'parent_name'   => 'David Pierce',
                'parent_mobile' => '9123456780',
                'status'        => 'active',
            ]
        );

        $stu2 = Student::firstOrCreate(
            ['email' => 'emily@student.com'],
            [
                'student_name'  => 'Emily Davis',
                'student_id'    => 'STU-2002',
                'mobile'        => '9123456790',
                'password'      => Hash::make('password123'),
                'class_name'    => 'Class 10-B',
                'address'       => '321 Maple St',
                'dob'           => '2008-11-05',
                'parent_name'   => 'Michael Davis',
                'parent_mobile' => '9123456791',
                'status'        => 'active',
            ]
        );

        // Student Attendance
        $today = now()->format('Y-m-d');
        StudentAttendance::firstOrCreate(
            ['student_id' => $stu1->id, 'date' => $today],
            [
                'student_name' => $stu1->student_name,
                'class_name'   => $stu1->class_name,
                'status'       => 'present',
                'remarks'      => 'On time',
            ]
        );

        StudentAttendance::firstOrCreate(
            ['student_id' => $stu2->id, 'date' => $today],
            [
                'student_name' => $stu2->student_name,
                'class_name'   => $stu2->class_name,
                'status'       => 'present',
                'remarks'      => 'On time',
            ]
        );

        // Staff Attendance
        StaffAttendance::firstOrCreate(
            ['staff_id' => $staff1->id, 'date' => $today],
            [
                'staff_name' => $staff1->staff_name,
                'role_name'  => $staff1->role_name,
                'status'     => 'present',
                'remarks'    => 'On time',
            ]
        );

        StaffAttendance::firstOrCreate(
            ['staff_id' => $staff2->id, 'date' => $today],
            [
                'staff_name' => $staff2->staff_name,
                'role_name'  => $staff2->role_name,
                'status'     => 'present',
                'remarks'    => 'On time',
            ]
        );

        // Leave Requests
        LeaveRequest::firstOrCreate(
            ['applicant_id' => $staff1->id, 'start_date' => now()->addDays(2)->format('Y-m-d')],
            [
                'applicant_type' => 'staff',
                'applicant_name' => $staff1->staff_name,
                'leave_type'     => 'Sick Leave',
                'end_date'       => now()->addDays(3)->format('Y-m-d'),
                'reason'         => 'Medical checkup and recovery',
                'status'         => 'pending',
            ]
        );

        LeaveRequest::firstOrCreate(
            ['applicant_id' => $staff2->id, 'start_date' => now()->subDays(5)->format('Y-m-d')],
            [
                'applicant_type' => 'staff',
                'applicant_name' => $staff2->staff_name,
                'leave_type'     => 'Casual Leave',
                'end_date'       => now()->subDays(4)->format('Y-m-d'),
                'reason'         => 'Family function',
                'status'         => 'approved',
            ]
        );
    }
}
