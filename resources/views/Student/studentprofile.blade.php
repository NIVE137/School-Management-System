@extends('Student.studentlayout')
@section('content')
<style>
/* ── Ultra-Premium Glassmorphism & Student Profile Styling ── */
.student-profile-container {
    position: relative;
    z-index: 1;
    animation: profileFadeIn 0.4s ease both;
}

@keyframes profileFadeIn {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Floating School Ambient Background */
.student-ambient-bg {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}
.ambient-school-icon {
    position: absolute;
    color: #6366f1;
    opacity: 0.13;
    filter: drop-shadow(0 6px 14px rgba(99, 102, 241, 0.18));
    user-select: none;
}
[data-bs-theme="dark"] .ambient-school-icon {
    color: #a5b4fc;
    opacity: 0.17;
}

.ambient-school-icon.ic1 { font-size: 58px; top: 2%;   left: 3%;   animation: ambientFloat1 22s ease-in-out infinite alternate; }
.ambient-school-icon.ic2 { font-size: 50px; top: 14%;  right: 4%;  animation: ambientFloat2 26s ease-in-out infinite alternate; }
.ambient-school-icon.ic3 { font-size: 42px; top: 36%;  left: 5%;   animation: ambientFloat3 20s ease-in-out infinite alternate; }
.ambient-school-icon.ic4 { font-size: 64px; top: 62%;  right: 5%;  animation: ambientFloat1 28s ease-in-out infinite alternate; }
.ambient-school-icon.ic5 { font-size: 48px; bottom: 4%;left: 4%;   animation: ambientFloat2 24s ease-in-out infinite alternate; }
.ambient-school-icon.ic6 { font-size: 44px; top: 8%;   left: 45%;  animation: ambientFloat3 18s ease-in-out infinite alternate; }
.ambient-school-icon.ic7 { font-size: 52px; top: 48%;  left: 42%;  animation: ambientFloat2 23s ease-in-out infinite alternate; }
.ambient-school-icon.ic8 { font-size: 46px; bottom: 15%;right: 36%; animation: ambientFloat1 21s ease-in-out infinite alternate; }

@keyframes ambientFloat1 {
    0%   { transform: translate(0, 0) rotate(0deg); }
    50%  { transform: translate(35px, -45px) rotate(14deg); }
    100% { transform: translate(-25px, 25px) rotate(-8deg); }
}
@keyframes ambientFloat2 {
    0%   { transform: translate(0, 0) rotate(0deg); }
    50%  { transform: translate(-40px, 35px) rotate(-16deg); }
    100% { transform: translate(30px, -20px) rotate(12deg); }
}
@keyframes ambientFloat3 {
    0%   { transform: translate(0, 0) rotate(0deg); }
    50%  { transform: translate(25px, 40px) rotate(18deg); }
    100% { transform: translate(-35px, -30px) rotate(-12deg); }
}

/* Glassmorphism Gradient Hero Banner */
.profile-hero-banner {
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 40%, #06b6d4 100%);
    border-radius: 24px;
    padding: 40px 36px;
    color: #ffffff;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 16px 36px rgba(79, 70, 229, 0.28);
    backdrop-filter: blur(12px);
}
.profile-hero-banner::before {
    content: ''; position: absolute; top: -90px; right: -90px;
    width: 280px; height: 280px; border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0) 70%);
}
.profile-hero-banner::after {
    content: ''; position: absolute; bottom: -110px; left: 50px;
    width: 320px; height: 320px; border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0) 70%);
}

.avatar-halo-wrapper {
    position: relative;
    display: inline-block;
}
.profile-avatar-img {
    width: 112px;
    height: 112px;
    border-radius: 50%;
    box-shadow: 0 0 0 6px rgba(255, 255, 255, 0.28), 0 12px 28px rgba(0, 0, 0, 0.25);
    object-fit: cover;
}
.profile-avatar-placeholder {
    width: 112px;
    height: 112px;
    border-radius: 50%;
    box-shadow: 0 0 0 6px rgba(255, 255, 255, 0.28), 0 12px 28px rgba(0, 0, 0, 0.25);
    background: rgba(255, 255, 255, 0.22);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.7rem;
    color: #ffffff;
}

.hero-student-name {
    font-size: 2.05rem;
    font-weight: 800;
    letter-spacing: -0.6px;
    color: #ffffff;
    margin-bottom: 8px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.15);
}

.hero-tag-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 255, 255, 0.18);
    border: 1px solid rgba(255, 255, 255, 0.32);
    backdrop-filter: blur(8px);
    border-radius: 30px;
    padding: 6px 16px;
    font-size: 0.82rem;
    font-weight: 600;
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

/* Premium Glassmorphism Section Cards */
.profile-section-card {
    background: var(--bs-card-bg, #ffffff);
    border-radius: 20px;
    border: 1px solid var(--bs-border-color, rgba(226, 232, 240, 0.8));
    box-shadow: 0 6px 30px rgba(99, 102, 241, 0.08);
    padding: 28px;
    margin-bottom: 28px;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.profile-section-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 36px rgba(99, 102, 241, 0.14);
}

.card-title-bar {
    font-size: 0.9rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 22px;
    padding-bottom: 12px;
    border-bottom: 2px solid rgba(99, 102, 241, 0.12);
    display: flex;
    align-items: center;
    gap: 10px;
}
.card-title-bar.purple { color: #6366f1; border-bottom-color: rgba(99, 102, 241, 0.15); }
.card-title-bar.cyan   { color: #06b6d4; border-bottom-color: rgba(6, 182, 212, 0.15); }
.card-title-bar.emerald{ color: #10b981; border-bottom-color: rgba(16, 185, 129, 0.15); }

.profile-field-box {
    margin-bottom: 20px;
}
.profile-field-label {
    font-size: 0.76rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #64748b;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.profile-field-val {
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--bs-heading-color, #1e293b);
    background: rgba(99, 102, 241, 0.03);
    border: 1.5px solid var(--bs-border-color, #e2e8f0);
    border-radius: 12px;
    padding: 11px 16px;
    display: block;
    word-break: break-word;
}

/* Document Repository Cards */
.doc-item-card {
    background: rgba(99, 102, 241, 0.02);
    border: 1.5px solid var(--bs-border-color, #e2e8f0);
    border-radius: 16px;
    padding: 20px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.25s ease;
}
.doc-item-card:hover {
    border-color: #6366f1;
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.12);
    background: #ffffff;
}
[data-bs-theme="dark"] .doc-item-card:hover {
    background: #1e1b4b;
}

.doc-icon-badge {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
}
.doc-icon-badge.active { background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(6, 182, 212, 0.15)); color: #6366f1; }
.doc-icon-badge.empty  { background: rgba(148, 163, 184, 0.12); color: #94a3b8; }

.doc-heading {
    font-size: 0.92rem;
    font-weight: 700;
    color: var(--bs-heading-color, #1e293b);
    margin-top: 12px;
    margin-bottom: 4px;
}

.doc-status-pill {
    font-size: 0.73rem;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.doc-status-pill.uploaded { background: rgba(16, 185, 129, 0.14); color: #10b981; }
.doc-status-pill.missing  { background: rgba(239, 68, 68, 0.12); color: #ef4444; }

.btn-action-view {
    padding: 7px 16px;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: #ffffff;
    border: none;
    box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
    transition: all 0.2s ease;
}
.btn-action-view:hover {
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(99, 102, 241, 0.45);
}

.btn-action-download {
    padding: 7px 16px;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(16, 185, 129, 0.12);
    color: #10b981;
    border: 1px solid rgba(16, 185, 129, 0.3);
    transition: all 0.2s ease;
}
.btn-action-download:hover {
    background: #10b981;
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35);
}
</style>

<div class="student-profile-container">
    <!-- Floating School Ambient Background Layer -->
    <div class="student-ambient-bg" aria-hidden="true">
        <i class="fas fa-graduation-cap ambient-school-icon ic1"></i>
        <i class="fas fa-book-open ambient-school-icon ic2"></i>
        <i class="fas fa-pencil-alt ambient-school-icon ic3"></i>
        <i class="fas fa-school ambient-school-icon ic4"></i>
        <i class="fas fa-globe ambient-school-icon ic5"></i>
        <i class="fas fa-lightbulb ambient-school-icon ic6"></i>
        <i class="fas fa-book-bookmark ambient-school-icon ic7"></i>
        <i class="fas fa-calculator ambient-school-icon ic8"></i>
    </div>

    <!-- Glassmorphism Gradient Hero Banner -->
    <div class="profile-hero-banner">
        <div class="d-flex align-items-center gap-4 flex-wrap" style="position:relative;z-index:2;">
            <div class="avatar-halo-wrapper">
                @if($student->image && file_exists(public_path('asset/img/'.$student->image)))
                    <img src="{{ asset('asset/img/'.$student->image) }}" alt="{{ $student->student_name }}" class="profile-avatar-img">
                @else
                    <div class="profile-avatar-placeholder"><i class="fas fa-user-graduate"></i></div>
                @endif
            </div>
            <div>
                <h1 class="hero-student-name">{{ $student->student_name }}</h1>
                <div class="d-flex gap-2 flex-wrap mt-2">
                    <span class="hero-tag-pill"><i class="fas fa-id-badge"></i> Student ID: {{ $student->student_id ?? 'N/A' }}</span>
                    <span class="hero-tag-pill"><i class="fas fa-chalkboard"></i> Class: {{ $student->class_name ?? 'Unassigned' }}</span>
                    <span class="hero-tag-pill">
                        <span style="width:8px;height:8px;border-radius:50%;background:{{ strtolower($student->status ?? 'active') == 'active' ? '#10b981' : '#ef4444' }};"></span>
                        {{ ucfirst($student->status ?? 'active') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Information Cards Grid -->
    <div class="row g-4">
        <!-- Personal Details -->
        <div class="col-lg-6">
            <div class="profile-section-card h-100">
                <div class="card-title-bar purple">
                    <i class="fas fa-user-circle fs-5"></i> Personal Information
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-signature"></i> Full Name</label>
                            <span class="profile-field-val">{{ $student->student_name }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-hashtag"></i> Student ID</label>
                            <span class="profile-field-val">{{ $student->student_id ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-calendar-alt"></i> Date of Birth</label>
                            <span class="profile-field-val">{{ $student->dob ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-chalkboard-teacher"></i> Enrolled Class</label>
                            <span class="profile-field-val">{{ $student->class_name ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact & Parent Information -->
        <div class="col-lg-6">
            <div class="profile-section-card h-100">
                <div class="card-title-bar cyan">
                    <i class="fas fa-address-book fs-5"></i> Contact & Parent Info
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-phone-alt"></i> Student Mobile</label>
                            <span class="profile-field-val">{{ $student->mobile ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-envelope"></i> Email Address</label>
                            <span class="profile-field-val">{{ $student->email ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-user-shield"></i> Parent / Guardian</label>
                            <span class="profile-field-val">{{ $student->parent_name ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-mobile-alt"></i> Parent Contact</label>
                            <span class="profile-field-val">{{ $student->parent_mobile ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="profile-field-box mb-0">
                            <label class="profile-field-label"><i class="fas fa-map-marker-alt"></i> Residential Address</label>
                            <span class="profile-field-val">{{ $student->address ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Verification Documents Repository Card -->
        @php
            $docsList = [
                'birth_certificate' => ['title' => 'Birth Certificate',   'icon' => 'fa-certificate'],
                'aadher'            => ['title' => 'Aadhaar Card',        'icon' => 'fa-id-card'],
                'parent_idproof'    => ['title' => 'Parent ID Proof',    'icon' => 'fa-user-check'],
                'address_proof'     => ['title' => 'Address Proof',       'icon' => 'fa-file-invoice'],
                'tc'                => ['title' => 'Transfer Certificate','icon' => 'fa-file-export'],
                'mark_sheet'        => ['title' => 'Mark Sheet',          'icon' => 'fa-file-alt'],
            ];
        @endphp

        <div class="col-12">
            <div class="profile-section-card">
                <div class="card-title-bar emerald mb-4">
                    <i class="fas fa-folder-open fs-5"></i> Student Verification Documents
                </div>
                <div class="row g-4">
                    @foreach($docsList as $field => $meta)
                        @php $hasDoc = !empty($student->$field); @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="doc-item-card">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="doc-icon-badge {{ $hasDoc ? 'active' : 'empty' }}">
                                            <i class="fas {{ $meta['icon'] }}"></i>
                                        </div>
                                        @if($hasDoc)
                                            <span class="doc-status-pill uploaded"><i class="fas fa-check-circle"></i> Uploaded</span>
                                        @else
                                            <span class="doc-status-pill missing"><i class="fas fa-exclamation-circle"></i> Document Not Available</span>
                                        @endif
                                    </div>
                                    <div class="doc-heading">{{ $meta['title'] }}</div>
                                    <small class="text-muted d-block" style="font-size:0.75rem;">
                                        {{ $hasDoc ? $student->$field : 'No document file submitted' }}
                                    </small>
                                </div>
                                <div class="mt-3 pt-3 border-top d-flex gap-2">
                                    @if($hasDoc)
                                        <a href="{{ asset('asset/documents/'.$student->$field) }}" target="_blank" class="btn-action-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{ asset('asset/documents/'.$student->$field) }}" download class="btn-action-download">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    @else
                                        <button class="btn btn-sm btn-secondary w-100" disabled style="font-size:0.76rem;opacity:0.65;border-radius:10px;">
                                            <i class="fas fa-ban me-1"></i> Document Not Available
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
