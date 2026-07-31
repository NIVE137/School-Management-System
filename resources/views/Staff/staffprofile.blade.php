@extends('Staff.stafflayout')
@section('content')
<style>
/* ── Ultra-Premium Glassmorphism & Staff Profile Styling ── */
.staff-profile-container {
    position: relative;
    z-index: 1;
    animation: profileFadeIn 0.4s ease both;
}

@keyframes profileFadeIn {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Floating School Ambient Background */
.staff-ambient-bg {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}
.ambient-school-icon {
    position: absolute;
    color: #3b82f6;
    opacity: 0.13;
    filter: drop-shadow(0 6px 14px rgba(59, 130, 246, 0.18));
    user-select: none;
}
[data-bs-theme="dark"] .ambient-school-icon {
    color: #93c5fd;
    opacity: 0.17;
}

.ambient-school-icon.ic1 { font-size: 58px; top: 3%;   left: 4%;   animation: ambientFloat1 22s ease-in-out infinite alternate; }
.ambient-school-icon.ic2 { font-size: 50px; top: 16%;  right: 5%;  animation: ambientFloat2 26s ease-in-out infinite alternate; }
.ambient-school-icon.ic3 { font-size: 42px; top: 40%;  left: 6%;   animation: ambientFloat3 20s ease-in-out infinite alternate; }
.ambient-school-icon.ic4 { font-size: 64px; top: 65%;  right: 6%;  animation: ambientFloat1 28s ease-in-out infinite alternate; }
.ambient-school-icon.ic5 { font-size: 48px; bottom: 5%;left: 5%;   animation: ambientFloat2 24s ease-in-out infinite alternate; }

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
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #2563eb 100%);
    border-radius: 24px;
    padding: 40px 36px;
    color: #ffffff;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 16px 36px rgba(30, 27, 75, 0.32);
    backdrop-filter: blur(12px);
}
.profile-hero-banner::before {
    content: ''; position: absolute; top: -90px; right: -90px;
    width: 280px; height: 280px; border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0) 70%);
}
.profile-hero-banner::after {
    content: ''; position: absolute; bottom: -110px; left: 50px;
    width: 320px; height: 320px; border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
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

.hero-staff-name {
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
    box-shadow: 0 6px 30px rgba(37, 99, 235, 0.08);
    padding: 28px;
    margin-bottom: 28px;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.profile-section-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 36px rgba(37, 99, 235, 0.14);
}

.card-title-bar {
    font-size: 0.9rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 22px;
    padding-bottom: 12px;
    border-bottom: 2px solid rgba(37, 99, 235, 0.12);
    display: flex;
    align-items: center;
    gap: 10px;
}
.card-title-bar.blue { color: #2563eb; border-bottom-color: rgba(37, 99, 235, 0.15); }
.card-title-bar.indigo{ color: #6366f1; border-bottom-color: rgba(99, 102, 241, 0.15); }

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
    background: rgba(37, 99, 235, 0.03);
    border: 1.5px solid var(--bs-border-color, #e2e8f0);
    border-radius: 12px;
    padding: 11px 16px;
    display: block;
    word-break: break-word;
}
</style>

<div class="staff-profile-container">
    <!-- Floating School Ambient Background Layer -->
    <div class="staff-ambient-bg" aria-hidden="true">
        <i class="fas fa-chalkboard-teacher ambient-school-icon ic1"></i>
        <i class="fas fa-book ambient-school-icon ic2"></i>
        <i class="fas fa-graduation-cap ambient-school-icon ic3"></i>
        <i class="fas fa-school ambient-school-icon ic4"></i>
        <i class="fas fa-lightbulb ambient-school-icon ic5"></i>
    </div>

    <!-- Glassmorphism Gradient Hero Banner -->
    <div class="profile-hero-banner">
        <div class="d-flex align-items-center gap-4 flex-wrap" style="position:relative;z-index:2;">
            <div class="avatar-halo-wrapper">
                @if($staff->image && file_exists(public_path('asset/img/'.$staff->image)))
                    <img src="{{ asset('asset/img/'.$staff->image) }}" alt="{{ $staff->staff_name }}" class="profile-avatar-img">
                @else
                    <div class="profile-avatar-placeholder"><i class="fas fa-user-tie"></i></div>
                @endif
            </div>
            <div>
                <h1 class="hero-staff-name">{{ $staff->staff_name }}</h1>
                <div class="d-flex gap-2 flex-wrap mt-2">
                    <span class="hero-tag-pill"><i class="fas fa-id-card"></i> Staff ID: {{ $staff->staff_id }}</span>
                    <span class="hero-tag-pill"><i class="fas fa-briefcase"></i> Role: {{ $staff->role_name }}</span>
                    <span class="hero-tag-pill">
                        <span style="width:8px;height:8px;border-radius:50%;background:{{ strtolower($staff->status ?? 'active') == 'active' ? '#10b981' : '#ef4444' }};"></span>
                        {{ ucfirst($staff->status ?? 'active') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Information Cards Grid -->
    <div class="row g-4">
        <!-- Professional Information -->
        <div class="col-lg-6">
            <div class="profile-section-card h-100">
                <div class="card-title-bar blue">
                    <i class="fas fa-user-shield fs-5"></i> Professional Information
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-user"></i> Full Name</label>
                            <span class="profile-field-val">{{ $staff->staff_name }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-hashtag"></i> Staff ID</label>
                            <span class="profile-field-val">{{ $staff->staff_id }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-user-tag"></i> Role / Designation</label>
                            <span class="profile-field-val">{{ $staff->role_name }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-toggle-on"></i> Account Status</label>
                            <span class="profile-field-val" style="color:{{ strtolower($staff->status ?? 'active') == 'active' ? '#10b981' : '#ef4444' }};">
                                <i class="fas fa-circle fs-6 me-1"></i> {{ ucfirst($staff->status ?? 'active') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal & Contact Info -->
        <div class="col-lg-6">
            <div class="profile-section-card h-100">
                <div class="card-title-bar indigo">
                    <i class="fas fa-id-card-alt fs-5"></i> Personal & Contact Info
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-phone-alt"></i> Mobile Number</label>
                            <span class="profile-field-val">{{ $staff->mobile }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-envelope"></i> Email Address</label>
                            <span class="profile-field-val">{{ $staff->email }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-birthday-cake"></i> Date of Birth</label>
                            <span class="profile-field-val">{{ $staff->dob ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="profile-field-box">
                            <label class="profile-field-label"><i class="fas fa-map-marker-alt"></i> Residential Address</label>
                            <span class="profile-field-val">{{ $staff->address ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
