<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
      data-skin="default"
      data-assets-path="{{ asset('/assets') }}/"
      data-template="vertical-menu-template">
<head>
<script>
    (function(){
        var saved = localStorage.getItem('theme');
        if (!saved || saved === 'system') {
            saved = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        document.documentElement.setAttribute('data-bs-theme', saved);
    })();
</script>

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,minimum-scale=1.0,maximum-scale=1.0"/>
    <title>Student Portal - Education Management System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/eeschool.png') }}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>

    <link rel="stylesheet" href="{{ asset('/assets') }}/vendor/fonts/iconify-icons.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('/assets') }}/vendor/css/core.css"/>
    <link rel="stylesheet" href="{{ asset('/assets') }}/css/demo.css"/>
    <link rel="stylesheet" href="{{ asset('css/school-theme.css') }}"/>

    <script src="{{ asset('/assets') }}/vendor/js/helpers.js"></script>
    <script src="{{ asset('/assets') }}/js/config.js"></script>
    @stack('styles')
</head>
<body>
<div class="layout-wrapper layout-content-navbar">
<div class="layout-container">

<style>
/* Glassmorphism Sidebar Redesign */
aside#layout-menu {
    background: rgba(255, 255, 255, 0.85) !important;
    backdrop-filter: blur(16px) !important;
    -webkit-backdrop-filter: blur(16px) !important;
    border-right: 1px solid rgba(105, 108, 255, 0.14) !important;
    box-shadow: 4px 0 24px rgba(105, 108, 255, 0.06) !important;
}
[data-bs-theme="dark"] aside#layout-menu {
    background: rgba(26, 31, 56, 0.9) !important;
    border-right-color: rgba(255, 255, 255, 0.08) !important;
    box-shadow: 4px 0 24px rgba(0, 0, 0, 0.25) !important;
}

.sidebar-profile-widget {
    margin: 16px 16px 20px 16px;
    padding: 14px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(6, 182, 212, 0.08) 100%);
    border: 1px solid rgba(99, 102, 241, 0.18);
    border-radius: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    backdrop-filter: blur(8px);
}

.sidebar-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 2px solid #6366f1;
    object-fit: cover;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
}
.sidebar-avatar-placeholder {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 2px solid #6366f1;
    background: rgba(99, 102, 241, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6366f1;
    font-size: 1.1rem;
}

.sidebar-user-name {
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--bs-heading-color, #1e293b);
    line-height: 1.2;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 120px;
}

.sidebar-role-badge {
    font-size: 0.68rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 12px;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #ffffff;
    display: inline-block;
}

.menu-inner .menu-item {
    margin: 4px 12px !important;
}
.menu-inner .menu-link {
    border-radius: 12px !important;
    padding: 10px 16px !important;
    font-weight: 600 !important;
    transition: all 0.25s ease !important;
}
.menu-inner .menu-item.active > .menu-link {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 16px rgba(99, 102, 241, 0.35) !important;
}
.menu-inner .menu-item:not(.active) > .menu-link:hover {
    background: rgba(99, 102, 241, 0.08) !important;
    transform: translateX(4px);
}
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand demo">
        <a href="{{ route('studentprofile') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <img src="{{ asset('assets/img/eeschool.png') }}" alt="eeschool" style="height:36px;width:auto;mix-blend-mode:screen;">
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2" style="font-size:1.05rem;color:#6366f1;">Education MS</span>
        </a>
    </div>

    @php
        $studentUser = Auth::guard('student')->user();
    @endphp
    @if($studentUser)
    <div class="sidebar-profile-widget">
        @if($studentUser->image && file_exists(public_path('asset/img/'.$studentUser->image)))
            <img src="{{ asset('asset/img/'.$studentUser->image) }}" alt="Profile" class="sidebar-avatar">
        @else
            <div class="sidebar-avatar-placeholder"><i class="fas fa-user-graduate"></i></div>
        @endif
        <div>
            <div class="sidebar-user-name">{{ $studentUser->student_name }}</div>
            <span class="sidebar-role-badge"><i class="fas fa-graduation-cap me-1"></i> Student</span>
        </div>
    </div>
    @endif

    <ul class="menu-inner py-1">
        <li class="menu-item @if(Route::is('studentprofile')) active @endif">
            <a href="{{ route('studentprofile') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-user"></i>
                <div>My Profile</div>
            </a>
        </li>
        <li class="menu-item mt-3">
            <a class="menu-link" data-bs-toggle="modal" data-bs-target="#studentLogoutModal" style="cursor:pointer;">
                <i class="menu-icon ti tabler-logout" style="color:#ff3e1d;"></i>
                <div style="color:#ff3e1d;">Logout</div>
            </a>
        </li>
    </ul>
</aside>

<div class="layout-page">
    <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill" id="nav-theme" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <i class="icon-base ti tabler-sun icon-22px theme-icon-active text-heading"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><button type="button" class="dropdown-item" data-bs-theme-value="light">Light</button></li>
                        <li><button type="button" class="dropdown-item" data-bs-theme-value="dark">Dark</button></li>
                        <li><button type="button" class="dropdown-item" data-bs-theme-value="system">System</button></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="school-bg-animated-layer" aria-hidden="true">
            <i class="fas fa-graduation-cap school-icon ic1"></i>
            <i class="fas fa-book-open school-icon ic2"></i>
            <i class="fas fa-pencil-alt school-icon ic3"></i>
            <i class="fas fa-school school-icon ic4"></i>
            <i class="fas fa-globe school-icon ic5"></i>
            <i class="fas fa-lightbulb school-icon ic6"></i>
            <i class="fas fa-book-bookmark school-icon ic7"></i>
            <i class="fas fa-ruler-combined school-icon ic8"></i>
            <i class="fas fa-user-graduate school-icon ic9"></i>
            <i class="fas fa-award school-icon ic10"></i>
        </div>
        <div class="container-xxl flex-grow-1 container-p-y">
            @yield('content')
        </div>

        <div class="modal fade" id="studentLogoutModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content text-center p-4" style="border-radius:14px;border:none;">
                    <h6 class="fw-bold mb-3">Signing out?</h6>
                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('studentlogout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-danger px-4">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<script src="{{ asset('/assets') }}/vendor/libs/jquery/jquery.js"></script>
<script src="{{ asset('/assets') }}/vendor/js/bootstrap.js"></script>
<script>
    function applyTheme(theme) {
        var activeTheme = theme;
        if (theme === 'system') {
            activeTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        document.documentElement.setAttribute('data-bs-theme', activeTheme);
        localStorage.setItem('theme', theme);
    }
    $(document).ready(function(){
        var savedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(savedTheme);
        $('[data-bs-theme-value]').on('click', function(){ applyTheme($(this).attr('data-bs-theme-value')); });
    });
</script>
@stack('scripts')
</body>
</html>
