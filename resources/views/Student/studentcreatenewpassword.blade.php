<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Create New Password — Education Management System</title>
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
        .form-card h2 { font-size: 1.65rem; font-weight: 800; color: #1e293b; letter-spacing: -0.4px; margin-bottom: 6px; }
        .form-card p { font-size: 0.88rem; color: #64748b; margin-bottom: 28px; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 0.82rem; font-weight: 600; color: #334155; margin-bottom: 8px; }
        .input-box { position: relative; }
        .input-box i.prefix-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.95rem; transition: color 0.2s; }
        .input-box input { width: 100%; padding: 12px 42px 12px 42px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.92rem; font-family: 'Inter', sans-serif; color: #0f172a; transition: all 0.2s; background: #fff; }
        .input-box input:focus { outline: none; border-color: #696cff; box-shadow: 0 0 0 3px rgba(105,108,255,0.15); }
        .input-box input:focus + i.prefix-icon { color: #696cff; }
        .toggle-pw { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 0.95rem; padding: 0; }
        .toggle-pw:hover { color: #696cff; }
        
        .strength-bar { height: 4px; border-radius: 2px; background: #e2e8f0; overflow: hidden; margin-top: 8px; }
        .strength-fill { height: 100%; border-radius: 2px; transition: width 0.3s, background 0.3s; width: 0%; }
        
        .btn-submit { width: 100%; padding: 13px; background: linear-gradient(135deg, #696cff 0%, #03c3ec 100%); color: #fff; border: none; border-radius: 10px; font-size: 0.95rem; font-weight: 700; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 16px rgba(105,108,255,0.3); margin-top: 10px; }
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
            <div class="icon-badge"><i class="fas fa-shield-halved"></i></div>
            <h1>Secure Your Student Account</h1>
            <p>Please enter a strong new password containing at least 6 characters to reset your password and login to your student portal.</p>
        </div>
    </div>
    <div class="right">
        <div class="form-card">
            <h2>Create New Password</h2>
            <p>Set a new password for your student account.</p>
            <form id="studentCreatePasswordForm">
                @csrf
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <div class="input-box">
                        <input type="password" id="new_password" name="new_password" placeholder="At least 6 characters" required>
                        <i class="fas fa-lock prefix-icon"></i>
                        <button type="button" class="toggle-pw" onclick="togglePw('new_password', this)"><i class="fas fa-eye"></i></button>
                    </div>
                    <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                    <small id="strengthText" style="font-size:0.75rem;color:#94a3b8;display:block;margin-top:4px;"></small>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <div class="input-box">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter new password" required>
                        <i class="fas fa-lock prefix-icon"></i>
                        <button type="button" class="toggle-pw" onclick="togglePw('confirm_password', this)"><i class="fas fa-eye"></i></button>
                    </div>
                    <small id="matchText" style="font-size:0.75rem;display:block;margin-top:4px;"></small>
                </div>
                <button type="submit" class="btn-submit" id="btnSubmit">
                    <i class="fas fa-check-circle me-2"></i> Update Password & Sign In
                </button>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('/assets') }}/vendor/libs/jquery/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    toastr.options = { closeButton: true, progressBar: true, positionClass: "toast-top-right", timeOut: 4000 };

    function togglePw(id, btn) {
        const inp = document.getElementById(id);
        const icon = btn.querySelector('i');
        if (inp.type === 'password') {
            inp.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            inp.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    document.getElementById('new_password').addEventListener('input', function() {
        const val = this.value;
        const fill = document.getElementById('strengthFill');
        const text = document.getElementById('strengthText');
        let score = 0;
        if (val.length >= 6) score++;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [
            { w: '0%', c: '#e2e8f0', t: '' },
            { w: '25%', c: '#ef4444', t: 'Weak' },
            { w: '50%', c: '#f59e0b', t: 'Fair' },
            { w: '75%', c: '#696cff', t: 'Good' },
            { w: '100%', c: '#10b981', t: 'Strong' }
        ];
        const idx = Math.min(score, 4);
        fill.style.width = levels[idx].w;
        fill.style.background = levels[idx].c;
        text.textContent = levels[idx].t;
        text.style.color = levels[idx].c;
    });

    document.getElementById('confirm_password').addEventListener('input', function() {
        const np = document.getElementById('new_password').value;
        const mt = document.getElementById('matchText');
        if (this.value && this.value === np) {
            mt.textContent = '✓ Passwords match';
            mt.style.color = '#10b981';
        } else if (this.value) {
            mt.textContent = '✕ Passwords do not match';
            mt.style.color = '#ef4444';
        } else {
            mt.textContent = '';
        }
    });

    document.getElementById('studentCreatePasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const np = $("#new_password").val();
        const cp = $("#confirm_password").val();
        const btn = document.getElementById('btnSubmit');

        if (!np || !cp) {
            toastr.error("Both password fields are required.");
            return;
        }
        if (np !== cp) {
            toastr.error("Passwords do not match.");
            return;
        }
        if (np.length < 6) {
            toastr.error("Password must be at least 6 characters long.");
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Updating...';

        $.ajax({
            url: "{{ route('studentresetpassword') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", new_password: np, confirm_password: cp },
            success: function(res) {
                if (res.status === "success") {
                    toastr.success(res.message || "Password updated successfully!");
                    setTimeout(function() { window.location.href = res.redirect_url; }, 1000);
                } else {
                    toastr.error(res.message || "Something went wrong.");
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Update Password & Sign In';
                }
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || "Something went wrong. Please try again.";
                toastr.error(msg);
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check-circle me-2"></i> Update Password & Sign In';
            }
        });
    });
</script>
</body>
</html>
