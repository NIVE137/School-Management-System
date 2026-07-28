<!doctype html>
<html lang="en" class="layout-wide customizer-hide" dir="ltr" data-bs-theme="light">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Forgot Password — Education Management System</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/eeschool.png') }}">
    <link rel="stylesheet" href="{{ asset('/assets') }}/vendor/css/core.css">
    <link rel="stylesheet" href="{{ asset('/assets') }}/css/demo.css">
    <link rel="stylesheet" href="{{ asset('/assets') }}/vendor/css/pages/page-auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/school-theme.css') }}">
    <style>
        *{box-sizing:border-box;}body{font-family:'Inter',sans-serif;}
        .auth-full-wrap{display:flex;min-height:100vh;}
        .auth-left-panel{flex:0 0 55%;position:relative;overflow:hidden;background:linear-gradient(145deg,#0f172a 0%,#1e1e6e 50%,#0c3a5e 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:60px 50px;}
        .b{position:absolute;border-radius:50%;background:rgba(255,255,255,0.05);animation:bubbleFloat 8s ease-in-out infinite;}
        .b1{width:320px;height:320px;top:-90px;right:-90px;}
        .b2{width:200px;height:200px;bottom:50px;left:-60px;animation-delay:3s;}
        @keyframes bubbleFloat{0%,100%{transform:translateY(0);}50%{transform:translateY(-20px);}}
        .text-z{position:relative;z-index:2;text-align:center;color:#fff;}
        .icon-box{width:72px;height:72px;background:rgba(255,255,255,0.12);border-radius:18px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;border:1px solid rgba(255,255,255,0.15);}
        .icon-box i{font-size:2rem;color:#fff;}
        .text-z h2{font-size:1.8rem;font-weight:800;letter-spacing:-.4px;}
        .text-z p{color:rgba(255,255,255,0.55);font-size:0.88rem;margin-top:8px;max-width:340px;}
        .illus{position:relative;z-index:2;margin-top:36px;}
        .illus img{max-width:380px;width:100%;filter:drop-shadow(0 18px 36px rgba(0,0,0,0.28));}
        .auth-right-panel{flex:0 0 45%;background:#fff;display:flex;align-items:center;justify-content:center;padding:60px 50px;}
        .form-box{width:100%;max-width:360px;}
        .back-link{display:inline-flex;align-items:center;gap:7px;font-size:0.8rem;color:#566a7f;text-decoration:none;font-weight:500;margin-bottom:26px;}
        .back-link:hover{color:#696cff;}
        .fg{margin-bottom:18px;}
        .fg label{display:block;font-size:0.79rem;font-weight:600;color:#566a7f;margin-bottom:6px;}
        .input-wrap{position:relative;}
        .input-wrap .ic{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#a5b7c8;font-size:0.88rem;}
        .input-wrap input{width:100%;padding:10px 14px 10px 38px;border:1.5px solid #d9dee3;border-radius:9px;font-size:0.88rem;font-family:'Inter',sans-serif;color:#32475c;transition:border-color .2s,box-shadow .2s;}
        .input-wrap input:focus{outline:none;border-color:#696cff;box-shadow:0 0 0 3px rgba(105,108,255,0.14);}
        .input-wrap input::placeholder{color:#c8d0d8;}
        .btn-submit{width:100%;padding:12px;background:linear-gradient(135deg,#696cff,#03c3ec);color:#fff;border:none;border-radius:9px;font-size:0.93rem;font-weight:700;font-family:'Inter',sans-serif;cursor:pointer;transition:all .2s;}
        .btn-submit:hover{box-shadow:0 6px 22px rgba(105,108,255,0.38);transform:translateY(-1px);}
        .btn-submit:disabled{opacity:.7;cursor:not-allowed;transform:none;}
        @media(max-width:768px){.auth-left-panel{display:none;}.auth-right-panel{flex:1;padding:40px 24px;}}
    </style>
</head>
<body>
<div class="auth-full-wrap">
    <div class="auth-left-panel">
        <div class="b b1"></div><div class="b b2"></div>
        <div class="text-z">
            <div class="icon-box"><i class="fas fa-key"></i></div>
            <h2>Reset Your Password</h2>
            <p>Enter your registered email and we'll help you reset your password.</p>
        </div>
        <div class="illus"><img src="{{ asset('assets/school 1.png') }}" alt=""></div>
    </div>
    <div class="auth-right-panel">
        <div class="form-box">
            <a href="{{ route('login') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Login</a>
            <h2 style="font-size:1.5rem;font-weight:800;color:#32475c;letter-spacing:-.4px;margin-bottom:4px;">Forgot Password?</h2>
            <p style="font-size:0.85rem;color:#a5b7c8;margin-bottom:28px;">Enter your email address to verify your account.</p>
            <form id="forgetPasswordForm">
                @csrf
                <div class="fg">
                    <label>Email Address</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope ic"></i>
                        <input type="email" id="fp_email" placeholder="admin@school.com" required>
                    </div>
                </div>
                <button type="submit" class="btn-submit"><i class="fas fa-paper-plane me-2"></i> Continue</button>
            </form>
        </div>
    </div>
</div>

<div class="position-fixed top-0 end-0 p-3" style="z-index:9999;">
    <div id="customToast" class="toast text-white border-0"><div class="d-flex"><div class="toast-body" id="customToastBody"></div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>
</div>

<script src="{{ asset('/assets') }}/vendor/libs/jquery/jquery.js"></script>
<script src="{{ asset('/assets') }}/vendor/libs/popper/popper.js"></script>
<script src="{{ asset('/assets') }}/vendor/js/bootstrap.js"></script>
<script>
    function showToast(msg,type='success'){
        const el=document.getElementById('customToast'),b=document.getElementById('customToastBody');
        b.innerText=msg; el.classList.remove('bg-success','bg-danger');
        el.classList.add(type==='success'?'bg-success':'bg-danger');
        new bootstrap.Toast(el,{delay:3500}).show();
    }
    document.getElementById('forgetPasswordForm').addEventListener('submit',function(e){
        e.preventDefault();
        const btn=this.querySelector('button[type=submit]');
        btn.disabled=true; btn.innerHTML='<i class="fas fa-spinner fa-spin me-2"></i> Verifying...';
        $.ajax({
            url:"{{ route('checkemail') }}",type:"POST",
            data:{_token:"{{ csrf_token() }}",email:$("#fp_email").val()},
            success:function(res){
                if(res.status==="success"){showToast("Verified! Redirecting...","success");setTimeout(()=>window.location.href=res.redirect_url,900);}
                else{showToast(res.message||"Email not found.","error");btn.disabled=false;btn.innerHTML='<i class="fas fa-paper-plane me-2"></i> Continue';}
            },
            error:function(){showToast("Something went wrong.","error");btn.disabled=false;btn.innerHTML='<i class="fas fa-paper-plane me-2"></i> Continue';}
        });
    });
</script>
</body>
</html>
