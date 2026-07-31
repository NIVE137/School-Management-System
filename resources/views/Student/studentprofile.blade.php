@extends('Student.studentlayout')
@section('content')
<style>
/* ── Modern Glassmorphism & Student Profile Design ── */
.student-profile-wrapper {
    position: relative;
    z-index: 1;
}

/* Floating School Icons Background */
.student-bg-layer {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}
.student-bg-icon {
    position: absolute;
    color: #696cff;
    opacity: 0.12;
    filter: drop-shadow(0 4px 10px rgba(105, 108, 255, 0.15));
    user-select: none;
}
[data-bs-theme="dark"] .student-bg-icon {
    color: #818cf8;
    opacity: 0.16;
}

.student-bg-icon.i1 { font-size: 52px; top: 2%;   left: 3%;   animation: floatIcon1 20s ease-in-out infinite alternate; }
.student-bg-icon.i2 { font-size: 46px; top: 15%;  right: 4%;  animation: floatIcon2 24s ease-in-out infinite alternate; }
.student-bg-icon.i3 { font-size: 40px; top: 38%;  left: 5%;   animation: floatIcon3 18s ease-in-out infinite alternate; }
.student-bg-icon.i4 { font-size: 58px; top: 60%;  right: 5%;  animation: floatIcon1 26s ease-in-out infinite alternate; }
.school-bg-icon.i5 { font-size: 48px; bottom: 4%;left: 4%;   animation: floatIcon2 22s ease-in-out infinite alternate; }
.student-bg-icon.i6 { font-size: 42px; top: 8%;   left: 45%;  animation: floatIcon3 16s ease-in-out infinite alternate; }

@keyframes floatIcon1 {
    0% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(30px, -35px) rotate(10deg); }
    100% { transform: translate(-20px, 20px) rotate(-6deg); }
}
@keyframes floatIcon2 {
    0% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(-35px, 30px) rotate(-12deg); }
    100% { transform: translate(25px, -15px) rotate(8deg); }
}
@keyframes floatIcon3 {
    0% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(20px, 35px) rotate(15deg); }
    100% { transform: translate(-30px, -25px) rotate(-10deg); }
}

/* Glassmorphism Hero Banner */
.profile-hero-card {
    background: linear-gradient(135deg, #696cff 0%, #03c3ec 100%);
    border-radius: 20px;
    padding: 36px 32px;
    color: #ffffff;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 32px rgba(105, 108, 255, 0.28);
    backdrop-filter: blur(10px);
}
.profile-hero-card::before {
    content: ''; position: absolute; top: -80px; right: -80px;
    width: 260px; height: 260px; border-radius: 50%;
    background: rgba(255, 255, 255, 0.12);
}
.profile-hero-card::after {
    content: ''; position: absolute; bottom: -100px; left: 40px;
    width: 300px; height: 300px; border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
}

.avatar-wrapper {
    position: relative;
    display: inline-block;
}
.profile-avatar-img {
    width: 105px;
    height: 105px;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.85);
    object-fit: cover;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.22);
}
.profile-avatar-placeholder {
    width: 105px;
    height: 105px;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.85);
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #ffffff;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.22);
}

.hero-title {
    font-size: 1.85rem;
    font-weight: 800;
    margin-bottom: 6px;
    letter-spacing: -0.5px;
    color: #ffffff;
}

.hero-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.18);
    border: 1px solid rgba(255, 255, 255, 0.28);
    backdrop-filter: blur(6px);
    border-radius: 30px;
    padding: 5px 14px;
    font-size: 0.8rem;
    font-weight: 600;
    color: #ffffff;
}

/* Glassmorphism Profile Content Cards */
.profile-glass-card {
    background: var(--bs-card-bg, #ffffff);
    border-radius: 16px;
    border: 1px solid var(--bs-border-color, rgba(231, 231, 255, 0.8));
    box-shadow: 0 4px 24px rgba(105, 108, 255, 0.07);
    padding: 26px;
    margin-bottom: 24px;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.profile-glass-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(105, 108, 255, 0.12);
}

.card-header-title {
    font-size: 0.88rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #696cff;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid rgba(105, 108, 255, 0.12);
    display: flex;
    align-items: center;
    gap: 8px;
}

.info-item {
    margin-bottom: 18px;
}
.info-label {
    font-size: 0.76rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #8592a3;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.info-val {
    font-size: 0.92rem;
    font-weight: 600;
    color: var(--bs-heading-color, #32475c);
    background: rgba(105, 108, 255, 0.03);
    border: 1.5px solid var(--bs-border-color, #e7e7ff);
    border-radius: 10px;
    padding: 10px 14px;
    display: block;
    word-break: break-word;
}

/* Document Cards Styling */
.doc-box {
    background: rgba(105, 108, 255, 0.02);
    border: 1.5px solid var(--bs-border-color, #e7e7ff);
    border-radius: 14px;
    padding: 18px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.2s ease;
}
.doc-box:hover {
    border-color: #696cff;
    box-shadow: 0 6px 20px rgba(105, 108, 255, 0.1);
    background: #ffffff;
}
[data-bs-theme="dark"] .doc-box:hover {
    background: #2b2c40;
}

.doc-icon-wrap {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
}
.doc-icon-wrap.active { background: rgba(105, 108, 255, 0.12); color: #696cff; }
.doc-icon-wrap.empty { background: rgba(133, 146, 163, 0.12); color: #8592a3; }

.doc-title {
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--bs-heading-color, #32475c);
    margin-top: 10px;
    margin-bottom: 4px;
}

.badge-status {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.badge-uploaded { background: rgba(113, 221, 55, 0.15); color: #71dd37; }
.badge-missing { background: rgba(255, 62, 29, 0.12); color: #ff3e1d; }

.btn-doc-action {
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.2s ease;
}
.btn-doc-view { background: #696cff; color: #ffffff; border: none; }
.btn-doc-view:hover { background: #5f61e6; color: #ffffff; box-shadow: 0 4px 14px rgba(105, 108, 255, 0.35); }
.btn-doc-download { background: rgba(113, 221, 55, 0.12); color: #71dd37; border: 1px solid rgba(113, 221, 55, 0.3); }
.btn-doc-download:hover { background: #71dd37; color: #ffffff; box-shadow: 0 4px 14px rgba(113, 221, 55, 0.35); }
</style>

<div class="student-profile-wrapper">
    <!-- Floating School Icons Layer -->
    <div class="student-bg-layer" aria-hidden="true">
        <i class="fas fa-graduation-cap student-bg-icon i1"></i>
        <i class="fas fa-book-open student-bg-icon i2"></i>
        <i class="fas fa-pencil-alt student-bg-icon i3"></i>
        <i class="fas fa-school student-bg-icon i4"></i>
        <i class="fas fa-globe student-bg-icon i5"></i>
        <i class="fas fa-lightbulb student-bg-icon i6"></i>
    </div>

    <!-- Hero Banner Card -->
    <div class="profile-hero-card">
        <div class="d-flex align-items-center gap-4 flex-wrap" style="position:relative;z-index:2;">
            <div class="avatar-wrapper">
                @if($student->image && file_exists(public_path('asset/img/'.$student->image)))
                    <img src="{{ asset('asset/img/'.$student->image) }}" alt="{{ $student->student_name }}" class="profile-avatar-img">
                @else
                    <div class="profile-avatar-placeholder"><i class="fas fa-user-graduate"></i></div>
                @endif
            </div>
            <div>
                <h2 class="hero-title">{{ $student->student_name }}</h2>
                <div class="d-flex gap-2 flex-wrap mt-2">
                    <span class="hero-pill"><i class="fas fa-id-badge me-1"></i> Student ID: {{ $student->student_id ?? 'N/A' }}</span>
                    <span class="hero-pill"><i class="fas fa-chalkboard me-1"></i> Class: {{ $student->class_name ?? 'Unassigned' }}</span>
                    <span class="hero-pill">
                        <span style="width:7px;height:7px;border-radius:50%;background:{{ strtolower($student->status ?? 'active') == 'active' ? '#71dd37' : '#ff3e1d' }};"></span>
                        {{ ucfirst($student->status ?? 'active') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Information Grid -->
    <div class="row g-4">
        <!-- Personal Information -->
        <div class="col-lg-6">
            <div class="profile-glass-card h-100">
                <div class="card-header-title"><i class="fas fa-user-circle fs-5"></i> Personal Information</div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-signature"></i> Full Name</label>
                            <span class="info-val">{{ $student->student_name }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-hashtag"></i> Student ID</label>
                            <span class="info-val">{{ $student->student_id ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-calendar-alt"></i> Date of Birth</label>
                            <span class="info-val">{{ $student->dob ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-chalkboard-teacher"></i> Enrolled Class</label>
                            <span class="info-val">{{ $student->class_name ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact & Parent Information -->
        <div class="col-lg-6">
            <div class="profile-glass-card h-100">
                <div class="card-header-title"><i class="fas fa-address-book fs-5"></i> Contact & Parent Info</div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-phone-alt"></i> Student Mobile</label>
                            <span class="info-val">{{ $student->mobile ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-envelope"></i> Email Address</label>
                            <span class="info-val">{{ $student->email ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-user-shield"></i> Parent / Guardian</label>
                            <span class="info-val">{{ $student->parent_name ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-mobile-alt"></i> Parent Contact</label>
                            <span class="info-val">{{ $student->parent_mobile ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-item mb-0">
                            <label class="info-label"><i class="fas fa-map-marker-alt"></i> Residential Address</label>
                            <span class="info-val">{{ $student->address ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Documents Repository Section -->
        @php
            $docsList = [
                'birth_certificate' => ['title' => 'Birth Certificate',  'icon' => 'fa-certificate'],
                'aadher'            => ['title' => 'Aadhaar Card',       'icon' => 'fa-id-card'],
                'parent_idproof'    => ['title' => 'Parent ID Proof',   'icon' => 'fa-user-check'],
                'address_proof'     => ['title' => 'Address Proof',      'icon' => 'fa-file-invoice'],
                'tc'                => ['title' => 'Transfer Certificate','icon' => 'fa-file-export'],
                'mark_sheet'        => ['title' => 'Mark Sheet',         'icon' => 'fa-file-alt'],
            ];
        @endphp

        <div class="col-12">
            <div class="profile-glass-card">
                <div class="card-header-title mb-4">
                    <i class="fas fa-folder-open fs-5"></i> Student Verification Documents
                </div>
                <div class="row g-4">
                    @foreach($docsList as $field => $meta)
                        @php $hasDoc = !empty($student->$field); @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="doc-box">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="doc-icon-wrap {{ $hasDoc ? 'active' : 'empty' }}">
                                            <i class="fas {{ $meta['icon'] }}"></i>
                                        </div>
                                        @if($hasDoc)
                                            <span class="badge-status badge-uploaded"><i class="fas fa-check-circle"></i> Uploaded</span>
                                        @else
                                            <span class="badge-status badge-missing"><i class="fas fa-exclamation-circle"></i> Document Not Available</span>
                                        @endif
                                    </div>
                                    <div class="doc-title">{{ $meta['title'] }}</div>
                                    <small class="text-muted d-block" style="font-size:0.75rem;">
                                        {{ $hasDoc ? $student->$field : 'No document file submitted' }}
                                    </small>
                                </div>
                                <div class="mt-3 pt-3 border-top d-flex gap-2">
                                    @if($hasDoc)
                                        <a href="{{ asset('asset/documents/'.$student->$field) }}" target="_blank" class="btn-doc-action btn-doc-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ asset('asset/documents/'.$student->$field) }}" download class="btn-doc-action btn-doc-download">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-secondary w-100" disabled style="font-size:0.76rem;opacity:0.6;">
                                            <i class="fas fa-ban me-1"></i> Not Available
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
