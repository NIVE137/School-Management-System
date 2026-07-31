@extends('Staff.stafflayout')
@section('content')
<style>
/* ── Modern Education Management System Staff Profile Layout ── */
.staff-portal-wrapper {
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
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 45%, #2563eb 100%);
    border-radius: 24px;
    padding: 38px 40px;
    color: #ffffff;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 16px 36px rgba(30, 27, 75, 0.32);
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

.hero-staff-name {
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
    box-shadow: 0 6px 28px rgba(37, 99, 235, 0.07);
    padding: 26px;
    margin-bottom: 24px;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.portal-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 34px rgba(37, 99, 235, 0.13);
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
    border-bottom: 2px solid rgba(37, 99, 235, 0.12);
}
.portal-card-header.blue   { color: #2563eb; border-bottom-color: rgba(37, 99, 235, 0.15); }
.portal-card-header.indigo { color: #4338ca; border-bottom-color: rgba(67, 56, 202, 0.15); }
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
    background: rgba(37, 99, 235, 0.03);
    border: 1.5px solid var(--bs-border-color, #e2e8f0);
    border-radius: 12px;
    padding: 11px 16px;
    display: block;
    word-break: break-word;
}
</style>

<div class="staff-portal-wrapper">
    <!-- Full-Width Hero / Banner Section -->
    <div class="portal-hero-banner">
        <svg class="hero-svg-illustration d-none d-lg-block" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M40 50H160V150H40V50Z" stroke="white" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M70 80H130" stroke="white" stroke-width="6" stroke-linecap="round"/>
            <path d="M70 110H110" stroke="white" stroke-width="6" stroke-linecap="round"/>
        </svg>

        <div class="d-flex align-items-center gap-4 flex-wrap" style="position:relative;z-index:2;">
            <div class="hero-avatar-frame">
                @if($staff->image && file_exists(public_path('asset/img/'.$staff->image)))
                    <img src="{{ asset('asset/img/'.$staff->image) }}" alt="{{ $staff->staff_name }}" class="hero-avatar-img">
                @else
                    <div class="hero-avatar-placeholder"><i class="fas fa-user-tie"></i></div>
                @endif
            </div>
            <div>
                <h1 class="hero-staff-name">{{ $staff->staff_name }}</h1>
                <div class="d-flex gap-2 flex-wrap mt-2">
                    <span class="hero-badge-pill"><i class="fas fa-id-card"></i> Staff ID: {{ $staff->staff_id }}</span>
                    <span class="hero-badge-pill"><i class="fas fa-briefcase"></i> Designation: {{ $staff->role_name }}</span>
                    <span class="hero-badge-pill">
                        <span style="width:8px;height:8px;border-radius:50%;background:{{ strtolower($staff->status ?? 'active') == 'active' ? '#10b981' : '#ef4444' }};"></span>
                        {{ ucfirst($staff->status ?? 'active') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Multi-Column Card Layout -->
    <div class="row g-4">
        <!-- 1. Employment & Professional Details Card -->
        <div class="col-lg-4">
            <div class="portal-card h-100">
                <div class="portal-card-header blue">
                    <i class="fas fa-briefcase fs-5"></i> Employment Details
                </div>
                <div class="field-group">
                    <label><i class="fas fa-hashtag"></i> Staff ID Code</label>
                    <span class="field-value">{{ $staff->staff_id }}</span>
                </div>
                <div class="field-group">
                    <label><i class="fas fa-user-tag"></i> Designation / Role</label>
                    <span class="field-value">{{ $staff->role_name }}</span>
                </div>
                <div class="field-group mb-0">
                    <label><i class="fas fa-toggle-on"></i> Employment Status</label>
                    <span class="field-value" style="color:{{ strtolower($staff->status ?? 'active') == 'active' ? '#10b981' : '#ef4444' }};">
                        <i class="fas fa-circle me-1" style="font-size:0.6rem;"></i> {{ ucfirst($staff->status ?? 'active') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- 2. Personal Details Card -->
        <div class="col-lg-4">
            <div class="portal-card h-100">
                <div class="portal-card-header indigo">
                    <i class="fas fa-user-circle fs-5"></i> Personal Details
                </div>
                <div class="field-group">
                    <label><i class="fas fa-user"></i> Full Name</label>
                    <span class="field-value">{{ $staff->staff_name }}</span>
                </div>
                <div class="field-group mb-0">
                    <label><i class="fas fa-birthday-cake"></i> Date of Birth</label>
                    <span class="field-value">{{ $staff->dob ?? '—' }}</span>
                </div>
            </div>
        </div>

        <!-- 3. Contact Details Card -->
        <div class="col-lg-4">
            <div class="portal-card h-100">
                <div class="portal-card-header emerald">
                    <i class="fas fa-address-book fs-5"></i> Contact Details
                </div>
                <div class="field-group">
                    <label><i class="fas fa-phone-alt"></i> Mobile Number</label>
                    <span class="field-value">{{ $staff->mobile }}</span>
                </div>
                <div class="field-group">
                    <label><i class="fas fa-envelope"></i> Email Address</label>
                    <span class="field-value">{{ $staff->email }}</span>
                </div>
                <div class="field-group mb-0">
                    <label><i class="fas fa-map-marker-alt"></i> Residential Address</label>
                    <span class="field-value">{{ $staff->address ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
