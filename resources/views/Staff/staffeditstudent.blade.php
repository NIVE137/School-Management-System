@extends('Staff.stafflayout')
@section('content')
<style>
.page-back{display:flex;align-items:center;gap:14px;margin-bottom:22px;}
.btn-back{background:#fff;border:1.5px solid #e7e7ff;border-radius:8px;width:38px;height:38px;display:flex;align-items:center;justify-content:center;color:#566a7f;text-decoration:none;transition:all .2s;}
.btn-back:hover{background:#696cff;border-color:#696cff;color:#fff;}
.custom-card{background:#fff;border-radius:12px;border:1px solid rgba(231,231,255,0.8);box-shadow:0 2px 20px rgba(105,108,255,0.08);padding:28px;}
.form-label-custom{font-size:0.79rem;font-weight:600;color:#566a7f;margin-bottom:6px;display:block;}
.input-custom,.select-custom{border-radius:8px!important;border:1.5px solid #d9dee3!important;padding:10px 14px!important;font-size:0.88rem!important;color:#32475c!important;transition:border-color .2s,box-shadow .2s!important;}
.input-custom:focus,.select-custom:focus{border-color:#696cff!important;box-shadow:0 0 0 3px rgba(105,108,255,0.12)!important;}
.btn-cyan{background:linear-gradient(135deg,#696cff,#03c3ec);color:#fff;border:none;font-weight:600;padding:10px 22px;border-radius:8px;font-size:0.875rem;transition:all .2s;cursor:pointer;}
.btn-cyan:hover{box-shadow:0 6px 20px rgba(105,108,255,0.38);transform:translateY(-1px);color:#fff;}
.btn-discard{background:#f0f0f8;color:#566a7f;border:none;font-weight:500;padding:10px 22px;border-radius:8px;font-size:0.875rem;text-decoration:none;}
.btn-discard:hover{background:#e7e7ff;color:#32475c;}
</style>

<div class="page-back">
    <a href="{{ route('staffstudentmanagement') }}" class="btn-back"><i class="fa-solid fa-angle-left"></i></a>
    <div>
        <h4 class="fw-bold mb-0" style="color:#32475c;">Edit Student</h4>
        <small class="text-muted">Update {{ $student->student_name }}'s details</small>
    </div>
</div>

<div class="custom-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#a5b7c8;">Student Details</div>
        <button type="button" class="btn-cyan btn-sm" style="font-size:0.8rem;padding:7px 14px;" onclick="location.href='{{ route('staffuploaddocuments',$student->id) }}'">
            <i class="fas fa-file-upload me-1"></i> Upload Documents
        </button>
    </div>

    <form id="updateForm" action="{{ route('staffupdatestudent', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($student->image)
            <div class="text-center mb-4">
                <img src="{{ asset('asset/img/'.$student->image) }}" width="100" height="100" style="border-radius:50%;object-fit:cover;border:3px solid #e7e7ff;">
            </div>
        @endif
        <div class="mb-4"><label class="form-label-custom">Change Profile Photo</label><input type="file" name="image" class="form-control input-custom" style="padding:8px 12px;"></div>

        <div class="row g-4 mb-4">
            <div class="col-md-6"><label class="form-label-custom">Student Name</label><input type="text" name="student_name" class="form-control input-custom" value="{{ $student->student_name }}" required></div>
            <div class="col-md-6"><label class="form-label-custom">Student ID</label><input type="text" name="student_id" class="form-control input-custom" value="{{ $student->student_id }}" required></div>
            <div class="col-md-6"><label class="form-label-custom">Mobile</label><input type="text" name="mobile" class="form-control input-custom" value="{{ $student->mobile }}" required></div>
            <div class="col-md-6"><label class="form-label-custom">Email</label><input type="email" name="email" class="form-control input-custom" value="{{ $student->email }}" required></div>
            <div class="col-md-6"><label class="form-label-custom">Password <small style="color:#a5b7c8;font-weight:400;">(leave blank)</small></label><input type="password" name="password" class="form-control input-custom" placeholder="New password"></div>
            <div class="col-md-6">
                <label class="form-label-custom">Class</label>
                <select id="class_name" name="class_name" class="form-select select-custom">
                    <option value="Class 1" {{ $student->class_name=='Class 1'?'selected':'' }}>Class 1</option>
                    <option value="Class 2" {{ $student->class_name=='Class 2'?'selected':'' }}>Class 2</option>
                    <option value="Class 3" {{ $student->class_name=='Class 3'?'selected':'' }}>Class 3</option>
                    <option value="Class 8" {{ $student->class_name=='Class 8'?'selected':'' }}>Class 8</option>
                </select>
            </div>
            <div class="col-md-6"><label class="form-label-custom">Address</label><input type="text" name="address" class="form-control input-custom" value="{{ $student->address }}" required></div>
            <div class="col-md-6"><label class="form-label-custom">Date of Birth</label><input type="date" name="dob" class="form-control input-custom" value="{{ $student->dob }}" required></div>
            <div class="col-md-6">
                <label class="form-label-custom">Status</label>
                <select id="status" name="status" class="form-select select-custom">
                    <option value="active" {{ $student->status=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ $student->status=='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-6"><label class="form-label-custom">Parent Name</label><input type="text" name="parent_name" class="form-control input-custom" value="{{ $student->parent_name }}" required></div>
            <div class="col-md-6"><label class="form-label-custom">Parent Mobile</label><input type="text" name="parent_mobile" class="form-control input-custom" value="{{ $student->parent_mobile }}" required></div>
        </div>

        @if(isset($errors) && $errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif

        <div class="d-flex gap-3 pt-2">
            <button type="submit" class="btn-cyan"><i class="fas fa-save me-1"></i> Update Student</button>
            <a href="{{ route('staffstudentmanagement') }}" class="btn-discard">Discard</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('updateForm').addEventListener('submit',function(e){
    if(document.getElementById('status').value==='inactive'){
        e.preventDefault();
        Swal.fire({title:'Set as Inactive?',text:'Student will not be able to log in.',icon:'warning',showCancelButton:true,confirmButtonColor:'#ff3e1d',cancelButtonColor:'#566a7f',confirmButtonText:'Yes, Proceed'})
        .then(r=>{if(r.isConfirmed)document.getElementById('updateForm').submit();});
    }
});
</script>
@endsection
