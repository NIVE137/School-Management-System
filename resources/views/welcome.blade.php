<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Management System</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/eeschool.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'Inter',sans-serif;min-height:100vh;background:linear-gradient(145deg,#0f172a 0%,#1e1e6e 55%,#0c3a5e 100%);display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;}
        .bubble{position:absolute;border-radius:50%;background:rgba(255,255,255,0.05);animation:float 8s ease-in-out infinite;}
        .b1{width:400px;height:400px;top:-150px;right:-100px;animation-delay:0s;}
        .b2{width:250px;height:250px;bottom:50px;left:-80px;animation-delay:3s;}
        .b3{width:180px;height:180px;top:40%;right:80px;animation-delay:6s;background:rgba(105,108,255,0.08);}
        @keyframes float{0%,100%{transform:translateY(0);}50%{transform:translateY(-24px);}}
        .center-card{background:rgba(255,255,255,0.06);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.12);border-radius:20px;padding:52px 48px;text-align:center;max-width:480px;width:90%;position:relative;z-index:2;}
        .logo-wrap{width:80px;height:80px;background:rgba(255,255,255,0.1);border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;border:1px solid rgba(255,255,255,0.15);}
        .logo-wrap img{height:48px;width:auto;mix-blend-mode:screen;}
        h1{font-size:2rem;font-weight:800;color:#fff;letter-spacing:-.5px;margin-bottom:8px;}
        p{color:rgba(255,255,255,0.55);font-size:0.9rem;margin-bottom:36px;line-height:1.6;}
        .portal-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:32px;}
        .portal-btn{background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.12);border-radius:12px;padding:18px 12px;text-decoration:none;color:#fff;transition:all .2s;display:flex;flex-direction:column;align-items:center;gap:8px;}
        .portal-btn:hover{background:rgba(105,108,255,0.25);border-color:rgba(105,108,255,0.4);transform:translateY(-3px);box-shadow:0 8px 24px rgba(105,108,255,0.3);color:#fff;}
        .portal-btn i{font-size:1.6rem;color:#a5c8ff;}
        .portal-btn span{font-size:0.76rem;font-weight:600;color:rgba(255,255,255,0.75);}
        .footer-note{font-size:0.72rem;color:rgba(255,255,255,0.3);}
    </style>
</head>
<body>
    <div class="bubble b1"></div>
    <div class="bubble b2"></div>
    <div class="bubble b3"></div>

    <div class="center-card">
        <div class="logo-wrap">
            <img src="{{ asset('assets/img/eeschool.png') }}" alt="eeschool">
        </div>
        <h1>EduManage</h1>
        <p>Welcome to the School Management System.<br>Choose your portal to continue.</p>

        <div class="portal-grid">
            <a href="{{ route('login') }}" class="portal-btn">
                <i class="fas fa-shield-halved"></i>
                <span>Admin</span>
            </a>
            <a href="{{ route('stafflogin') }}" class="portal-btn">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Staff</span>
            </a>
            <a href="{{ route('studentlogin') }}" class="portal-btn">
                <i class="fas fa-user-graduate"></i>
                <span>Student</span>
            </a>
        </div>

        <p class="footer-note">&#169; {{ date('Y') }} Education Management System. All rights reserved.</p>
    </div>
</body>
</html>
