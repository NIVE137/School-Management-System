<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Forgot Password — Education Management System</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/eeschool.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'Inter', sans-serif; overflow: hidden; background: #f8fafc; }
        .page { display: flex; height: 100vh; width: 100vw; }
        
        .left { flex: 0 0 55%; position: relative; overflow: hidden; background: #0a1628; display: flex; flex-direction: column; justify-content: space-between; padding: 48px; }
        .left .bg-img { position: absolute; inset: 0; background: url('{{ asset("assets/img/schooll.jpg") }}') center center / cover no-repeat; opacity: 0.35; transform: scale(1.04); animation: subtleZoom 20s ease-in-out infinite alternate; }
        @keyframes subtleZoom { from { transform: scale(1.04); } to { transform: scale(1.12); } }
        .left .overlay { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(8,15,40,0.92) 0%, rgba(15,30,80,0.85) 40%, rgba(5,60,100,0.80) 100%); }
        .left .circle { position: absolute; border-radius: 50%; background: rgba(255,255,255,0.04); animation: floatCircle 10s ease-in-out infinite; }
        .left .c1 { width:380px;height:380px;top:-120px;right:-100px; }
        .left .c2 { width:240px;height:240px;bottom:60px;left:-80px;animation-delay:3.5s; }
        @keyframes floatCircle { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-28px); } }
        .left-content { position: relative; z-index: 2; color: #fff; max-width: 480px; margin: auto 0; }
        .icon-badge { width: 68px; height: 68px; background: rgba(255,255,255,0.12); border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 24px; border: 1px solid rgba(255,255,255,0.18); backdrop-filter: blur(8px); }
        .left-content h1 { font-size: 2.2rem; font-weight: 800; line-height: 1.25; margin-bottom: 12px; letter-spacing: -0.5px; }
        .left-content p { font-size: 0.95rem; color: rgba(255,255,255,0.72); line-height: 1.6; }
        
        .right { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px; background: #ffffff; }
        .form-card { width: 100%; max-width: 400px; }
        .back-link { display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; font-weight: 600; color: #64748b; text-decoration: none; margin-bottom: 28px; transition: color 0.2s; }
        .back-link:hover { color: #696cff; }
        .form-card h2 { font-size: 1.65rem; font-weight: 800; color: #1e293b; letter-spacing: -0.4px; margin-bottom: 6px; }
        .form-card p { font-size: 0.88rem; color: #64748b; margin-bottom: 28px; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px; }
        .input-box { position: relative; }
        .input-box i.prefix-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.95rem; transition: color 0.2s; }
        .input-box input { width: 100%; padding: 12px 16px 12px 42px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.92rem; font-family: 'Inter', sans-serif; color: #0f172a; transition: all 0.2s; background: #fff; }
        .input-box input:focus { outline: none; border-color: #696cff; box-shadow: 0 0 0 3px rgba(105,108,255,0.15); }
        .input-box input:focus + i.prefix-icon { color: #696cff; }
        
        .btn-submit { width: 100%; padding: 13px; background: linear-gradient(135deg, #696cff 0%, #03c3ec 100%); color: #fff; border: none; border-radius: 10px; font-size: 0.95rem; font-weight: 700; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 16px rgba(105,108,255,0.3); }
        .btn-submit:hover { box-shadow: 0 6px 22px rgba(105,108,255,0.45); transform: translateY(-1px); }
        .btn-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

        @media (max-width: 900px) {
            .left { display: none; }
            .right { padding: 24px; }
            html, body { overflow: auto; }
            .page { height: auto; min-height: 100vh; }
        }
    </style>
</head>
<body>
<div class="page">
    <div class="left">
        <div class="bg-img"></div>
        <div class="overlay"></div>
        <div class="circle c1"></div>
        <div class="circle c2"></div>
        <div class="left-content">
            <div class="icon-badge"><i class="fas fa-key"></i></div>
            <h1>Forgot Your Student Password?</h1>
            <p>Enter your registered student email address to verify your account and reset your password.</p>
        </div>
    </div>
    <div class="right">
        <div class="form-card">
            <a href="{{ route('studentlogin') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Student Login</a>
            <h2>Forgot Password</h2>
            <p>Enter your student email address below.</p>
            <form id="studentForgetPasswordForm">
                @csrf
                <div class="form-group">
                    <label for="fp_email">Student Email Address</label>
                    <div class="input-box">
                        <input type="email" id="fp_email" name="email" placeholder="student@school.com" required>
                        <i class="fas fa-envelope prefix-icon"></i>
                    </div>
                </div>
                <button type="submit" class="btn-submit" id="btnSubmit">
                    <i class="fas fa-paper-plane me-2"></i> Verify Email & Continue
                </button>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('/assets') }}/vendor/libs/jquery/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    toastr.options = { closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 4000 };

    document.getElementById('studentForgetPasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmit');
        const emailVal = $("#fp_email").val().trim();

        if (!emailVal) {
            toastr.error("Please enter your email address.");
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Verifying...';

        $.ajax({
            url: "{{ route('studentcheckemail') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", email: emailVal },
            success: function(res) {
                if (res.status === "success") {
                    toastr.success("Email verified successfully! Redirecting...");
                    setTimeout(function() { window.location.href = res.redirect_url; }, 800);
                } else {
                    toastr.error(res.message || "Email does not exist.");
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Verify Email & Continue';
                }
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || xhr.responseJSON?.errors?.email?.[0] || "Something went wrong. Please try again.";
                toastr.error(msg);
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Verify Email & Continue';
            }
        });
    });
</script>
</body>
</html>
