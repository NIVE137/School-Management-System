<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Role;
use App\Models\Staff;
use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\StaffAttendance;
use App\Models\LeaveRequest;

class AdminController extends Controller
{
    public function admindashboard()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }

        $today = now()->format('Y-m-d');

        $staffCount        = Staff::count();
        $studentCount      = Student::count();
        $classCount        = ClassRoom::count();
        $roleCount         = Role::count();

        $staffPresentCount   = StaffAttendance::where('date', $today)->where('status', 'present')->count();
        $studentPresentCount = StudentAttendance::where('date', $today)->where('status', 'present')->count();
        $pendingLeaveCount   = LeaveRequest::where('status', 'pending')->count();

        // Recent activities feed
        $recentStaff    = Staff::latest()->take(3)->get();
        $recentStudents = Student::latest()->take(3)->get();
        $recentLeaves   = LeaveRequest::latest()->take(3)->get();

        return view('Admin.admindashboard', compact(
            'staffCount',
            'studentCount',
            'classCount',
            'roleCount',
            'staffPresentCount',
            'studentPresentCount',
            'pendingLeaveCount',
            'recentStaff',
            'recentStudents',
            'recentLeaves'
        ));
    }

    public function layout()
    {
        return view('Admin.layout');
    }

    // ── Staff Management ───────────────────────────────────────
    public function staffmanagement(Request $request)
    {
        try {
            if ($request->ajax()) {
                $staff = Staff::select([
                    'id', 'image', 'staff_name', 'staff_id',
                    'mobile', 'email', 'role_name', 'status', 'created_at'
                ]);

                return DataTables::of($staff)
                    ->addIndexColumn()
                    ->editColumn('created_at', fn($row) => $row->created_at ? $row->created_at->format('d-m-Y') : '')
                    ->addColumn('status', function ($row) {
                        $dot   = $row->status == 'active' ? '#4caf50' : '#ff3e1d';
                        $label = $row->status == 'active' ? 'Active' : 'Inactive';
                        $bg    = $row->status == 'active' ? 'rgba(76,175,80,0.1)' : 'rgba(255,62,29,0.1)';
                        return '<div class="text-center"><span style="display:inline-flex;align-items:center;gap:4px;background:'.$bg.';color:'.$dot.';border-radius:20px;padding:3px 10px;font-size:0.73rem;font-weight:600;">
                            <span style="width:6px;height:6px;border-radius:50%;background:'.$dot.';display:inline-block;"></span>'.$label.'</span></div>';
                    })
                    ->addColumn('action', function ($row) {
                        return '
                        <a href="'.route('editstaff', $row->id).'" class="btn-action-icon edit" title="Edit">
                            <i class="fa fa-pen"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="deleteStaff('.$row->id.')" class="btn-action-icon delete" title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>';
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }

            return view('Admin.staffmanagement');
        } catch (\Exception $e) {
            Log::error('Staff Management Error: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json(['error' => $e->getMessage()], 500)
                : back()->with('error', 'Something went wrong.');
        }
    }

    public function changeStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $staff = Staff::findOrFail($id);
            $staff->status = $request->status;
            $staff->save();
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function editstaff($id)
    {
        $staff = Staff::findOrFail($id);
        $roles = Role::all();
        return view('Admin.editstaff', compact('staff', 'roles'));
    }

    public function deletestaff($id)
    {
        DB::beginTransaction();
        try {
            $staff = Staff::findOrFail($id);
            $staff->delete();
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Unable to delete staff.'], 500);
        }
    }

    public function updatestaff(Request $request, $id)
    {
        $request->validate([
            'staff_name' => 'required',
            'staff_id'   => 'required',
            'mobile'     => 'required',
            'email'      => 'required|email',
            'role'       => 'required',
            'address'    => 'required',
            'dob'        => 'required',
            'status'     => 'required'
        ]);

        DB::beginTransaction();
        try {
            $staff = Staff::findOrFail($id);
            $staff->staff_name = $request->staff_name;
            $staff->staff_id   = $request->staff_id;
            $staff->mobile     = $request->mobile;
            $staff->email      = $request->email;
            $staff->role_name  = $request->role;
            $staff->address    = $request->address;
            $staff->dob        = $request->dob;
            $staff->status     = $request->status;

            if ($request->hasFile('image')) {
                if ($staff->image && file_exists(public_path('img/' . $staff->image))) {
                    unlink(public_path('img/' . $staff->image));
                }
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('img'), $imageName);
                $staff->image = $imageName;
            }

            $staff->save();
            DB::commit();

            return redirect()->route('staffmanagement')->with('success', 'Staff updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function createrole(Request $request)
    {
        try {
            if ($request->ajax()) {
                $roles = Role::select(['id', 'role_name', 'created_at']);
                return DataTables::of($roles)
                    ->addIndexColumn()
                    ->addColumn('date', fn($r) => $r->created_at ? $r->created_at->format('d-m-Y') : '')
                    ->addColumn('action', fn($r) =>
                        '<a href="javascript:void(0)" onclick="deleteRole('.$r->id.')" class="btn-action-icon delete" title="Delete"><i class="fa fa-trash"></i></a>'
                    )
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('Admin.createrole');
        } catch (\Exception $e) {
            return $request->ajax() ? response()->json(['error' => $e->getMessage()], 500) : back()->with('error', 'Something went wrong.');
        }
    }

    public function storerole(Request $request)
    {
        $request->validate(['role_name' => 'required|unique:roles,role_name']);
        Role::create(['role_name' => $request->role_name]);
        return redirect()->back()->with('success', 'Role Added Successfully');
    }

    public function deleterole($id)
    {
        Role::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function createstaff()
    {
        $roles = Role::all();
        return view('Admin.createstaff', compact('roles'));
    }

    public function storestaff(Request $request)
    {
        $request->validate([
            'staff_name'    => 'required',
            'staff_id'      => 'required|unique:staff,staff_id',
            'mobile'        => 'required',
            'email'         => 'required|email|unique:staff,email',
            'password'      => 'required|min:6',
            'role'          => 'required',
            'address'       => 'required',
            'dob'           => 'required',
            'student_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $imageName = null;
            if ($request->hasFile('student_photo')) {
                $image = $request->file('student_photo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('asset/img'), $imageName);
            }

            Staff::create([
                'staff_name' => $request->staff_name,
                'staff_id'   => $request->staff_id,
                'mobile'     => $request->mobile,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'role_name'  => $request->role,
                'address'    => $request->address,
                'dob'        => $request->dob,
                'status'     => 'active',
                'image'      => $imageName,
            ]);

            DB::commit();
            return redirect()->route('staffmanagement')->with('success', 'Staff created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    // ── Student Management ─────────────────────────────────────
    public function studentmanagement(Request $request)
    {
        try {
            if ($request->ajax()) {
                $students = Student::select([
                    'id', 'image', 'student_name', 'student_id', 'mobile', 'email',
                    'parent_name', 'parent_mobile', 'class_name', 'status', 'created_at'
                ]);

                return DataTables::of($students)
                    ->addIndexColumn()
                    ->addColumn('date', fn($row) => $row->created_at ? $row->created_at->format('d-m-Y') : '')
                    ->addColumn('name', fn($row) => $row->student_name)
                    ->addColumn('class_name', fn($row) => $row->class_name)
                    ->addColumn('documents', function ($row) {
                        return '<a href="'.route('uploaddocuments', $row->id).'" class="btn-doc-link"><i class="fas fa-folder-open me-1"></i> View</a>';
                    })
                    ->addColumn('status', function ($row) {
                        $dot   = $row->status == 'active' ? '#4caf50' : '#ff3e1d';
                        $label = $row->status == 'active' ? 'Active' : 'Inactive';
                        $bg    = $row->status == 'active' ? 'rgba(76,175,80,0.1)' : 'rgba(255,62,29,0.1)';
                        return '<div class="text-center"><span style="display:inline-flex;align-items:center;gap:4px;background:'.$bg.';color:'.$dot.';border-radius:20px;padding:3px 10px;font-size:0.73rem;font-weight:600;">
                            <span style="width:6px;height:6px;border-radius:50%;background:'.$dot.';display:inline-block;"></span>'.$label.'</span></div>';
                    })
                    ->addColumn('action', function ($row) {
                        return '
                        <a href="'.route('editstudent', $row->id).'" class="btn-action-icon edit" title="Edit">
                            <i class="fa fa-pen"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="deleteStudent('.$row->id.')" class="btn-action-icon delete" title="Delete">
                            <i class="fa fa-trash"></i>
                        </a>';
                    })
                    ->rawColumns(['documents', 'status', 'action'])
                    ->make(true);
            }

            return view('Admin.studentmanagement');
        } catch (\Exception $e) {
            return $request->ajax() ? response()->json(['error' => $e->getMessage()], 500) : back()->with('error', 'Something went wrong.');
        }
    }

    public function createstudent()
    {
        $classes = ClassRoom::all();
        return view('Admin.createstudent', compact('classes'));
    }

    public function storestudent(Request $request)
    {
        $request->validate([
            'student_name'  => 'required',
            'student_id'    => 'required|unique:students,student_id',
            'mobile'        => 'required',
            'email'         => 'required|email|unique:students,email',
            'password'      => 'required|min:6',
            'class_name'    => 'required',
            'address'       => 'required',
            'dob'           => 'required',
            'parent_name'   => 'required',
            'parent_mobile' => 'required',
            'student_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $imageName = null;
            if ($request->hasFile('student_photo')) {
                $image = $request->file('student_photo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('asset/img'), $imageName);
            }

            $student = Student::create([
                'image'         => $imageName,
                'student_name'  => $request->student_name,
                'student_id'    => $request->student_id,
                'mobile'        => $request->mobile,
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'class_name'    => $request->class_name,
                'address'       => $request->address,
                'dob'           => $request->dob,
                'parent_name'   => $request->parent_name,
                'parent_mobile' => $request->parent_mobile,
                'status'        => 'active',
            ]);

            DB::commit();
            return redirect()->route('uploaddocuments', $student->id)->with('success', 'Student created successfully. Upload documents below.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function editstudent($id)
    {
        $student = Student::findOrFail($id);
        $classes = ClassRoom::all();
        return view('Admin.editstudent', compact('student', 'classes'));
    }

    public function deletestudent($id)
    {
        DB::beginTransaction();
        try {
            $student = Student::findOrFail($id);
            if ($student->image && file_exists(public_path('asset/img/' . $student->image))) {
                unlink(public_path('asset/img/' . $student->image));
            }
            $student->delete();
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updatestudent(Request $request, $id)
    {
        $request->validate([
            'student_name'  => 'required',
            'student_id'    => 'required',
            'mobile'        => 'required',
            'email'         => 'required|email',
            'class_name'    => 'required',
            'address'       => 'required',
            'dob'           => 'required',
            'parent_name'   => 'required',
            'parent_mobile' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $student = Student::findOrFail($id);

            if ($request->hasFile('student_photo')) {
                $image = $request->file('student_photo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('asset/img'), $imageName);
                $student->image = $imageName;
            }

            $student->student_name  = $request->student_name;
            $student->student_id    = $request->student_id;
            $student->mobile        = $request->mobile;
            $student->email         = $request->email;
            $student->class_name    = $request->class_name;
            $student->address       = $request->address;
            $student->dob           = $request->dob;
            $student->parent_name   = $request->parent_name;
            $student->parent_mobile = $request->parent_mobile;
            $student->status        = $request->status ?? 'active';

            if ($request->filled('password')) {
                $student->password = Hash::make($request->password);
            }

            $student->save();
            DB::commit();

            return redirect()->route('studentmanagement')->with('success', 'Student updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function uploaddocuments($id)
    {
        $student = Student::findOrFail($id);
        return view('Admin.uploaddocuments', compact('student'));
    }

    public function savedocuments(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $student = Student::findOrFail($id);
            $files   = ['birth_certificate', 'aadher', 'parent_idproof', 'address_proof', 'tc', 'mark_sheet'];

            foreach ($files as $file) {
                if ($request->hasFile($file)) {
                    $uploadedFile = $request->file($file);
                    $filename     = time() . '_' . $uploadedFile->getClientOriginalName();
                    $uploadedFile->move(public_path('asset/documents'), $filename);
                    $student->{$file} = $filename;
                }
            }

            $student->save();
            DB::commit();

            return redirect()->route('studentmanagement')->with('success', 'Documents uploaded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deletedocument($id, $field)
    {
        DB::beginTransaction();
        try {
            $student = Student::findOrFail($id);
            if ($student->$field) {
                $path = public_path('asset/documents/' . $student->$field);
                if (file_exists($path)) {
                    unlink($path);
                }
                $student->$field = null;
                $student->save();
            }
            DB::commit();
            return redirect()->back()->with('success', 'Document deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function createclass(Request $request)
    {
        try {
            if ($request->ajax()) {
                $classes = ClassRoom::select(['id', 'class_name', 'created_at']);
                return DataTables::of($classes)
                    ->addIndexColumn()
                    ->addColumn('date', fn($r) => $r->created_at ? $r->created_at->format('d-m-Y') : '')
                    ->addColumn('action', fn($r) =>
                        '<a href="javascript:void(0)" onclick="deleteClass('.$r->id.')" class="btn-action-icon delete" title="Delete"><i class="fa fa-trash"></i></a>'
                    )
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('Admin.createclass');
        } catch (\Exception $e) {
            return $request->ajax() ? response()->json(['error' => $e->getMessage()], 500) : back()->with('error', 'Something went wrong.');
        }
    }

    public function storeclass(Request $request)
    {
        $request->validate(['class_name' => 'required|unique:class_rooms,class_name']);
        ClassRoom::create(['class_name' => $request->class_name]);
        return redirect()->back()->with('success', 'Class Created Successfully');
    }

    public function deleteclass($id)
    {
        ClassRoom::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Class deleted successfully.']);
    }

    // ── Student Attendance Module ──────────────────────────────
    public function studentattendance(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = StudentAttendance::query();

                if ($request->filled('date')) {
                    $query->whereDate('date', $request->date);
                }
                if ($request->filled('class_name')) {
                    $query->where('class_name', $request->class_name);
                }

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->editColumn('date', fn($r) => date('d-m-Y', strtotime($r->date)))
                    ->addColumn('status_badge', function ($r) {
                        $badgeMap = [
                            'present' => ['#4caf50', 'rgba(76,175,80,0.1)', 'Present'],
                            'absent'  => ['#ff3e1d', 'rgba(255,62,29,0.1)', 'Absent'],
                            'late'    => ['#ff9800', 'rgba(255,152,0,0.1)', 'Late'],
                            'leave'   => ['#03a9f4', 'rgba(3,169,244,0.1)', 'On Leave'],
                        ];
                        $st = $badgeMap[$r->status] ?? ['#71dd37', 'rgba(113,221,55,0.1)', ucfirst($r->status)];
                        return '<span style="display:inline-flex;align-items:center;gap:4px;background:'.$st[1].';color:'.$st[0].';border-radius:20px;padding:4px 12px;font-size:0.75rem;font-weight:600;">
                            <span style="width:6px;height:6px;border-radius:50%;background:'.$st[0].';display:inline-block;"></span>'.$st[2].'</span>';
                    })
                    ->rawColumns(['status_badge'])
                    ->make(true);
            }

            $classes  = ClassRoom::all();
            $students = Student::where('status', 'active')->get();
            return view('Admin.studentattendance', compact('classes', 'students'));
        } catch (\Exception $e) {
            return $request->ajax() ? response()->json(['error' => $e->getMessage()], 500) : back()->with('error', $e->getMessage());
        }
    }

    public function markStudentAttendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'date'       => 'required|date',
            'status'     => 'required|in:present,absent,late,leave',
        ]);

        $student = Student::findOrFail($request->student_id);

        StudentAttendance::updateOrCreate(
            ['student_id' => $student->id, 'date' => $request->date],
            [
                'student_name' => $student->student_name,
                'class_name'   => $student->class_name,
                'status'       => $request->status,
                'remarks'      => $request->remarks,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Student attendance marked successfully.']);
    }

    // ── Staff Attendance Module ────────────────────────────────
    public function staffattendance(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = StaffAttendance::query();

                if ($request->filled('date')) {
                    $query->whereDate('date', $request->date);
                }
                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->editColumn('date', fn($r) => date('d-m-Y', strtotime($r->date)))
                    ->addColumn('status_badge', function ($r) {
                        $badgeMap = [
                            'present' => ['#4caf50', 'rgba(76,175,80,0.1)', 'Present'],
                            'absent'  => ['#ff3e1d', 'rgba(255,62,29,0.1)', 'Absent'],
                            'late'    => ['#ff9800', 'rgba(255,152,0,0.1)', 'Late'],
                            'leave'   => ['#03a9f4', 'rgba(3,169,244,0.1)', 'On Leave'],
                        ];
                        $st = $badgeMap[$r->status] ?? ['#71dd37', 'rgba(113,221,55,0.1)', ucfirst($r->status)];
                        return '<span style="display:inline-flex;align-items:center;gap:4px;background:'.$st[1].';color:'.$st[0].';border-radius:20px;padding:4px 12px;font-size:0.75rem;font-weight:600;">
                            <span style="width:6px;height:6px;border-radius:50%;background:'.$st[0].';display:inline-block;"></span>'.$st[2].'</span>';
                    })
                    ->rawColumns(['status_badge'])
                    ->make(true);
            }

            $staffMembers = Staff::where('status', 'active')->get();
            return view('Admin.staffattendance', compact('staffMembers'));
        } catch (\Exception $e) {
            return $request->ajax() ? response()->json(['error' => $e->getMessage()], 500) : back()->with('error', $e->getMessage());
        }
    }

    public function markStaffAttendance(Request $request)
    {
        $request->validate([
            'staff_id' => 'required',
            'date'     => 'required|date',
            'status'   => 'required|in:present,absent,late,leave',
        ]);

        $staff = Staff::findOrFail($request->staff_id);

        StaffAttendance::updateOrCreate(
            ['staff_id' => $staff->id, 'date' => $request->date],
            [
                'staff_name' => $staff->staff_name,
                'role_name'  => $staff->role_name,
                'status'     => $request->status,
                'remarks'    => $request->remarks,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Staff attendance marked successfully.']);
    }

    // ── Leave Requests Module ──────────────────────────────────
    public function leaverequests(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = LeaveRequest::query();

                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->editColumn('start_date', fn($r) => date('d-m-Y', strtotime($r->start_date)))
                    ->editColumn('end_date', fn($r) => date('d-m-Y', strtotime($r->end_date)))
                    ->addColumn('status_badge', function ($r) {
                        $map = [
                            'pending'  => ['#ff9800', 'rgba(255,152,0,0.1)', 'Pending'],
                            'approved' => ['#4caf50', 'rgba(76,175,80,0.1)', 'Approved'],
                            'rejected' => ['#ff3e1d', 'rgba(255,62,29,0.1)', 'Rejected'],
                        ];
                        $st = $map[$r->status] ?? ['#8592a3', 'rgba(133,146,163,0.1)', ucfirst($r->status)];
                        return '<span style="display:inline-flex;align-items:center;gap:4px;background:'.$st[1].';color:'.$st[0].';border-radius:20px;padding:4px 12px;font-size:0.75rem;font-weight:600;">
                            <span style="width:6px;height:6px;border-radius:50%;background:'.$st[0].';display:inline-block;"></span>'.$st[2].'</span>';
                    })
                    ->addColumn('action', function ($r) {
                        if ($r->status === 'pending') {
                            return '
                            <button class="btn btn-sm btn-success me-1" onclick="approveLeave('.$r->id.')" title="Approve"><i class="fas fa-check"></i></button>
                            <button class="btn btn-sm btn-danger" onclick="rejectLeave('.$r->id.')" title="Reject"><i class="fas fa-times"></i></button>';
                        }
                        return '<span class="text-muted" style="font-size:0.8rem;">Processed</span>';
                    })
                    ->rawColumns(['status_badge', 'action'])
                    ->make(true);
            }

            return view('Admin.leaverequests');
        } catch (\Exception $e) {
            return $request->ajax() ? response()->json(['error' => $e->getMessage()], 500) : back()->with('error', $e->getMessage());
        }
    }

    public function approveLeaveRequest($id)
    {
        $leave = LeaveRequest::findOrFail($id);
        $leave->status = 'approved';
        $leave->save();
        return response()->json(['success' => true, 'message' => 'Leave request approved successfully.']);
    }

    public function rejectLeaveRequest(Request $request, $id)
    {
        $leave = LeaveRequest::findOrFail($id);
        $leave->status = 'rejected';
        $leave->rejection_reason = $request->rejection_reason ?? 'Not specified';
        $leave->save();
        return response()->json(['success' => true, 'message' => 'Leave request rejected.']);
    }
}
