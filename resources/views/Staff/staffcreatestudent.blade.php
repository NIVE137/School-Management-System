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
.photo-upload-container{display:flex;align-items:center;gap:20px;margin-bottom:26px;background:#f8f8ff;border:1.5px dashed #e7e7ff;border-radius:10px;padding:18px 20px;}
.img-preview-box{width:76px;height:76px;background:#e7e7ff;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#a5b7c8;font-weight:600;border:1.5px solid #e7e7ff;overflow:hidden;flex-shrink:0;font-size:0.82rem;}
.upload-info-text{font-size:0.74rem;color:#a5b7c8;margin-top:6px;}
.btn-cyan{background:linear-gradient(135deg,#696cff,#03c3ec);color:#fff;border:none;font-weight:600;padding:10px 22px;border-radius:8px;font-size:0.875rem;transition:all .2s;cursor:pointer;}
.btn-cyan:hover{box-shadow:0 6px 20px rgba(105,108,255,0.38);transform:translateY(-1px);color:#fff;}
.btn-discard{background:#f0f0f8;color:#566a7f;border:none;font-weight:500;padding:10px 22px;border-radius:8px;font-size:0.875rem;text-decoration:none;}
.btn-discard:hover{background:#e7e7ff;color:#32475c;}
</style>

<div class="page-back">
    <a href="{{ route('staffstudentmanagement') }}" class="btn-back"><i class="fa-solid fa-angle-left"></i></a>
    <div>
        <h4 class="fw-bold mb-0" style="color:#32475c;">Create Student</h4>
        <small class="text-muted">Add a new student record</small>
    </div>
</div>

<div class="custom-card">
    <form action="{{ route('staffstorestudent') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="photo-upload-container">
            <div class="img-preview-box" id="avatar-preview">IMG</div>
            <div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn-cyan btn-sm py-2 px-3" style="font-size:0.8rem;" onclick="document.getElementById('photo-input').click()"><i class="fas fa-upload me-1"></i> Upload Photo</button>
                    <button type="button" style="background:#f0f0f8;border:none;border-radius:6px;padding:6px 14px;font-size:0.8rem;color:#566a7f;cursor:pointer;" onclick="resetPhoto()">Reset</button>
                </div>
                <div class="upload-info-text"><i class="fas fa-info-circle me-1"></i>Allowed JPG. Max 800K</div>
                <input type="file" id="photo-input" name="student_photo" accept="image/jpeg" class="d-none" onchange="previewImage(this)">
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6"><label class="form-label-custom">Student Name <span style="color:#ff3e1d">*</span></label><input type="text" name="student_name" class="form-control input-custom" placeholder="Enter student name" required></div>
            <div class="col-md-6"><label class="form-label-custom">Student ID <span style="color:#ff3e1d">*</span></label><input type="text" name="student_id" class="form-control input-custom" placeholder="e.g. STU-001" required></div>
            <div class="col-md-6"><label class="form-label-custom">Mobile <span style="color:#ff3e1d">*</span></label><input type="text" name="mobile" class="form-control input-custom" placeholder="Enter mobile" required></div>
            <div class="col-md-6"><label class="form-label-custom">Email Address <span style="color:#ff3e1d">*</span></label><input type="email" name="email" class="form-control input-custom" placeholder="student@school.com" required></div>
            <div class="col-md-6"><label class="form-label-custom">Password <span style="color:#ff3e1d">*</span></label><input type="password" name="password" class="form-control input-custom" placeholder="Create a password" required></div>
            <div class="col-md-6">
                <label class="form-label-custom">Class <span style="color:#ff3e1d">*</span></label>
                <select name="class_name" class="form-select select-custom" required>
                    <option value="" disabled selected hidden>Select class</option>
                    <option value="Class 1">Class 1</option>
                    <option value="Class 2">Class 2</option>
                    <option value="Class 3">Class 3</option>
                    <option value="Class 8">Class 8</option>
                </select>
            </div>
            <div class="col-md-6"><label class="form-label-custom">Address <span style="color:#ff3e1d">*</span></label><input type="text" name="address" class="form-control input-custom" placeholder="Enter address" required></div>
            <div class="col-md-6"><label class="form-label-custom">Date of Birth <span style="color:#ff3e1d">*</span></label><input type="date" name="dob" class="form-control input-custom" required></div>
            <div class="col-md-6"><label class="form-label-custom">Parent Name <span style="color:#ff3e1d">*</span></label><input type="text" name="parent_name" class="form-control input-custom" placeholder="Enter parent name" required></div>
            <div class="col-md-6"><label class="form-label-custom">Parent Mobile <span style="color:#ff3e1d">*</span></label><input type="text" name="parent_mobile" class="form-control input-custom" placeholder="Enter parent mobile" required></div>
        </div>

        @if(isset($errors) && $errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif

        <div class="d-flex gap-3 pt-2">
            <button type="submit" class="btn-cyan"><i class="fas fa-check me-1"></i> Create Student</button>
            <a href="{{ route('staffstudentmanagement') }}" class="btn-discard">Discard</a>
        </div>
    </form>
</div>

<script>
function previewImage(input){if(input.files&&input.files[0]){const r=new FileReader();r.onload=function(e){document.getElementById('avatar-preview').innerHTML='<img src="'+e.target.result+'" style="width:100%;height:100%;object-fit:cover;border-radius:8px;">';};r.readAsDataURL(input.files[0]);}}
function resetPhoto(){document.getElementById('photo-input').value='';document.getElementById('avatar-preview').innerHTML='IMG';}
</script>
@endsection
