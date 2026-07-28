@extends('Admin.layout')
@section('content')
<style>
.page-back{display:flex;align-items:center;gap:14px;margin-bottom:22px;}
.btn-back{background:#fff;border:1.5px solid #e7e7ff;border-radius:8px;width:38px;height:38px;display:flex;align-items:center;justify-content:center;color:#566a7f;text-decoration:none;transition:all .2s;}
.btn-back:hover{background:#696cff;border-color:#696cff;color:#fff;}
.custom-card{background:#fff;border-radius:12px;border:1px solid rgba(231,231,255,0.8);box-shadow:0 2px 20px rgba(105,108,255,0.08);padding:28px;}
.form-label-custom{font-size:0.79rem;font-weight:600;color:#566a7f;margin-bottom:6px;display:block;}
.input-custom,.select-custom{border-radius:8px !important;border:1.5px solid #d9dee3 !important;padding:10px 14px !important;font-size:0.88rem !important;color:#32475c !important;transition:border-color .2s,box-shadow .2s !important;}
.input-custom:focus,.select-custom:focus{border-color:#696cff !important;box-shadow:0 0 0 3px rgba(105,108,255,0.12) !important;}
.btn-cyan{background:linear-gradient(135deg,#696cff,#03c3ec);color:#fff;border:none;font-weight:600;padding:10px 22px;border-radius:8px;font-size:0.875rem;transition:all .2s;cursor:pointer;}
.btn-cyan:hover{box-shadow:0 6px 20px rgba(105,108,255,0.38);transform:translateY(-1px);color:#fff;}
.btn-discard{background:#f0f0f8;color:#566a7f;border:none;font-weight:500;padding:10px 22px;border-radius:8px;font-size:0.875rem;text-decoration:none;}
.btn-discard:hover{background:#e7e7ff;color:#32475c;}
</style>

<div class="page-back">
    <a href="{{ route('staffmanagement') }}" class="btn-back"><i class="fa-solid fa-angle-left"></i></a>
    <div>
        <h4 class="fw-bold mb-0" style="color:#32475c;">Edit Staff</h4>
        <small class="text-muted">Update {{ $staff->staff_name }}'s details</small>
    </div>
</div>

<div class="custom-card">
    <form id="updateForm" action="{{ route('updatestaff', $staff->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($staff->image)
            <div class="text-center mb-4">
                <img src="{{ asset('asset/img/'.$staff->image) }}" width="100" height="100" style="border-radius:50%;object-fit:cover;border:3px solid #e7e7ff;">
            </div>
        @endif
        <div class="mb-4">
            <label class="form-label-custom">Change Profile Photo</label>
            <input type="file" name="image" class="form-control input-custom" style="padding:8px 12px;">
        </div>
        <input type="hidden" name="id" value="{{ $staff->id }}">
        <div class="row g-4 mb-4">
            <div class="col-md-6"><label class="form-label-custom">Staff Name</label><input type="text" name="staff_name" class="form-control input-custom" value="{{ $staff->staff_name }}" required></div>
            <div class="col-md-6"><label class="form-label-custom">Staff ID</label><input type="text" name="staff_id" class="form-control input-custom" value="{{ $staff->staff_id }}" required></div>
            <div class="col-md-6"><label class="form-label-custom">Mobile</label><input type="text" name="mobile" class="form-control input-custom" value="{{ $staff->mobile }}" required></div>
            <div class="col-md-6"><label class="form-label-custom">Email Address</label><input type="email" name="email" class="form-control input-custom" value="{{ $staff->email }}" required></div>
            <div class="col-md-6"><label class="form-label-custom">Password <small style="color:#a5b7c8;font-weight:400;">(leave blank to keep current)</small></label><input type="password" name="password" class="form-control input-custom" placeholder="New password"></div>
            <div class="col-md-6">
                <label class="form-label-custom">Role</label>
                <select name="role" class="form-select select-custom" required>
                    <option value="" disabled hidden>Select role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->role_name }}" {{ $staff->role_name==$role->role_name?'selected':'' }}>{{ $role->role_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6"><label class="form-label-custom">Address</label><input type="text" name="address" class="form-control input-custom" value="{{ $staff->address }}" required></div>
            <div class="col-md-6"><label class="form-label-custom">Date of Birth</label><input type="date" id="dob" name="dob" class="form-control input-custom" value="{{ $staff->dob }}" required></div>
            <div class="col-md-6">
                <label class="form-label-custom">Status</label>
                <select id="status" name="status" class="form-select select-custom">
                    <option value="active" {{ $staff->status=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ $staff->status=='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>
        </div>
        @if(isset($errors) && $errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
        <div class="d-flex gap-3 pt-2">
            <button type="submit" class="btn-cyan"><i class="fas fa-save me-1"></i> Update Staff</button>
            <a href="{{ route('staffmanagement') }}" class="btn-discard">Discard</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('updateForm').addEventListener('submit',function(e){
    if(document.getElementById('status').value==='inactive'){
        e.preventDefault();
        Swal.fire({title:'Set as Inactive?',text:'This will prevent this staff from logging in.',icon:'warning',showCancelButton:true,confirmButtonColor:'#ff3e1d',cancelButtonColor:'#566a7f',confirmButtonText:'Yes, Proceed'})
        .then(r=>{if(r.isConfirmed)document.getElementById('updateForm').submit();});
    }
});
</script>
@endsection
