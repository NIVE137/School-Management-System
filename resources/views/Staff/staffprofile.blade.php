@extends('Staff.stafflayout')
@section('content')
<style>
/* ── Modern Glassmorphism & Staff Profile Design ── */
.staff-profile-wrapper {
    position: relative;
    z-index: 1;
}

/* Floating School Icons Background */
.staff-bg-layer {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}
.staff-bg-icon {
    position: absolute;
    color: #696cff;
    opacity: 0.12;
    filter: drop-shadow(0 4px 10px rgba(105, 108, 255, 0.15));
    user-select: none;
}
[data-bs-theme="dark"] .staff-bg-icon {
    color: #818cf8;
    opacity: 0.16;
}

.staff-bg-icon.i1 { font-size: 52px; top: 3%;   left: 4%;   animation: floatStaffIcon1 22s ease-in-out infinite alternate; }
.staff-bg-icon.i2 { font-size: 46px; top: 16%;  right: 5%;  animation: floatStaffIcon2 25s ease-in-out infinite alternate; }
.staff-bg-icon.i3 { font-size: 40px; top: 42%;  left: 6%;   animation: floatStaffIcon3 19s ease-in-out infinite alternate; }
.staff-bg-icon.i4 { font-size: 58px; top: 65%;  right: 6%;  animation: floatStaffIcon1 27s ease-in-out infinite alternate; }
.staff-bg-icon.i5 { font-size: 48px; bottom: 5%;left: 5%;   animation: floatStaffIcon2 21s ease-in-out infinite alternate; }

@keyframes floatStaffIcon1 {
    0% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(35px, -40px) rotate(12deg); }
    100% { transform: translate(-25px, 25px) rotate(-8deg); }
}
@keyframes floatStaffIcon2 {
    0% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(-35px, 35px) rotate(-15deg); }
    100% { transform: translate(30px, -20px) rotate(10deg); }
}
@keyframes floatStaffIcon3 {
    0% { transform: translate(0, 0) rotate(0deg); }
    50% { transform: translate(25px, 40px) rotate(18deg); }
    100% { transform: translate(-35px, -30px) rotate(-12deg); }
}

/* Glassmorphism Hero Banner */
.profile-hero-card {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    border-radius: 20px;
    padding: 36px 32px;
    color: #ffffff;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 32px rgba(30, 58, 138, 0.28);
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
    color: #3b82f6;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid rgba(59, 130, 246, 0.12);
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
    background: rgba(59, 130, 246, 0.03);
    border: 1.5px solid var(--bs-border-color, #e7e7ff);
    border-radius: 10px;
    padding: 10px 14px;
    display: block;
    word-break: break-word;
}
</style>

<div class="staff-profile-wrapper">
    <!-- Floating School Icons Layer -->
    <div class="staff-bg-layer" aria-hidden="true">
        <i class="fas fa-chalkboard-teacher staff-bg-icon i1"></i>
        <i class="fas fa-book staff-bg-icon i2"></i>
        <i class="fas fa-graduation-cap staff-bg-icon i3"></i>
        <i class="fas fa-school staff-bg-icon i4"></i>
        <i class="fas fa-lightbulb staff-bg-icon i5"></i>
    </div>

    <!-- Hero Banner Card -->
    <div class="profile-hero-card">
        <div class="d-flex align-items-center gap-4 flex-wrap" style="position:relative;z-index:2;">
            <div class="avatar-wrapper">
                @if($staff->image && file_exists(public_path('asset/img/'.$staff->image)))
                    <img src="{{ asset('asset/img/'.$staff->image) }}" alt="{{ $staff->staff_name }}" class="profile-avatar-img">
                @else
                    <div class="profile-avatar-placeholder"><i class="fas fa-user-tie"></i></div>
                @endif
            </div>
            <div>
                <h2 class="hero-title">{{ $staff->staff_name }}</h2>
                <div class="d-flex gap-2 flex-wrap mt-2">
                    <span class="hero-pill"><i class="fas fa-id-card me-1"></i> Staff ID: {{ $staff->staff_id }}</span>
                    <span class="hero-pill"><i class="fas fa-briefcase me-1"></i> Role: {{ $staff->role_name }}</span>
                    <span class="hero-pill">
                        <span style="width:7px;height:7px;border-radius:50%;background:{{ strtolower($staff->status ?? 'active') == 'active' ? '#71dd37' : '#ff3e1d' }};"></span>
                        {{ ucfirst($staff->status ?? 'active') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Information Grid -->
    <div class="row g-4">
        <!-- Professional Information -->
        <div class="col-lg-6">
            <div class="profile-glass-card h-100">
                <div class="card-header-title"><i class="fas fa-user-shield fs-5"></i> Professional Information</div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-user"></i> Full Name</label>
                            <span class="info-val">{{ $staff->staff_name }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-hashtag"></i> Staff ID</label>
                            <span class="info-val">{{ $staff->staff_id }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-user-tag"></i> Role / Designation</label>
                            <span class="info-val">{{ $staff->role_name }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-toggle-on"></i> Account Status</label>
                            <span class="info-val" style="color:{{ strtolower($staff->status ?? 'active') == 'active' ? '#71dd37' : '#ff3e1d' }};">
                                <i class="fas fa-circle fs-6 me-1"></i> {{ ucfirst($staff->status ?? 'active') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact & Personal Details -->
        <div class="col-lg-6">
            <div class="profile-glass-card h-100">
                <div class="card-header-title"><i class="fas fa-id-card-alt fs-5"></i> Personal & Contact Info</div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-phone-alt"></i> Mobile Number</label>
                            <span class="info-val">{{ $staff->mobile }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-envelope"></i> Email Address</label>
                            <span class="info-val">{{ $staff->email }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-birthday-cake"></i> Date of Birth</label>
                            <span class="info-val">{{ $staff->dob ?? '—' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="info-item">
                            <label class="info-label"><i class="fas fa-map-marker-alt"></i> Address</label>
                            <span class="info-val">{{ $staff->address ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
