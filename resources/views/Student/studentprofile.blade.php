@extends('Student.studentlayout')
@section('content')
<style>
/* ── Modern Education Management System Student Profile Layout ── */
.student-portal-wrapper {
    position: relative;
    z-index: 1;
    animation: portalFade 0.4s ease both;
}
@keyframes portalFade {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Hero Banner Layout */
.portal-hero-banner {
    background: linear-gradient(135deg, #4338ca 0%, #6366f1 45%, #06b6d4 100%);
    border-radius: 24px;
    padding: 38px 40px;
    color: #ffffff;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 16px 36px rgba(67, 56, 202, 0.28);
}
.portal-hero-banner::before {
    content: ''; position: absolute; top: -100px; right: -100px;
    width: 320px; height: 320px; border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0) 70%);
}
.portal-hero-banner::after {
    content: ''; position: absolute; bottom: -120px; left: 40px;
    width: 350px; height: 350px; border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0) 70%);
}

.hero-avatar-frame {
    position: relative;
    display: inline-block;
}
.hero-avatar-img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    box-shadow: 0 0 0 6px rgba(255, 255, 255, 0.3), 0 14px 30px rgba(0, 0, 0, 0.28);
    object-fit: cover;
}
.hero-avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    box-shadow: 0 0 0 6px rgba(255, 255, 255, 0.3), 0 14px 30px rgba(0, 0, 0, 0.28);
    background: rgba(255, 255, 255, 0.22);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: #ffffff;
}

.hero-student-name {
    font-size: 2.15rem;
    font-weight: 800;
    letter-spacing: -0.6px;
    color: #ffffff;
    margin-bottom: 8px;
}
.hero-badge-pill {
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
}

/* Floating SVG illustration graphic overlay */
.hero-svg-illustration {
    position: absolute;
    right: 40px;
    bottom: 20px;
    opacity: 0.22;
    pointer-events: none;
    max-width: 220px;
}

/* Glassmorphism Section Card Layout */
.portal-card {
    background: var(--bs-card-bg, #ffffff);
    border-radius: 20px;
    border: 1px solid var(--bs-border-color, rgba(226, 232, 240, 0.8));
    box-shadow: 0 6px 28px rgba(99, 102, 241, 0.07);
    padding: 26px;
    margin-bottom: 24px;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.portal-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 34px rgba(99, 102, 241, 0.13);
}

.portal-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.92rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid rgba(99, 102, 241, 0.12);
}
.portal-card-header.indigo { color: #4338ca; border-bottom-color: rgba(67, 56, 202, 0.15); }
.portal-card-header.cyan   { color: #0891b2; border-bottom-color: rgba(8, 145, 178, 0.15); }
.portal-card-header.purple { color: #8b5cf6; border-bottom-color: rgba(139, 92, 246, 0.15); }
.portal-card-header.emerald{ color: #059669; border-bottom-color: rgba(5, 150, 105, 0.15); }

.field-group {
    margin-bottom: 18px;
}
.field-group label {
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
.field-group .field-value {
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

/* Documents Cards Grid */
.doc-card {
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
.doc-card:hover {
    border-color: #6366f1;
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.12);
    background: #ffffff;
}
[data-bs-theme="dark"] .doc-card:hover {
    background: #1e1b4b;
}

.doc-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
}
.doc-icon-box.active { background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(6, 182, 212, 0.15)); color: #6366f1; }
.doc-icon-box.empty  { background: rgba(148, 163, 184, 0.12); color: #94a3b8; }

.doc-name {
    font-size: 0.92rem;
    font-weight: 700;
    color: var(--bs-heading-color, #1e293b);
    margin-top: 12px;
    margin-bottom: 4px;
}

.doc-pill {
    font-size: 0.73rem;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.doc-pill.uploaded { background: rgba(16, 185, 129, 0.14); color: #10b981; }
.doc-pill.missing  { background: rgba(239, 68, 68, 0.12); color: #ef4444; }

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
.btn-action-view:hover { color: #ffffff; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(99, 102, 241, 0.45); }

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
.btn-action-download:hover { background: #10b981; color: #ffffff; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35); }
</style>

<div class="student-portal-wrapper">
    <!-- Full-Width Hero / Banner Section -->
    <div class="portal-hero-banner">
        <svg class="hero-svg-illustration d-none d-lg-block" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 20L180 60L100 100L20 60L100 20Z" stroke="white" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M40 80V130C40 130 60 160 100 160C140 160 160 130 160 130V80" stroke="white" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>

        <div class="d-flex align-items-center gap-4 flex-wrap" style="position:relative;z-index:2;">
            <div class="hero-avatar-frame">
                @if($student->image && file_exists(public_path('asset/img/'.$student->image)))
                    <img src="{{ asset('asset/img/'.$student->image) }}" alt="{{ $student->student_name }}" class="hero-avatar-img">
                @else
                    <div class="hero-avatar-placeholder"><i class="fas fa-user-graduate"></i></div>
                @endif
            </div>
            <div>
                <h1 class="hero-student-name">{{ $student->student_name }}</h1>
                <div class="d-flex gap-2 flex-wrap mt-2">
                    <span class="hero-badge-pill"><i class="fas fa-id-badge"></i> Student ID: {{ $student->student_id ?? 'N/A' }}</span>
                    <span class="hero-badge-pill"><i class="fas fa-chalkboard"></i> Class: {{ $student->class_name ?? 'Unassigned' }}</span>
                    <span class="hero-badge-pill">
                        <span style="width:8px;height:8px;border-radius:50%;background:{{ strtolower($student->status ?? 'active') == 'active' ? '#10b981' : '#ef4444' }};"></span>
                        {{ ucfirst($student->status ?? 'active') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Multi-Column Grid Layout -->
    <div class="row g-4">
        <!-- 1. Personal Details Card -->
        <div class="col-lg-6">
            <div class="portal-card h-100">
                <div class="portal-card-header indigo">
                    <i class="fas fa-user-circle fs-5"></i> Personal Details
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="field-group">
                            <label><i class="fas fa-signature"></i> Full Name</label>
                            <span class="field-value">{{ $student->student_name }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="field-group">
                            <label><i class="fas fa-hashtag"></i> Student ID / Roll No</label>
                            <span class="field-value">{{ $student->student_id ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="field-group mb-0">
                            <label><i class="fas fa-calendar-alt"></i> Date of Birth</label>
                            <span class="field-value">{{ $student->dob ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Academic Information Card -->
        <div class="col-lg-6">
            <div class="portal-card h-100">
                <div class="portal-card-header purple">
                    <i class="fas fa-graduation-cap fs-5"></i> Academic Information
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="field-group">
                            <label><i class="fas fa-chalkboard-teacher"></i> Enrolled Class</label>
                            <span class="field-value">{{ $student->class_name ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="field-group">
                            <label><i class="fas fa-id-card"></i> Portal ID Code</label>
                            <span class="field-value">{{ $student->student_id ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="field-group mb-0">
                            <label><i class="fas fa-shield-alt"></i> Academic Status</label>
                            <span class="field-value" style="color:{{ strtolower($student->status ?? 'active') == 'active' ? '#10b981' : '#ef4444' }};">
                                <i class="fas fa-circle me-1" style="font-size:0.6rem;"></i> {{ ucfirst($student->status ?? 'active') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Contact Information Card -->
        <div class="col-lg-6">
            <div class="portal-card h-100">
                <div class="portal-card-header cyan">
                    <i class="fas fa-address-book fs-5"></i> Contact Information
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="field-group">
                            <label><i class="fas fa-phone-alt"></i> Student Mobile</label>
                            <span class="field-value">{{ $student->mobile ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="field-group">
                            <label><i class="fas fa-envelope"></i> Email Address</label>
                            <span class="field-value">{{ $student->email ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="field-group mb-0">
                            <label><i class="fas fa-map-marker-alt"></i> Residential Address</label>
                            <span class="field-value">{{ $student->address ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Parent Information Card -->
        <div class="col-lg-6">
            <div class="portal-card h-100">
                <div class="portal-card-header indigo">
                    <i class="fas fa-user-shield fs-5"></i> Parent & Guardian Information
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="field-group">
                            <label><i class="fas fa-user"></i> Parent / Guardian Name</label>
                            <span class="field-value">{{ $student->parent_name ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="field-group mb-0">
                            <label><i class="fas fa-mobile-alt"></i> Parent Contact Number</label>
                            <span class="field-value">{{ $student->parent_mobile ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Uploaded Verification Documents Repository Card -->
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
            <div class="portal-card">
                <div class="portal-card-header emerald mb-4">
                    <i class="fas fa-folder-open fs-5"></i> Uploaded Verification Documents
                </div>
                <div class="row g-4">
                    @foreach($docsList as $field => $meta)
                        @php $hasDoc = !empty($student->$field); @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="doc-card">
                                <div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="doc-icon-box {{ $hasDoc ? 'active' : 'empty' }}">
                                            <i class="fas {{ $meta['icon'] }}"></i>
                                        </div>
                                        @if($hasDoc)
                                            <span class="doc-pill uploaded"><i class="fas fa-check-circle"></i> Uploaded</span>
                                        @else
                                            <span class="doc-pill missing"><i class="fas fa-exclamation-circle"></i> Document Not Available</span>
                                        @endif
                                    </div>
                                    <div class="doc-name">{{ $meta['title'] }}</div>
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
