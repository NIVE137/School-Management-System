<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\StudentAttendance;
use App\Models\LeaveRequest;
use App\Models\Admin;
use App\Models\AdminNotification;
use App\Mail\LeaveRequestNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class StaffController extends Controller
{
    // ── Profile ────────────────────────────────────────────────
    public function staffprofile()
    {
        $staff = Auth::guard('staff')->user();
        return view('Staff.staffprofile', compact('staff'));
    }

    // ── Student Management List ─────────────────────────────────
    public function staffstudentmanagement(Request $request)
    {
        try {
            if ($request->ajax()) {
                $students = Student::select([
                    'id','image','student_name','student_id','mobile','email',
                    'parent_name','parent_mobile','class_name','status','created_at'
                ]);

                return DataTables::of($students)
                    ->addIndexColumn()
                    ->addColumn('date', fn($r) => $r->created_at ? $r->created_at->format('d-m-Y') : '')
                    ->addColumn('name', fn($r) => $r->student_name)
                    ->addColumn('class', fn($r) => $r->class_name)
                    ->addColumn('documents', fn($r) =>
                        '<a href="'.route('staffuploaddocuments',$r->id).'" class="btn-doc-link"><i class="fas fa-folder-open me-1"></i> View</a>'
                    )
                    ->addColumn('status', function ($r) {
                        $c = $r->status=='active' ? '#4caf50' : '#ff3e1d';
                        $b = $r->status=='active' ? 'rgba(76,175,80,0.1)' : 'rgba(255,62,29,0.1)';
                        $l = $r->status=='active' ? 'Active' : 'Inactive';
                        return '<div class="text-center"><span style="display:inline-flex;align-items:center;gap:4px;background:'.$b.';color:'.$c.';border-radius:20px;padding:3px 10px;font-size:0.73rem;font-weight:600;"><span style="width:6px;height:6px;border-radius:50%;background:'.$c.';display:inline-block;"></span>'.$l.'</span></div>';
                    })
                    ->addColumn('action', fn($r) =>
                        '<a href="'.route('staffeditstudent',$r->id).'" class="btn-action-icon edit" title="Edit"><i class="fa fa-pen"></i></a>
                         <a href="javascript:void(0)" onclick="deleteStudent('.$r->id.')" class="btn-action-icon delete" title="Delete"><i class="fa fa-trash"></i></a>'
                    )
                    ->rawColumns(['documents','status','action'])
                    ->make(true);
            }

            return view('Staff.staffstudentmanagement');
        } catch (\Exception $e) {
            return $request->ajax()
                ? response()->json(['error' => $e->getMessage()], 500)
                : back()->with('error','Something went wrong.');
        }
    }

    public function staffcreatestudent()
    {
        $classes = ClassRoom::all();
        return view('Staff.staffcreatestudent', compact('classes'));
    }

    public function staffstorestudent(Request $request)
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
                $image     = $request->file('student_photo');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('asset/img'), $imageName);
            }

            $student = Student::create([
                'image'        => $imageName,
                'student_name' => $request->student_name,
                'student_id'   => $request->student_id,
                'mobile'       => $request->mobile,
                'email'        => $request->email,
                'password'     => Hash::make($request->password),
                'class_name'   => $request->class_name,
                'address'      => $request->address,
                'dob'          => $request->dob,
                'parent_name'  => $request->parent_name,
                'parent_mobile'=> $request->parent_mobile,
                'status'       => 'active',
            ]);

            DB::commit();
            return redirect()->route('staffuploaddocuments', $student->id)->with('success','Student created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function staffeditstudent($id)
    {
        $student = Student::findOrFail($id);
        $classes = ClassRoom::all();
        return view('Staff.staffeditstudent', compact('student','classes'));
    }

    public function staffupdatestudent(Request $request, $id)
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

            if ($request->hasFile('image')) {
                $img       = $request->file('image');
                $imgName   = time().'.'.$img->getClientOriginalExtension();
                $img->move(public_path('asset/img'), $imgName);
                $student->image = $imgName;
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

            return redirect()->route('staffstudentmanagement')->with('success','Student updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function staffdeletestudent($id)
    {
        DB::beginTransaction();
        try {
            $student = Student::findOrFail($id);
            if ($student->image && file_exists(public_path('asset/img/'.$student->image))) {
                unlink(public_path('asset/img/'.$student->image));
            }
            $student->delete();
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function staffuploaddocuments($id)
    {
        $student = Student::findOrFail($id);
        return view('Staff.staffuploaddocuments', compact('student'));
    }

    public function staffsavedocuments(Request $request, $id)
    {
        $request->validate([
            'birth_certificate' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'aadher'            => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'parent_idproof'    => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'address_proof'     => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'tc'                => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'mark_sheet'        => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        DB::beginTransaction();
        try {
            $student = Student::findOrFail($id);
            $fields  = ['birth_certificate','aadher','parent_idproof','address_proof','tc','mark_sheet'];
            $destinationPath = public_path('asset/documents');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            foreach ($fields as $field) {
                if ($request->hasFile($field)) {
                    if (!empty($student->{$field})) {
                        $oldPath = $destinationPath . '/' . $student->{$field};
                        if (file_exists($oldPath)) {
                            @unlink($oldPath);
                        }
                    }

                    $file     = $request->file($field);
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $filename);
                    $student->{$field} = $filename;
                }
            }
            $student->save();
            DB::commit();

            return redirect()->back()->with('success', 'Documents saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function staffdeletedocument($id, $field)
    {
        $allowedFields = ['birth_certificate', 'aadher', 'parent_idproof', 'address_proof', 'tc', 'mark_sheet'];
        if (!in_array($field, $allowedFields)) {
            return redirect()->back()->with('error', 'Invalid document type.');
        }

        DB::beginTransaction();
        try {
            $student = Student::findOrFail($id);
            if ($student->$field) {
                $path = public_path('asset/documents/' . $student->$field);
                if (file_exists($path)) {
                    @unlink($path);
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

    // ── Staff Student Attendance ─────────────────────────────────
    public function staffstudentattendance(Request $request)
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
                        $map = [
                            'present' => ['#4caf50', 'rgba(76,175,80,0.1)', 'Present'],
                            'absent'  => ['#ff3e1d', 'rgba(255,62,29,0.1)', 'Absent'],
                            'late'    => ['#ff9800', 'rgba(255,152,0,0.1)', 'Late'],
                            'leave'   => ['#03a9f4', 'rgba(3,169,244,0.1)', 'On Leave'],
                        ];
                        $st = $map[$r->status] ?? ['#71dd37', 'rgba(113,221,55,0.1)', ucfirst($r->status)];
                        return '<span style="display:inline-flex;align-items:center;gap:4px;background:'.$st[1].';color:'.$st[0].';border-radius:20px;padding:4px 12px;font-size:0.75rem;font-weight:600;">
                            <span style="width:6px;height:6px;border-radius:50%;background:'.$st[0].';display:inline-block;"></span>'.$st[2].'</span>';
                    })
                    ->rawColumns(['status_badge'])
                    ->make(true);
            }

            $classes = ClassRoom::all();
            return view('Staff.staffstudentattendance', compact('classes'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // ── Staff Leave Requests ────────────────────────────────────
    public function staffleaverequests(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        try {
            if ($request->ajax()) {
                $query = LeaveRequest::where('applicant_id', $staff->id)->where('applicant_type', 'staff');

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
                    ->rawColumns(['status_badge'])
                    ->make(true);
            }

            return view('Staff.staffleaverequests');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function staffstoreleaverequest(Request $request)
    {
        $request->validate([
            'leave_type' => 'required',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'reason'     => 'required',
        ]);

        $staff = Auth::guard('staff')->user();

        $leaveRequest = LeaveRequest::create([
            'applicant_type' => 'staff',
            'applicant_id'   => $staff->id,
            'applicant_name' => $staff->staff_name,
            'leave_type'     => $request->leave_type,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'reason'         => $request->reason,
            'status'         => 'pending',
        ]);

        AdminNotification::notify(
            'New Leave Request Submitted',
            'Staff member ' . $staff->staff_name . ' has submitted a ' . $request->leave_type . ' leave request.',
            'leave_request',
            route('leaverequests')
        );

        Log::info("SUCCESS: Leave request #{$leaveRequest->id} created successfully for {$leaveRequest->applicant_name}");

        // Dynamic Admin Email Handling (fetch active admin from database)
        $admin = Admin::first();
        $adminEmail = $admin ? $admin->email : config('app.admin_email', 'nivetha.novelx@gmail.com');

        if ($adminEmail) {
            Log::info("SUCCESS: Admin email found: {$adminEmail}");
            try {
                Mail::to($adminEmail)->send(new LeaveRequestNotification($leaveRequest));
                Log::info("SUCCESS: Notification email sent successfully to {$adminEmail}");
            } catch (\Exception $e) {
                Log::error("FAILURE: Email sending failed to {$adminEmail}. Reason: " . $e->getMessage());
            }
        } else {
            Log::warning("FAILURE: No active admin email configured or found in database.");
        }

        return response()->json(['success' => true, 'message' => 'Leave request submitted successfully. Email notification processed.']);
    }
}
