<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/imagesicon.jpg') }}">
    <meta charset="UTF-8">
    <title>Tambah Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        .select2-container--default .select2-selection--single {
            border-radius: 10px;
            border: 1.5px solid #d0e8e7;
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 14px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            color: #333;
            padding-left: 0;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
        }
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #005654;
            box-shadow: 0 0 0 3px rgba(0,86,84,0.1);
            outline: none;
        }
        .select2-dropdown {
            border: 1.5px solid #d0e8e7;
            border-radius: 10px;
            font-size: 14px;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1.5px solid #d0e8e7;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 14px;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: #005654;
            outline: none;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #005654;
        }
        .select2-container { width: 100% !important; }
    </style>
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #e6f7f6, #f4fbfa); min-height: 100vh; display: flex; margin: 0; overflow-x: hidden; }

        /* ── SIDEBAR ── */
        .sidebar { width: 240px; min-height: 100vh; flex-shrink: 0; background: #005654; display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100; }
        .sidebar-brand { padding: 20px 20px 16px; border-bottom: 1px solid rgba(255,255,255,.1); display: flex; align-items: center; gap: 10px; }
        .sidebar-brand img { height: 38px; width: auto; filter: brightness(0) invert(1); }
        .sidebar-brand-text .title { font-size: 13px; font-weight: 800; color: #fff; line-height: 1.2; }
        .sidebar-brand-text .sub { font-size: 10px; color: rgba(255,255,255,.6); }
        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .sidebar-label { font-size: 10px; font-weight: 700; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: .8px; padding: 0 8px; margin-bottom: 6px; margin-top: 12px; }
        .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; color: rgba(255,255,255,.75); font-size: 13.5px; font-weight: 500; text-decoration: none; transition: all .2s; margin-bottom: 2px; }
        .sidebar-link i { font-size: 16px; flex-shrink: 0; }
        .sidebar-link:hover { background: rgba(255,255,255,.12); color: #fff; }
        .sidebar-link.active-page { background: #81BD41; color: #fff; font-weight: 700; }
        .sidebar-footer { padding: 16px 12px; border-top: 1px solid rgba(255,255,255,.1); }
        .sidebar-user { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; background: rgba(255,255,255,.08); margin-bottom: 8px; }
        .sidebar-user i { font-size: 20px; color: rgba(255,255,255,.8); }
        .sidebar-user .name { font-size: 13px; font-weight: 600; color: #fff; }
        .sidebar-user .role { font-size: 11px; color: rgba(255,255,255,.5); }
        .btn-logout-sidebar { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 9px; border-radius: 10px; background: #7a2020; color: #ffffff; border: 1px solid #a03030; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; }
        .btn-logout-sidebar:hover { background: #9b2828; color: #ffffff; }
        .sidebar-dropdown-toggle { background: none; border: none; text-align: left; width: 100%; }
        .sidebar-chevron { transition: transform .25s; font-size: 12px; }
        .sidebar-dropdown.open .sidebar-chevron { transform: rotate(180deg); }
        .sidebar-submenu { overflow: hidden; max-height: 0; transition: max-height .3s ease; }
        .sidebar-dropdown.open .sidebar-submenu { max-height: 200px; }
        .sidebar-sublink { display: flex; align-items: center; gap: 8px; padding: 8px 12px 8px 32px; border-radius: 8px; color: rgba(255,255,255,.65); font-size: 13px; font-weight: 500; text-decoration: none; transition: all .2s; margin-bottom: 1px; }
        .sidebar-sublink i { font-size: 14px; flex-shrink: 0; }
        .sidebar-sublink:hover { background: rgba(255,255,255,.1); color: #fff; }
        .sidebar-sublink.active { background: #6aaa30; color: #fff; font-weight: 600; }

        /* ── MAIN ── */
        .main-wrapper { margin-left: 240px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; overflow-x: hidden; min-width: 0; }
        .topbar { background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.06); padding: 14px 28px; }
        .topbar-title { font-size: 18px; font-weight: 800; color: #005654; }
        .topbar-sub { font-size: 12px; color: #6b8f8a; }

        .card-form { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); padding: 32px; max-width: 520px; }
        .form-label { font-weight: 600; font-size: 14px; color: #333; }
        .form-control, .form-select { border-radius: 10px; border: 1.5px solid #d0e8e7; font-size: 14px; }
        .form-control:focus, .form-select:focus { border-color: #005654; box-shadow: 0 0 0 3px rgba(0,86,84,0.1); }
        .btn-submit { background: #005654; color: white; border: none; border-radius: 10px; padding: 10px 24px; font-weight: 600; font-size: 14px; transition: background 0.2s; }
        .btn-submit:hover { background: #007a77; color: white; }
        .btn-back { border-radius: 10px; font-size: 14px; }
        .section-divider { border-top: 1.5px dashed #d0e8e7; margin: 20px 0; }
        .info-badge { background: #e6f7f6; color: #005654; border-radius: 8px; padding: 8px 12px; font-size: 13px; margin-bottom: 16px; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo">
        <div class="sidebar-brand-text">
            <div class="title">Rekam Medis</div>
            <div class="sub">Sistem Informasi</div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="sidebar-label">Menu</div>
        <a href="{{ route('permintaan.index') }}" class="sidebar-link">
            <i class="bi bi-list-ul"></i> Permintaan
        </a>
        @if(auth()->user()->role === 'admin')
        <div class="sidebar-dropdown">
            <button class="sidebar-link sidebar-dropdown-toggle w-100" onclick="toggleSidebarDropdown(this)">
                <i class="bi bi-gear-fill"></i>
                <span>Master</span>
                <i class="bi bi-chevron-down sidebar-chevron ms-auto"></i>
            </button>
            <div class="sidebar-submenu">
                <a href="{{ route('master.kategori.index') }}" class="sidebar-sublink">
                    <i class="bi bi-tags-fill"></i> Kategori
                </a>
                <a href="{{ route('master.layanan.index') }}" class="sidebar-sublink">
                    <i class="bi bi-file-earmark-text-fill"></i> Layanan
                </a>
            </div>
        </div>
        @endif
        @if(auth()->user()->role === 'admin')
        <div class="sidebar-dropdown open">
            <button class="sidebar-link sidebar-dropdown-toggle active-page w-100" onclick="toggleSidebarDropdown(this)">
                <i class="bi bi-people-fill"></i>
                <span>Akun</span>
                <i class="bi bi-chevron-down sidebar-chevron ms-auto"></i>
            </button>
            <div class="sidebar-submenu">
                <a href="{{ route('master.user.index') }}?tab=user" class="sidebar-sublink active">
                    <i class="bi bi-person-fill"></i> Manajemen User
                </a>
                <a href="{{ route('master.user.index') }}?tab=role" class="sidebar-sublink">
                    <i class="bi bi-shield-fill"></i> Manajemen Role
                </a>
                <a href="{{ route('master.user.index') }}?tab=karyawan" class="sidebar-sublink">
                    <i class="bi bi-person-badge-fill"></i> Data Karyawan
                </a>
            </div>
        </div>
        @endif
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <i class="bi bi-person-circle"></i>
            <div>
                <div class="name">{{ auth()->user()->name }}</div>
                <div class="role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
        <form method="POST" action="{{ url('/logout') }}" class="m-0">
            @csrf
            <button type="submit" class="btn-logout-sidebar">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
        </form>
    </div>
</aside>

<!-- MAIN WRAPPER -->
<div class="main-wrapper">
    <div class="topbar">
        <div class="topbar-title">Tambah Akun</div>
        <div class="topbar-sub">Sistem Informasi Rekam Medis</div>
    </div>

    <div class="container-fluid px-4 px-md-5 py-4">
<div class="card-form">
    <h5 class="fw-bold mb-4" style="color:#005654;">Form Tambah Akun</h5>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('master.user.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Pilih Karyawan <span class="text-danger">*</span></label>
            <select id="employee_select" name="employee_id" class="form-select" required>
                <option value="">-- Pilih Karyawan --</option>
                @foreach($employees as $emp)
                    <option value="{{ $emp->id }}"
                        data-nama="{{ $emp->nama_karyawan }}"
                        data-jabatan="{{ $emp->jabatan }}"
                        data-unit="{{ $emp->unit }}"
                        {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                        {{ $emp->nama_karyawan }} &mdash; {{ $emp->posisi_pekerjaan ?? $emp->jabatan ?? '-' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="section-divider"></div>

        <div id="account-fields">
            <div class="info-badge">
                <i class="bi bi-info-circle me-1"></i>
                Username dibuat otomatis dari nama depan dan nama belakang karyawan. Role ditentukan otomatis dari jabatan &amp; unit.
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <label class="form-label">Nama Depan</label>
                    <input type="text" id="nama_depan" name="nama_depan" class="form-control"
                           value="{{ old('nama_depan') }}" required placeholder="Nama depan">
                </div>
                <div class="col-6">
                    <label class="form-label">Nama Belakang</label>
                    <input type="text" id="nama_belakang" name="nama_belakang" class="form-control"
                           value="{{ old('nama_belakang') }}" placeholder="Nama belakang">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Username (otomatis)</label>
                <input type="text" id="username_preview" name="username" class="form-control"
                       value="{{ old('username') }}" readonly
                       style="background:#f4fbfa; color:#005654; font-weight:600;">
                <div class="form-text">Format: namadepan.namabelakang (huruf kecil, tanpa spasi)</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" id="name_full" name="name" class="form-control"
                       value="{{ old('name') }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Role (otomatis)</label>
                <div id="role_preview" style="background:#f4fbfa; border:1.5px solid #d0e8e7; border-radius:10px; padding:10px 14px; font-size:13.5px; color:#005654; font-weight:600;">
                    <i class="bi bi-shield-fill me-1" style="color:#81BD41;"></i>
                    <span id="role_label_text">Pilih karyawan terlebih dahulu</span>
                </div>
                <div class="form-text">Jabatan di bawah koordinator → User. Koordinator ke atas → role sesuai unit.</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn-submit">Simpan</button>
                <a href="{{ route('master.user.index') }}" class="btn btn-outline-secondary btn-back">Batal</a>
            </div>
        </div>



    </form>
</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#employee_select').select2({
            placeholder: '-- Pilih Karyawan --',
            allowClear: true,
            language: {
                noResults: function () { return 'Karyawan tidak ditemukan'; },
                searching: function () { return 'Mencari...'; }
            }
        });

        $('#employee_select').on('change', function () {
            const selectedOption = $('#employee_select').find(':selected');
            if (this.value) {
                const namaLengkap = selectedOption.data('nama') || '';
                const jabatan     = selectedOption.data('jabatan') || '';
                const unit        = selectedOption.data('unit') || '';
                const { depan, belakang } = pisahkanNama(namaLengkap);

                namaDepanInput.value    = depan;
                namaBelakangInput.value = belakang;
                nameFullInput.value     = namaLengkap;
                generateUsername();
                updateRolePreview(jabatan, unit);

                accountFields.style.display = '';
            } else {
                accountFields.style.display = 'none';
            }
        });
    });

    const employeeSelect    = document.getElementById('employee_select');
    const accountFields     = document.getElementById('account-fields');
    const namaDepanInput    = document.getElementById('nama_depan');
    const namaBelakangInput = document.getElementById('nama_belakang');
    const usernamePreview   = document.getElementById('username_preview');
    const nameFullInput     = document.getElementById('name_full');

    // Map role unit dari server
    const unitRoleMap = @json($roles->pluck('label', 'name'));
    const JABATAN_BAWAH = ['STAFF', 'PENANGGUNG JAWAB', 'DOKTER SPESIALIS'];

    function updateRolePreview(jabatan, unit) {
        const el = document.getElementById('role_label_text');
        if (!el) return;
        if (JABATAN_BAWAH.includes(jabatan.toUpperCase().trim())) {
            el.textContent = unitRoleMap['user'] || 'User';
            return;
        }
        const slug = 'unit_' + unit.toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/^_|_$/g, '');
        el.textContent = unitRoleMap[slug] || ('Unit ' + unit);
    }

    // Gelar depan (prefix) — kata yang diakhiri titik dan merupakan gelar
    const GELAR_DEPAN_LIST = ['dr', 'drg', 'drs', 'dra', 'prof', 'ir', 'ns', 'apt', 'ners', 'kh', 'hj', 'h'];

    // Gelar belakang (suffix) — kata yang mengandung titik di tengah atau merupakan singkatan gelar
    const GELAR_BELAKANG_LIST = [
        's.kep', 's.farm', 's.gz', 's.ked', 's.si', 's.km', 's.kl', 's.pd', 's.t', 's.e',
        's.h', 's.sos', 's.kom', 's.ip', 's.psi', 's.sn', 's.hut', 's.p',
        'm.kes', 'm.kep', 'm.farm', 'm.si', 'm.pd', 'm.m', 'm.t', 'm.h', 'm.sc', 'm.kom',
        'ph.d', 'dr', 'drg',
        'sp.a', 'sp.b', 'sp.og', 'sp.pd', 'sp.rad', 'sp.an', 'sp.jp', 'sp.s', 'sp.m',
        'sp.kk', 'sp.p', 'sp.u', 'sp.tht', 'sp.gk', 'sp.mk', 'sp.kj', 'sp.f', 'sp.n',
        'sp.pa', 'sp.pk', 'sp.paru', 'sp.em', 'sp.ba', 'sp.bs', 'sp.bo', 'sp.btkv',
        'ns', 'apt', 'ners',
        'amd', 'amk', 'amg', 'amf', 'amd.kep', 'amd.gz', 'amd.farm', 'amd.kes',
        'skm', 'skep', 'sst', 'ssi', 's.kep.ns', 'm.kes.ns',
    ];

    function isGelarDepan(kata) {
        const k = kata.toLowerCase().replace(/\.$/, '');
        return GELAR_DEPAN_LIST.includes(k);
    }

    function isGelarBelakang(kata) {
        // Hapus titik di akhir lalu bandingkan lowercase
        const k = kata.toLowerCase().replace(/\.$/, '');
        return GELAR_BELAKANG_LIST.includes(k);
    }

    function pisahkanNama(namaLengkap) {
        // Buang semua setelah koma pertama (gelar)
        const tanpaGelar = namaLengkap.indexOf(',') !== -1
            ? namaLengkap.substring(0, namaLengkap.indexOf(',')).trim()
            : namaLengkap.trim();

        // Split per spasi, ambil kata-kata bersih
        const kata = tanpaGelar.split(/\s+/).filter(k => k.length > 0);

        // Buang gelar depan
        let i = 0;
        while (i < kata.length && isGelarDepan(kata[i])) i++;
        const kataNama = kata.slice(i);

        console.log('tanpaGelar:', tanpaGelar, '| kataNama:', kataNama);

        const depan    = kataNama[0] || '';
        const belakang = kataNama[1] || '';   // hanya kata kedua
        return { depan, belakang };
    }

    function generateUsername() {
        // Ambil hanya kata pertama dari nama depan dan nama belakang
        const depan    = (namaDepanInput.value.trim().split(/\s+/)[0] || '').toLowerCase();
        const belakang = (namaBelakangInput.value.trim().split(/\s+/)[0] || '').toLowerCase();
        usernamePreview.value = belakang ? depan + '.' + belakang : depan;
    }

    function updateFullName() {
        const depan    = namaDepanInput.value.trim();
        const belakang = namaBelakangInput.value.trim();
        nameFullInput.value = belakang ? depan + ' ' + belakang : depan;
    }



    namaDepanInput.addEventListener('input', function () {
        generateUsername();
        updateFullName();
    });

    namaBelakangInput.addEventListener('input', function () {
        generateUsername();
        updateFullName();
    });

    function toggleSidebarDropdown(btn) {
        btn.closest('.sidebar-dropdown').classList.toggle('open');
    }
</script>
</body>
</html>
