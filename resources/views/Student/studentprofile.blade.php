@extends('Student.studentlayout')
@section('content')
<style>
.profile-hero{background:linear-gradient(135deg,#696cff,#03c3ec);border-radius:14px;padding:32px 28px;color:#fff;margin-bottom:24px;position:relative;overflow:hidden;}
.profile-hero::before{content:'';position:absolute;top:-60px;right:-60px;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,0.07);}
.profile-hero::after{content:'';position:absolute;bottom:-80px;left:20px;width:250px;height:250px;border-radius:50%;background:rgba(255,255,255,0.05);}
.profile-avatar{width:90px;height:90px;border-radius:50%;border:4px solid rgba(255,255,255,0.7);object-fit:cover;box-shadow:0 6px 20px rgba(0,0,0,0.2);}
.profile-avatar-placeholder{width:90px;height:90px;border-radius:50%;border:4px solid rgba(255,255,255,0.7);background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;font-size:2rem;color:#fff;}
.profile-card{background:#fff;border-radius:12px;border:1px solid rgba(231,231,255,0.8);box-shadow:0 2px 20px rgba(105,108,255,0.08);padding:28px;}
.profile-field{margin-bottom:20px;}
.profile-field label{display:block;font-size:0.73rem;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:#a5b7c8;margin-bottom:5px;}
.profile-field .val{font-size:0.9rem;font-weight:500;color:#32475c;background:#f8f8ff;border:1.5px solid #e7e7ff;border-radius:8px;padding:9px 14px;display:block;}
.section-sep{font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#a5b7c8;margin-bottom:16px;padding-bottom:8px;border-bottom:2px solid #e7e7ff;}
</style>

<div class="profile-hero" style="position:relative;z-index:1;">
    <div class="d-flex align-items-center gap-4" style="position:relative;z-index:2;">
        @if($student->image)
            <img src="{{ asset('asset/img/'.$student->image) }}" alt="Profile" class="profile-avatar">
        @else
            <div class="profile-avatar-placeholder"><i class="fas fa-user-graduate"></i></div>
        @endif
        <div>
            <h4 class="fw-bold mb-1" style="color:#fff;">{{ $student->student_name }}</h4>
            <p style="color:rgba(255,255,255,0.75);margin:0;font-size:0.88rem;">Class: {{ $student->class_name }}</p>
            <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,0.15);border-radius:20px;padding:3px 12px;font-size:0.73rem;font-weight:600;color:#fff;margin-top:8px;">
                <span style="width:7px;height:7px;border-radius:50%;background:{{ $student->status=='active' ? '#71dd37' : '#ff3e1d' }};display:inline-block;"></span>
                {{ ucfirst($student->status ?? 'active') }}
            </span>
        </div>
    </div>
</div>

<div class="profile-card">
    <div class="section-sep">Student Information</div>
    <div class="row">
        <div class="col-md-6"><div class="profile-field"><label>Student Name</label><span class="val">{{ $student->student_name }}</span></div></div>
        <div class="col-md-6"><div class="profile-field"><label>Student ID</label><span class="val">{{ $student->student_id ?? '—' }}</span></div></div>
        <div class="col-md-6"><div class="profile-field"><label>Mobile</label><span class="val">{{ $student->mobile }}</span></div></div>
        <div class="col-md-6"><div class="profile-field"><label>Email Address</label><span class="val">{{ $student->email }}</span></div></div>
        <div class="col-md-6"><div class="profile-field"><label>Class</label><span class="val">{{ $student->class_name }}</span></div></div>
        <div class="col-md-6"><div class="profile-field"><label>Address</label><span class="val">{{ $student->address }}</span></div></div>
        <div class="col-md-6"><div class="profile-field"><label>Date of Birth</label><span class="val">{{ $student->dob }}</span></div></div>
        <div class="col-md-6"><div class="profile-field"><label>Parent Name</label><span class="val">{{ $student->parent_name }}</span></div></div>
        <div class="col-md-6"><div class="profile-field"><label>Parent Mobile</label><span class="val">{{ $student->parent_mobile }}</span></div></div>
    </div>
</div>
@endsection
