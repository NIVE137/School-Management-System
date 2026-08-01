<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sign In — School Management System</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/eeschool.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'Inter', sans-serif; overflow: hidden; }

        /* Full page layout */
        .page { display: flex; height: 100vh; width: 100vw; }

        /* LEFT PANEL */
        .left {
            flex: 0 0 58%;
            position: relative;
            overflow: hidden;
            background: #0a1628;
        }
        .left .bg-img {
            position: absolute; inset: 0;
            background: url('{{ asset("assets/img/schooll.jpg") }}') center center / cover no-repeat;
            opacity: 0.35;
            transform: scale(1.04);
            animation: subtleZoom 20s ease-in-out infinite alternate;
        }
        @keyframes subtleZoom { from { transform: scale(1.04); } to { transform: scale(1.12); } }

        .left .overlay {
            position: absolute; inset: 0;
            background: linear-gradient(
                135deg,
                rgba(8, 15, 40, 0.92) 0%,
                rgba(15, 30, 80, 0.85) 40%,
                rgba(5, 60, 100, 0.80) 100%
            );
        }

        .left .circle {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.04);
            animation: floatCircle 10s ease-in-out infinite;
        }
        .left .c1 { width:380px;height:380px;top:-120px;right:-100px;animation-delay:0s; }
        .left .c2 { width:240px;height:240px;bottom:60px;left:-80px;animation-delay:3.5s; }
        .left .c3 { width:160px;height:160px;top:38%;right:80px;animation-delay:7s;background:rgba(14,165,233,0.08); }
        @keyframes floatCircle {
            0%,100% { transform: translateY(0) rotate(0deg); }
            50%      { transform: translateY(-28px) rotate(6deg); }
        }

        .left .content {
            position: relative; z-index: 2;
            height: 100%; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 60px 56px; text-align: center;
        }

        .left .school-logo {
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 22px; width: fit-content;
        }
        .left .school-logo img {
            height: 60px; width: auto; mix-blend-mode: screen;
        }

        .left h1 {
            font-size: 2.2rem; font-weight: 900; color: #fff;
            letter-spacing: -0.6px; line-height: 1.15; margin-bottom: 10px;
        }
        .left h1 span { color: #38bdf8; }
        .left .sub {
            font-size: 0.95rem; color: rgba(255,255,255,0.55);
            max-width: 380px; line-height: 1.65; margin-bottom: 40px;
        }

        .stats-row { display: flex; gap: 18px; margin-bottom: 44px; }
        .stat-box {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 14px; padding: 18px 22px; text-align: center;
            backdrop-filter: blur(8px); flex: 1; transition: background 0.2s;
        }
        .stat-box:hover { background: rgba(255,255,255,0.11); }
        .stat-box .num { font-size: 1.6rem; font-weight: 800; color: #fff; line-height: 1; }
        .stat-box .lbl { font-size: 0.7rem; color: rgba(255,255,255,0.5); font-weight: 500; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.8px; }
        .stat-box i { font-size: 1.3rem; margin-bottom: 8px; display: block; }

        .feat-row { display: flex; gap: 10px; flex-wrap: wrap; justify-content: center; }
        .feat {
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.10);
            border-radius: 20px; padding: 6px 14px; font-size: 0.72rem; font-weight: 600;
            color: rgba(255,255,255,0.65); display: inline-flex; align-items: center; gap: 6px;
        }
        .feat i { color: #7dd3fc; font-size: 0.82rem; }

        .illus-strip {
            position: absolute; bottom: 0; left: 0; right: 0; height: 140px; z-index: 2;
            background: linear-gradient(to top, rgba(8,15,40,0.95) 0%, transparent 100%);
            display: flex; align-items: flex-end; justify-content: center; padding-bottom: 20px; gap: 12px;
        }
        .illus-strip img {
            height: 90px; width: 90px; border-radius: 12px; object-fit: cover; opacity: 0.7;
            border: 2px solid rgba(255,255,255,0.12); transition: all 0.3s;
        }
        .illus-strip img:hover { opacity: 1; transform: translateY(-4px); }

        /* RIGHT PANEL */
        .right {
            flex: 0 0 42%; background: #ffffff;
            display: flex; align-items: center; justify-content: center;
            padding: 50px 56px; position: relative; overflow: hidden;
        }
        .right::before {
            content: ''; position: absolute; top: -80px; right: -80px;
            width: 300px; height: 300px; border-radius: 50%; background: rgba(14,165,233,0.04);
        }
        .right::after {
            content: ''; position: absolute; bottom: -100px; left: -60px;
            width: 280px; height: 280px; border-radius: 50%; background: rgba(99,102,241,0.04);
        }

        .form-wrap { width: 100%; max-width: 360px; position: relative; z-index: 1; }

        .portal-badge {
            display: inline-flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, rgba(14,165,233,0.10), rgba(16,185,129,0.08));
            border: 1px solid rgba(14,165,233,0.20);
            border-radius: 20px; padding: 5px 14px; font-size: 0.73rem; font-weight: 700;
            color: #0284c7; margin-bottom: 22px; letter-spacing: 0.3px;
        }

        .form-title { font-size: 1.75rem; font-weight: 800; color: #0f172a; letter-spacing: -0.5px; margin-bottom: 5px; }
        .form-sub { font-size: 0.875rem; color: #94a3b8; margin-bottom: 32px; line-height: 1.5; }

        .fg { margin-bottom: 20px; }
        .fg label { display: block; font-size: 0.78rem; font-weight: 700; color: #475569; margin-bottom: 7px; letter-spacing: 0.3px; }
        .iw { position: relative; }
        .iw .ico { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.88rem; pointer-events: none; }
        .iw input {
            width: 100%; padding: 12px 14px 12px 42px;
            border: 1.5px solid #e2e8f0; border-radius: 11px;
            font-size: 0.9rem; font-family: 'Inter', sans-serif;
            color: #0f172a; background: #fff; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .iw input:focus { outline: none; border-color: #0ea5e9; box-shadow: 0 0 0 3px rgba(14,165,233,0.13); }
        .iw input::placeholder { color: #cbd5e1; }
        .iw .eye { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 0.9rem; padding: 0; }
        .iw .eye:hover { color: #0ea5e9; }

        .row-middle { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .remember-wrap { display: flex; align-items: center; gap: 7px; font-size: 0.8rem; color: #64748b; font-weight: 500; }
        .remember-wrap input { accent-color: #0ea5e9; cursor: pointer; }
        .forgot-link { font-size: 0.8rem; color: #ef4444; text-decoration: none; font-weight: 600; }
        .forgot-link:hover { text-decoration: underline; }

        .btn-sign {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, #0ea5e9, #10b981);
            color: #fff; border: none; border-radius: 11px;
            font-size: 0.95rem; font-weight: 800; font-family: 'Inter', sans-serif;
            cursor: pointer; transition: all 0.2s; letter-spacing: 0.2px;
            box-shadow: 0 4px 18px rgba(14,165,233,0.30);
        }
        .btn-sign:hover {
            background: linear-gradient(135deg, #0284c7, #059669);
            box-shadow: 0 8px 28px rgba(14,165,233,0.42); transform: translateY(-1px);
        }
        .btn-sign:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }

        .or-divider { display: flex; align-items: center; gap: 12px; margin: 22px 0; }
        .or-divider::before, .or-divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
        .or-divider span { font-size: 0.74rem; color: #94a3b8; font-weight: 500; white-space: nowrap; }

        .portal-links { display: flex; gap: 10px; }
        .pl {
            flex: 1; padding: 10px 8px; border: 1.5px solid #e2e8f0; border-radius: 10px;
            text-decoration: none; text-align: center; font-size: 0.74rem; font-weight: 600; color: #475569;
            transition: all 0.2s;
        }
        .pl:hover { border-color: #0ea5e9; color: #0ea5e9; background: rgba(14,165,233,0.04); }
        .pl i { display: block; font-size: 1.1rem; margin-bottom: 4px; }

        .secure-note { text-align: center; margin-top: 20px; font-size: 0.72rem; color: #cbd5e1; }
        .secure-note i { color: #10b981; margin-right: 4px; }

        @media (max-width: 900px) { .left { display: none; } .right { flex: 1; padding: 40px 28px; } }
    </style>
</head>
<body>
<div class="page">

    <!-- LEFT PANEL -->
    <div class="left">
        <div class="bg-img"></div>
        <div class="overlay"></div>
        <div class="circle c1"></div>
        <div class="circle c2"></div>
        <div class="circle c3"></div>

        <div class="content">
            <div class="school-logo">
                <img src="{{ asset('assets/img/eeschool.png') }}" alt="eeschool logo">
            </div>

            <h1>Student Learning<br><span>Portal</span></h1>
            <p class="sub">View your academic profile, attendance history, class schedules, and documents all in one location.</p>

            <div class="stats-row">
                <div class="stat-box">
                    <i class="fas fa-user-graduate" style="color:#38bdf8;"></i>
                    <div class="num">Student</div>
                    <div class="lbl">Profile</div>
                </div>
                <div class="stat-box">
                    <i class="fas fa-calendar-check" style="color:#34d399;"></i>
                    <div class="num">Attendance</div>
                    <div class="lbl">History</div>
                </div>
                <div class="stat-box">
                    <i class="fas fa-file-alt" style="color:#f59e0b;"></i>
                    <div class="num">Docs</div>
                    <div class="lbl">Vault</div>
                </div>
            </div>

            <div class="feat-row">
                <div class="feat"><i class="fas fa-graduation-cap"></i> Class Profile</div>
                <div class="feat"><i class="fas fa-calendar-alt"></i> Attendance Logs</div>
                <div class="feat"><i class="fas fa-folder"></i> Documents</div>
                <div class="feat"><i class="fas fa-shield-halved"></i> Verified Portal</div>
            </div>
        </div>

        <div class="illus-strip">
            <img src="{{ asset('assets/img/student1.jpg') }}" alt="Student">
            <img src="{{ asset('assets/img/staff1.jpg') }}" alt="Staff">
            <img src="{{ asset('assets/img/school.jpg') }}" alt="School">
            <img src="{{ asset('assets/img/student2.jpg') }}" alt="Student">
            <img src="{{ asset('assets/img/staff2.jpg') }}" alt="Staff">
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right">
        <div class="form-wrap">
            <div class="portal-badge">
                <i class="fas fa-user-graduate"></i> Student Portal
            </div>
            <h2 class="form-title">Welcome back 👋</h2>
            <p class="form-sub">Sign in to access your student account and profile.</p>

            <form id="studentLoginForm">
                @csrf
                <div class="fg">
                    <label>Email Address</label>
                    <div class="iw">
                        <i class="fas fa-envelope ico"></i>
                        <input type="email" id="email" name="email" placeholder="student@school.com" autocomplete="email">
                    </div>
                </div>
                <div class="fg">
                    <label>Password</label>
                    <div class="iw">
                        <i class="fas fa-lock ico"></i>
                        <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password">
                        <button type="button" class="eye" onclick="togglePw()"><i class="fas fa-eye" id="eye-icon"></i></button>
                    </div>
                </div>
                <div class="row-middle">
                    <label class="remember-wrap">
                        <input type="checkbox" id="remember"> Remember me
                    </label>
                    <a href="{{ route('studentforgetpassword') }}" class="forgot-link"><i class="fas fa-key me-1"></i>Forgot Password?</a>
                </div>
                <button type="button" id="login-btn" class="btn-sign">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In to Portal
                </button>
            </form>

            <div class="or-divider"><span>Other portals</span></div>

            <div class="portal-links">
                <a href="{{ route('login') }}" class="pl">
                    <i class="fas fa-shield-halved"></i>Admin
                </a>
                <a href="{{ route('stafflogin') }}" class="pl">
                    <i class="fas fa-chalkboard-teacher"></i>Staff
                </a>
            </div>

            <p class="secure-note"><i class="fas fa-lock"></i>Secure &amp; encrypted connection</p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    toastr.options = { closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: "3500" };

    function togglePw() {
        const inp = document.getElementById('password');
        const ic  = document.getElementById('eye-icon');
        if (inp.type === 'password') { inp.type = 'text';     ic.classList.replace('fa-eye','fa-eye-slash'); }
        else                          { inp.type = 'password'; ic.classList.replace('fa-eye-slash','fa-eye'); }
    }

    document.getElementById('login-btn').addEventListener('click', function () {
        const btn   = $(this);
        const email = $('#email').val().trim();
        const pass  = $('#password').val();

        if (!email || !pass) { toastr.warning('Please enter your email and password.'); return; }

        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Signing in...');

        $.ajax({
            url:  "{{ route('studentlogin') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", email: email, password: pass },
            headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
            success: function (res) {
                if (res.status === 'success') {
                    toastr.success('Login successful!');
                    setTimeout(() => window.location.href = res.redirect_url, 700);
                } else {
                    toastr.error(res.message || 'Invalid credentials.');
                    btn.prop('disabled', false).html('<i class="fas fa-sign-in-alt me-2"></i>Sign In to Portal');
                }
            },
            error: function (xhr) {
                let msg = 'Something went wrong. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors)[0][0];
                }
                toastr.error(msg);
                btn.prop('disabled', false).html('<i class="fas fa-sign-in-alt me-2"></i>Sign In to Portal');
            }
        });
    });

    document.getElementById('password').addEventListener('keypress', function (e) {
        if (e.which === 13) document.getElementById('login-btn').click();
    });
</script>
</body>
</html>
