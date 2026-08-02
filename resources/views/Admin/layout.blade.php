<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
      data-skin="default"
      data-assets-path="{{ asset('/assets') }}/"
      data-template="vertical-menu-template">
<head>
<script>
    /* Dark/Light mode — instant load before rendering body to prevent white flash */
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
    <title>Education Management System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/eeschool.png') }}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('/assets') }}/vendor/fonts/iconify-icons.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('/assets') }}/vendor/libs/node-waves/node-waves.css"/>
    <link rel="stylesheet" href="{{ asset('/assets') }}/vendor/libs/pickr/pickr-themes.css"/>
    <link rel="stylesheet" href="{{ asset('/assets') }}/vendor/css/core.css"/>
    <link rel="stylesheet" href="{{ asset('/assets') }}/css/demo.css"/>
    <link rel="stylesheet" href="{{ asset('/assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"/>
    <link rel="stylesheet" href="{{ asset('/assets') }}/vendor/libs/apex-charts/apex-charts.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/school-theme.css') }}"/>

    <!-- helpers & config -->
    <script src="{{ asset('/assets') }}/vendor/js/helpers.js"></script>
    <script src="{{ asset('/assets') }}/js/config.js"></script>

    @stack('styles')
</head>
<body>
<div class="layout-wrapper layout-content-navbar">
<div class="layout-container">

<!-- ═══ SIDEBAR ═══ -->
<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand demo">
        <a href="{{ route('admindashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <img src="{{ asset('assets/img/eeschool.png') }}" alt="eeschool" style="height:34px;width:auto;mix-blend-mode:screen;">
                </span>
            </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
            <i class="icon-base ti tabler-x d-block d-xl-none"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item @if(Route::is('admindashboard')) active @endif">
            <a href="{{ route('admindashboard') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-smart-home"></i>
                <div>Dashboard</div>
            </a>
        </li>
        <li class="menu-item @if(Route::is('staffmanagement')||Route::is('createstaff')||Route::is('createrole')||Route::is('editstaff')) active @endif">
            <a href="{{ route('staffmanagement') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-user-check"></i>
                <div>Staff Management</div>
            </a>
        </li>
        <li class="menu-item @if(Route::is('studentmanagement')||Route::is('createclass')||Route::is('createstudent')||Route::is('uploaddocuments')||Route::is('editstudent')) active @endif">
            <a href="{{ route('studentmanagement') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-users"></i>
                <div>Student Management</div>
            </a>
        </li>
        <li class="menu-item @if(Route::is('studentattendance')) active @endif">
            <a href="{{ route('studentattendance') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-calendar-check"></i>
                <div>Student Attendance</div>
            </a>
        </li>
        <li class="menu-item @if(Route::is('staffattendance')) active @endif">
            <a href="{{ route('staffattendance') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-clock-check"></i>
                <div>Staff Attendance</div>
            </a>
        </li>
        <li class="menu-item @if(Route::is('leaverequests')) active @endif">
            <a href="{{ route('leaverequests') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-calendar-off"></i>
                <div>Leave Requests</div>
            </a>
        </li>
        <li class="menu-item mt-3">
            <a class="menu-link" data-bs-toggle="modal" data-bs-target="#logoutModal" style="cursor:pointer;">
                <i class="menu-icon ti tabler-logout" style="color:#ff3e1d;"></i>
                <div style="color:#ff3e1d;">Logout</div>
            </a>
        </li>
    </ul>
</aside>

<div class="menu-mobile-toggler d-xl-none rounded-1">
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
        <i class="ti tabler-menu icon-base"></i>
    </a>
</div>

<!-- ═══ MAIN PAGE ═══ -->
<div class="layout-page">
    <!-- Navbar -->
    <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="icon-base ti tabler-menu-2 icon-md"></i>
            </a>
        </div>
        <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                <!-- Theme switcher -->
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                       id="nav-theme" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <i class="icon-base ti tabler-sun icon-22px theme-icon-active text-heading"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><button type="button" class="dropdown-item align-items-center" data-bs-theme-value="light"><i class="icon-base ti tabler-sun icon-22px me-3"></i>Light</button></li>
                        <li><button type="button" class="dropdown-item align-items-center" data-bs-theme-value="dark"><i class="icon-base ti tabler-moon icon-22px me-3"></i>Dark</button></li>
                        <li><button type="button" class="dropdown-item align-items-center" data-bs-theme-value="system"><i class="icon-base ti tabler-device-desktop icon-22px me-3"></i>System</button></li>
                    </ul>
                </li>
                <!-- Notification Bell Dropdown -->
                <li class="nav-item dropdown me-2 position-relative">
                    <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill position-relative"
                       id="nav-notifications" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="icon-base ti tabler-bell icon-22px text-heading"></i>
                        <span class="badge bg-danger rounded-circle position-absolute"
                              id="notifBadgeCount"
                              style="top: 2px; right: 2px; font-size: 0.62rem; padding: 3px 6px; min-width: 18px; display: {{ ($unreadCount ?? 0) > 0 ? 'inline-block' : 'none' }};">
                            {{ $unreadCount ?? 0 }}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end py-0 shadow-lg border-0" style="width: 350px; max-height: 450px; border-radius: 14px; overflow: hidden;">
                        <div class="dropdown-header d-flex align-items-center justify-content-between py-3 px-3 border-bottom bg-body-tertiary">
                            <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                                <i class="fas fa-bell text-primary"></i> Notifications
                            </h6>
                            <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none fw-semibold text-primary" style="font-size: 0.75rem;" onclick="markAllNotificationsAsRead()">
                                Mark all read
                            </button>
                        </div>
                        <div class="dropdown-notif-body" id="notifListContainer" style="max-height: 380px; overflow-y: auto;">
                            @if(isset($adminNotifications) && count($adminNotifications) > 0)
                                @foreach($adminNotifications as $notif)
                                    <a href="{{ $notif->action_url ?? 'javascript:void(0)' }}"
                                       onclick="markNotificationRead({{ $notif->id }}, this)"
                                       class="dropdown-item py-3 px-3 border-bottom d-flex align-items-start gap-3 notif-item {{ !$notif->is_read ? 'bg-primary-subtle' : '' }}"
                                       style="white-space: normal; transition: background 0.2s;">
                                        <div class="flex-shrink-0 mt-1">
                                            @if($notif->type === 'leave_request')
                                                <div class="avatar-initial rounded-circle bg-warning text-white p-2" style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                                                    <i class="fas fa-calendar-minus fa-sm"></i>
                                                </div>
                                            @elseif($notif->type === 'student_registered')
                                                <div class="avatar-initial rounded-circle bg-success text-white p-2" style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                                                    <i class="fas fa-user-graduate fa-sm"></i>
                                                </div>
                                            @elseif($notif->type === 'staff_registered')
                                                <div class="avatar-initial rounded-circle bg-info text-white p-2" style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                                                    <i class="fas fa-chalkboard-teacher fa-sm"></i>
                                                </div>
                                            @elseif($notif->type === 'document_uploaded')
                                                <div class="avatar-initial rounded-circle bg-primary text-white p-2" style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                                                    <i class="fas fa-file-upload fa-sm"></i>
                                                </div>
                                            @else
                                                <div class="avatar-initial rounded-circle bg-secondary text-white p-2" style="width:34px;height:34px;display:flex;align-items:center;justify-content:center;">
                                                    <i class="fas fa-bell fa-sm"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <span class="fw-bold text-dark" style="font-size: 0.82rem;">{{ $notif->title }}</span>
                                                <small class="text-muted" style="font-size: 0.68rem;">{{ $notif->created_at ? $notif->created_at->diffForHumans() : '' }}</small>
                                            </div>
                                            <p class="mb-0 text-secondary" style="font-size: 0.76rem; line-height: 1.35;">{{ $notif->message }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="text-center py-4 px-3 text-muted">
                                    <i class="fas fa-bell-slash fa-2x mb-2 text-secondary opacity-50"></i>
                                    <p class="mb-0" style="font-size: 0.8rem;">No notifications found</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </li>
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="{{ asset('assets/img/img1.png') }}" alt class="rounded-circle"/>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item mt-0" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('assets/img/img1.png') }}" alt class="rounded-circle"/>
                                        </div>
                                    </div>
                                    <div>
                                        <small class="fw-semibold d-block">Administrator</small>
                                        <small class="text-muted">Admin Panel</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal" style="cursor:pointer;"><i class="ti tabler-logout me-2"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Content -->
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

        <!-- Logout Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content text-center p-4" style="border-radius:14px;border:none;">
                    <div class="mb-3">
                        <div style="width:60px;height:60px;background:rgba(255,62,29,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                            <i class="ti tabler-logout" style="font-size:26px;color:#ff3e1d;"></i>
                        </div>
                    </div>
                    <h6 class="fw-bold mb-1">Signing out?</h6>
                    <p class="text-muted mb-4" style="font-size:0.85rem;">Are you sure you want to logout?</p>
                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-danger px-4">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
                <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                    <div class="text-body" style="font-size:0.82rem;">
                        &#169; <script>document.write(new Date().getFullYear())</script>, School Management System
                    </div>
                </div>
            </div>
        </footer>
        <div class="content-backdrop fade"></div>
    </div>
</div>
</div>
</div>

<!-- SCRIPTS -->
<script src="{{ asset('/assets') }}/vendor/libs/jquery/jquery.js"></script>
<script src="{{ asset('/assets') }}/vendor/libs/popper/popper.js"></script>
<script src="{{ asset('/assets') }}/vendor/js/bootstrap.js"></script>
<script src="{{ asset('/assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="{{ asset('/assets') }}/vendor/js/menu.js"></script>
<script src="{{ asset('/assets') }}/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    /* Theme switcher handler */
    function applyTheme(theme) {
        var activeTheme = theme;
        if (theme === 'system') {
            activeTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        document.documentElement.setAttribute('data-bs-theme', activeTheme);
        localStorage.setItem('theme', theme);

        // Update Theme Icon
        var icon = document.querySelector('#nav-theme i');
        if (icon) {
            icon.className = activeTheme === 'dark'
                ? 'icon-base ti tabler-moon icon-22px text-heading'
                : 'icon-base ti tabler-sun icon-22px text-heading';
        }
    }

    $(document).ready(function(){
        var savedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(savedTheme);

        $('[data-bs-theme-value]').on('click', function(){
            var val = $(this).attr('data-bs-theme-value');
            applyTheme(val);
        });

        /* Flash messages */
        toastr.options = { closeButton:true, progressBar:true, positionClass:"toast-top-right", timeOut:"3500" };
        @if(session('success')) toastr.success("{{ addslashes(session('success')) }}"); @endif
        @if(session('error'))   toastr.error("{{ addslashes(session('error')) }}");     @endif
        @if(session('warning')) toastr.warning("{{ addslashes(session('warning')) }}"); @endif
        @if(session('info'))    toastr.info("{{ addslashes(session('info')) }}");       @endif
    });

    /* Notification Functions */
    function markNotificationRead(id, element) {
        $.ajax({
            url: "{{ url('/Admin/mark-notification-read') }}/" + id,
            type: "POST",
            data: { _token: "{{ csrf_token() }}" },
            success: function() {
                if (element) {
                    $(element).removeClass('bg-primary-subtle');
                }
                updateNotifBadge();
            }
        });
    }

    function markAllNotificationsAsRead() {
        $.ajax({
            url: "{{ route('admin.markAllNotificationsRead') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}" },
            success: function() {
                $('.notif-item').removeClass('bg-primary-subtle');
                $('#notifBadgeCount').hide().text('0');
                toastr.success('All notifications marked as read.');
            }
        });
    }

    function updateNotifBadge() {
        $.ajax({
            url: "{{ route('admin.getNotifications') }}",
            type: "GET",
            success: function(res) {
                if (res.unreadCount > 0) {
                    $('#notifBadgeCount').text(res.unreadCount).show();
                } else {
                    $('#notifBadgeCount').hide().text('0');
                }
            }
        });
    }
</script>

@stack('scripts')
</body>
</html>
