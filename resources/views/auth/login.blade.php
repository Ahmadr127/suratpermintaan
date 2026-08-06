<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/imagesicon.jpg') }}">
    <meta charset="UTF-8">
    <title>Login | Sistem Permintaan Layanan</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        *{
            box-sizing:border-box;
        }

        body{
            margin:0;
            font-family: 'Segoe UI', sans-serif;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-direction: column;
            background: linear-gradient(135deg, #00897b, #26a69a, #4db6ac);
            position: relative;
            overflow: hidden;
        }

        .bg-art {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
        }

        .login-wrapper{
            width:100%;
            max-width:950px;
            background:white;
            border-radius:22px;
            box-shadow:0 20px 50px rgba(0,0,0,0.25);
            overflow:hidden;
            display:flex;
            flex-direction: column;
        }

        .stripe-bar {
            display: flex;
            height: 6px;
            width: 100%;
            flex-shrink: 0;
        }

        .stripe-bar span {
            flex: 1;
        }

        .login-panels {
            display: flex;
            flex: 1;
        }

        /* LEFT PANEL */
        .login-left{
            background: linear-gradient(160deg,#006e6b,#009688);
            color:white;
            padding:50px;
            width:45%;
        }

        .logo-box{
            background: rgba(255,255,255,0.95);
            padding:14px 18px;
            border-radius:14px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            width:fit-content;
            box-shadow:0 6px 18px rgba(0,0,0,0.2);
            margin-bottom:28px;
        }

        .logo{
            height:55px;
            width:auto;
            object-fit:contain;
        }

        .login-left h3{
            font-weight:800;
            line-height:1.2;
            margin-bottom:12px;
        }

        .login-left p{
            font-size:15px;
            line-height:1.9;
            color:#ffffff;
        }

        /* RIGHT PANEL */
        .login-right{
            width:55%;
            padding:50px;
        }

        .login-title{
            font-size:24px;
            font-weight:800;
            color:#006e6b;
        }

        .login-subtitle{
            font-size:14px;
            color:#6b8f8a;
            margin-bottom:18px;
        }

        .form-group{
            margin-bottom:18px;
        }

        .input-group-text{
            background:#ffffff;
            border:1px solid #d1d5db;
            color:#6b7280;
        }

        .form-control{
            border:1px solid #d1d5db;
            background:#ffffff;
            padding:12px;
        }

        .form-control:focus{
            box-shadow:none;
            border-color:#006e6b;
            background:#ffffff;
        }

        .btn-login{
            background:#006e6b;
            border:none;
            color:white;
            padding:15px 12px;
            border-radius:10px;
            font-weight:600;
            transition:.3s;
            box-shadow:0 4px 12px rgba(0,110,107,0.35);
        }

        .btn-login:hover{
            background:#005854;
            transform:translateY(-2px);
            box-shadow:0 8px 20px rgba(0,110,107,0.45);
        }

        .login-footer{
            text-align:center;
            font-size:12px;
            color:#7a9a96;
            margin-top:22px;
        }

        @media(max-width:900px){
            .login-wrapper{
                flex-direction:column;
                max-width:420px;
            }
            .login-panels{
                flex-direction:column;
            }
            .login-left,.login-right{
                width:100%;
            }
        }
    </style>
</head>

<body>

<!-- Medical Art Background -->
<svg class="bg-art" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 900" preserveAspectRatio="xMidYMid slice">
    <!-- ECG line bawah kiri -->
    <polyline points="0,700 80,700 110,700 140,620 170,780 200,560 230,820 260,700 340,700 500,700 600,700" fill="none" stroke="rgba(255,255,255,0.35)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
    <!-- ECG line atas kanan -->
    <polyline points="700,180 780,180 810,180 840,110 870,250 900,70 930,280 960,180 1040,180 1200,180 1440,180" fill="none" stroke="rgba(255,255,255,0.25)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>

    <!-- Salib medis kiri atas besar -->
    <rect x="60" y="60" width="16" height="56" rx="4" fill="rgba(255,255,255,0.35)"/>
    <rect x="40" y="80" width="56" height="16" rx="4" fill="rgba(255,255,255,0.35)"/>

    <!-- Salib medis kanan atas -->
    <rect x="1320" y="80" width="20" height="70" rx="5" fill="rgba(255,255,255,0.30)"/>
    <rect x="1295" y="105" width="70" height="20" rx="5" fill="rgba(255,255,255,0.30)"/>

    <!-- Salib medis kiri bawah -->
    <rect x="80" y="760" width="14" height="50" rx="4" fill="rgba(255,255,255,0.28)"/>
    <rect x="62" y="778" width="50" height="14" rx="4" fill="rgba(255,255,255,0.28)"/>

    <!-- Salib medis kanan bawah -->
    <rect x="1350" y="750" width="12" height="44" rx="3" fill="rgba(255,255,255,0.30)"/>
    <rect x="1334" y="766" width="44" height="12" rx="3" fill="rgba(255,255,255,0.30)"/>

    <!-- Salib medis tengah atas -->
    <rect x="680" y="40" width="10" height="36" rx="3" fill="rgba(255,255,255,0.25)"/>
    <rect x="667" y="53" width="36" height="10" rx="3" fill="rgba(255,255,255,0.25)"/>

    <!-- Pil kanan atas -->
    <g transform="rotate(-35, 1280, 120)">
        <rect x="1248" y="108" width="64" height="24" rx="12" fill="none" stroke="rgba(255,255,255,0.38)" stroke-width="2.5"/>
        <line x1="1280" y1="108" x2="1280" y2="132" stroke="rgba(255,255,255,0.38)" stroke-width="2"/>
    </g>

    <!-- Pil kiri bawah -->
    <g transform="rotate(20, 200, 820)">
        <rect x="172" y="810" width="56" height="20" rx="10" fill="none" stroke="rgba(255,255,255,0.32)" stroke-width="2"/>
        <line x1="200" y1="810" x2="200" y2="830" stroke="rgba(255,255,255,0.32)" stroke-width="2"/>
    </g>

    <!-- Pil tengah kiri -->
    <g transform="rotate(10, 120, 400)">
        <rect x="96" y="390" width="48" height="18" rx="9" fill="none" stroke="rgba(255,255,255,0.28)" stroke-width="2"/>
        <line x1="120" y1="390" x2="120" y2="408" stroke="rgba(255,255,255,0.28)" stroke-width="2"/>
    </g>

    <!-- Hati / jantung kanan bawah -->
    <path d="M1380,650 C1380,635 1360,618 1360,600 C1360,584 1380,580 1380,594 C1380,580 1400,584 1400,600 C1400,618 1380,635 1380,650Z" fill="rgba(255,255,255,0.32)"/>

    <!-- Hati / jantung kiri tengah -->
    <path d="M100,480 C100,468 84,454 84,440 C84,427 100,424 100,435 C100,424 116,427 116,440 C116,454 100,468 100,480Z" fill="rgba(255,255,255,0.28)"/>

    <!-- Stethoscope kanan tengah -->
    <circle cx="1390" cy="400" r="22" fill="none" stroke="rgba(255,255,255,0.30)" stroke-width="2.5"/>
    <path d="M1375,400 Q1375,375 1390,375 Q1405,375 1405,400" fill="none" stroke="rgba(255,255,255,0.30)" stroke-width="2.5"/>
    <circle cx="1390" cy="375" r="4" fill="rgba(255,255,255,0.30)"/>

    <!-- DNA helix kiri -->
    <path d="M30,250 Q55,275 30,300 Q5,325 30,350 Q55,375 30,400 Q5,425 30,450" fill="none" stroke="rgba(255,255,255,0.28)" stroke-width="2"/>
    <path d="M50,250 Q25,275 50,300 Q75,325 50,350 Q25,375 50,400 Q75,425 50,450" fill="none" stroke="rgba(255,255,255,0.28)" stroke-width="2"/>
    <line x1="30" y1="275" x2="50" y2="275" stroke="rgba(255,255,255,0.20)" stroke-width="1.5"/>
    <line x1="30" y1="325" x2="50" y2="325" stroke="rgba(255,255,255,0.20)" stroke-width="1.5"/>
    <line x1="30" y1="375" x2="50" y2="375" stroke="rgba(255,255,255,0.20)" stroke-width="1.5"/>
    <line x1="30" y1="425" x2="50" y2="425" stroke="rgba(255,255,255,0.20)" stroke-width="1.5"/>

    <!-- Titik-titik dekoratif -->
    <circle cx="400" cy="80" r="5" fill="rgba(255,255,255,0.28)"/>
    <circle cx="900" cy="820" r="6" fill="rgba(255,255,255,0.25)"/>
    <circle cx="1100" cy="60" r="4" fill="rgba(255,255,255,0.25)"/>
    <circle cx="250" cy="860" r="5" fill="rgba(255,255,255,0.22)"/>
    <circle cx="1200" cy="500" r="4" fill="rgba(255,255,255,0.22)"/>
    <circle cx="600" cy="820" r="3" fill="rgba(255,255,255,0.25)"/>
</svg>

<div class="login-wrapper">

    <div class="stripe-bar">
        <span style="background:#f5d800;"></span>
        <span style="background:#7ecb35;"></span>
        <span style="background:#00897b;"></span>
    </div>

    <div class="login-panels">

    <!-- LEFT PANEL -->
    <div class="login-left d-flex flex-column justify-content-center">

        <div class="logo-box">
            <img src="/assets/logo.png" class="logo" alt="Logo">
        </div>

        <h3>Sistem Permintaan Layanan</h3>
        <p>
            Sistem Informasi Rekam Medis  
            untuk pengelolaan permintaan layanan pasien  
            secara cepat, aman, dan terintegrasi.
        </p>
    </div>

    <!-- RIGHT PANEL -->
    <div class="login-right">

        <div class="login-title">Login Akun</div>
        <div class="login-subtitle">Masuk ke sistem untuk melanjutkan</div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- USERNAME -->
            <div class="form-group">
                <label class="form-label fw-semibold">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" name="username" class="form-control" required placeholder="Masukkan username"
                           value="{{ old('username') }}">
                </div>
                @error('username')
                    <div class="text-danger mt-1" style="font-size:13px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div class="form-group">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" id="passwordInput" class="form-control" required>
                    <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword()">
                        <i class="bi bi-eye-fill" id="toggleIcon"></i>
                    </span>
                </div>
            </div>

            <!-- BUTTON -->
            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>
            </div>

            <div class="login-footer">
                © 2026 Sistem Informasi Rekam Medis
            </div>
        </form>

    </div> {{-- login-right --}}

    </div> {{-- login-panels --}}

</div> {{-- login-wrapper --}}

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('toggleIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
    }
}
</script>
</body>
</html>