<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/imagesicon.jpg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Akun & Role</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #e6f7f6, #f4fbfa); min-height: 100vh; display: flex; margin: 0; overflow-x: hidden; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 240px; min-height: 100vh; flex-shrink: 0;
            background: #005654; display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0; z-index: 100;
        }
        .sidebar-brand { padding: 20px 20px 16px; border-bottom: 1px solid rgba(255,255,255,.1); display: flex; align-items: center; gap: 10px; }
        .sidebar-brand img { height: 38px; width: auto; filter: brightness(0) invert(1); }
        .sidebar-brand-text .title { font-size: 13px; font-weight: 800; color: #fff; line-height: 1.2; }
        .sidebar-brand-text .sub { font-size: 10px; color: rgba(255,255,255,.6); }
        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .sidebar-label { font-size: 10px; font-weight: 700; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: .8px; padding: 0 8px; margin-bottom: 6px; margin-top: 12px; }
        .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; color: rgba(255,255,255,.75); font-size: 13.5px; font-weight: 500; text-decoration: none; transition: all .2s; margin-bottom: 2px; }
        .sidebar-link i { font-size: 16px; flex-shrink: 0; }
        .sidebar-link:hover { background: rgba(255,255,255,.12); color: #fff; }
        .sidebar-link.active { background: rgba(255,255,255,.18); color: #fff; font-weight: 700; }
        .sidebar-link.active-page { background: #81BD41; color: #fff; font-weight: 700; }
        .sidebar-footer { padding: 16px 12px; border-top: 1px solid rgba(255,255,255,.1); }
        .sidebar-user { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; background: rgba(255,255,255,.08); margin-bottom: 8px; }
        .sidebar-user i { font-size: 20px; color: rgba(255,255,255,.8); }
        .sidebar-user .name { font-size: 13px; font-weight: 600; color: #fff; }
        .sidebar-user .role { font-size: 11px; color: rgba(255,255,255,.5); }
        .btn-logout-sidebar { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 9px; border-radius: 10px; background: #7a2020; color: #ffffff; border: 1px solid #a03030; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; }
        .btn-logout-sidebar:hover { background: #9b2828; color: #ffffff; }

        /* ── SIDEBAR DROPDOWN ── */
        .sidebar-dropdown-toggle { background: none; border: none; text-align: left; width: 100%; }
        .sidebar-chevron { transition: transform .25s; font-size: 12px; }
        .sidebar-dropdown.open .sidebar-chevron { transform: rotate(180deg); }
        .sidebar-submenu { overflow: hidden; max-height: 0; transition: max-height .3s ease; }
        .sidebar-dropdown.open .sidebar-submenu { max-height: 200px; }
        .sidebar-sublink {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 12px 8px 32px; border-radius: 8px;
            color: rgba(255,255,255,.65); font-size: 13px; font-weight: 500;
            text-decoration: none; transition: all .2s; margin-bottom: 1px;
        }
        .sidebar-sublink i { font-size: 14px; flex-shrink: 0; }
        .sidebar-sublink:hover { background: rgba(255,255,255,.1); color: #fff; }
        .sidebar-sublink.active { background: #6aaa30; color: #fff; font-weight: 600; }

        /* ── MAIN ── */
        .main-wrapper { margin-left: 240px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; overflow-x: hidden; min-width: 0; }
        .topbar { background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.06); padding: 14px 28px; }
        .topbar-title { font-size: 18px; font-weight: 800; color: #005654; }
        .topbar-sub { font-size: 12px; color: #6b8f8a; }

        /* ── TABS ── */
        .tab-nav { display: flex; gap: 4px; background: #fff; border-radius: 14px; padding: 6px; box-shadow: 0 2px 12px rgba(0,0,0,.05); width: fit-content; }
        .tab-btn { display: flex; align-items: center; gap: 8px; padding: 9px 20px; border-radius: 10px; font-size: 13.5px; font-weight: 600; border: none; background: transparent; color: #6b8f8a; cursor: pointer; transition: all .2s; }
        .tab-btn:hover { background: #f0f9f8; color: #005654; }
        .tab-btn.active { background: #005654; color: #fff; }
        .tab-btn .count { display: inline-flex; align-items: center; justify-content: center; min-width: 20px; height: 20px; border-radius: 999px; font-size: 11px; font-weight: 700; padding: 0 5px; }
        .tab-btn.active .count { background: rgba(255,255,255,.25); color: #fff; }
        .tab-btn:not(.active) .count { background: #e0f0ef; color: #005654; }

        /* ── TABLE CARD ── */
        .table-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.06); }
        .table-card .table-responsive { overflow-x: auto; overflow-y: auto; max-height: 60vh; border-radius: 16px; }
        #tab-karyawan .table-card .table-responsive { max-height: 75vh; }
        .table thead th { position: sticky; top: 0; z-index: 2; }
        .table { margin-bottom: 0; }
        .table thead th { background: #005654; color: #fff; font-size: 11.5px; font-weight: 600; letter-spacing: .4px; text-transform: uppercase; padding: 13px 18px; border: none; white-space: nowrap; }
        .table tbody td { padding: 13px 18px; vertical-align: middle; border-bottom: 1px solid #f3f3f3; font-size: 13.5px; color: #2d2d2d; }
        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover { background: #f7fdfc; }

        /* ── BADGE ROLE ── */
        .badge-role { display: inline-block; padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; }

        /* ── BUTTONS ── */
        .btn-primary-custom { display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; background: #005654; color: #fff; font-size: 13.5px; font-weight: 600; border-radius: 10px; border: none; text-decoration: none; transition: all .2s; cursor: pointer; }
        .btn-primary-custom:hover { background: #007a77; color: #fff; transform: translateY(-1px); }
        .btn-icon { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; border: none; background: transparent; transition: all .2s; font-size: 15px; text-decoration: none; cursor: pointer; }
        .btn-icon-edit { color: #b8860b; }
        .btn-icon-edit:hover { background: #fff3cd; color: #856404; transform: translateY(-1px); }
        .btn-icon-delete { color: #c0392b; }
        .btn-icon-delete:hover { background: #fde8e8; color: #922b21; transform: translateY(-1px); }

        /* ── SEARCH ── */
        .filter-bar { background: #fff; border-radius: 14px; padding: 16px 20px; box-shadow: 0 2px 12px rgba(0,0,0,.05); }
        .search-wrap { position: relative; }
        .search-wrap .bi-search { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 14px; pointer-events: none; }
        .search-wrap input { padding-left: 36px; border-radius: 10px; border: 1.5px solid #d0e8e7; height: 38px; font-size: 13.5px; width: 240px; transition: border-color .2s; }
        .search-wrap input:focus { border-color: #005654; box-shadow: 0 0 0 3px rgba(0,86,84,.1); outline: none; }
        .btn-search { display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; background: #005654; color: #fff; font-size: 13.5px; font-weight: 600; border-radius: 10px; border: none; cursor: pointer; transition: background .2s, transform .15s; }
        .btn-search:hover { background: #007a77; transform: translateY(-1px); }
        .btn-reset { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 10px; font-size: 13.5px; font-weight: 500; border: 1.5px solid #d0d0d0; color: #666; background: #fff; text-decoration: none; transition: all .2s; }
        .btn-reset:hover { border-color: #005654; color: #005654; background: #f0f9f8; }
        .btn-tambah { display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; background: #005654; color: #fff; font-size: 13.5px; font-weight: 600; border-radius: 10px; border: none; text-decoration: none; transition: background .2s, transform .15s; cursor: pointer; }
        .btn-tambah:hover { background: #007a77; color: #fff; transform: translateY(-1px); }

        /* ── COLOR SWATCH ── */
        .color-swatch { width: 14px; height: 14px; border-radius: 50%; display: inline-block; flex-shrink: 0; border: 1px solid rgba(0,0,0,.1); }

        /* ── MODAL ── */
        .modal-content { border-radius: 16px; border: none; }
        .modal-header { border-bottom: 1px solid #f0f0f0; padding: 20px 24px; }
        .modal-body { padding: 24px; }
        .modal-footer { border-top: 1px solid #f0f0f0; padding: 16px 24px; }
        .form-label { font-weight: 600; font-size: 13.5px; color: #333; }
        .form-control, .form-select { border-radius: 10px; border: 1.5px solid #d0e8e7; font-size: 13.5px; }
        .form-control:focus, .form-select:focus { border-color: #005654; box-shadow: 0 0 0 3px rgba(0,86,84,.1); }

        /* ── EMPTY STATE ── */
        .empty-state { padding: 60px 20px; text-align: center; color: #aaa; }
        .empty-state i { font-size: 48px; margin-bottom: 12px; display: block; color: #c8e6e5; }

        /* ── FILTER SELECT ── */
        .filter-select {
            border-radius: 10px; border: 1.5px solid #d0e8e7;
            height: 38px; font-size: 13.5px; padding: 0 12px;
            background: #fff; color: #333;
            transition: border-color .2s, box-shadow .2s; appearance: auto;
        }
        .filter-select:focus { border-color: #005654; box-shadow: 0 0 0 3px rgba(0,86,84,.1); outline: none; }
        .empty-state p { font-size: 14px; margin: 0; }

        /* Select2 di filter bar */
        .filter-bar .select2-container--default .select2-selection--single {
            border-radius: 10px; border: 1.5px solid #d0e8e7;
            height: 38px; padding: 4px 10px; font-size: 13.5px;
        }
        .filter-bar .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 28px; color: #333; padding-left: 0; }
        .filter-bar .select2-container--default .select2-selection--single .select2-selection__arrow { height: 36px; }
        .filter-bar .select2-container--default.select2-container--focus .select2-selection--single,
        .filter-bar .select2-container--default.select2-container--open .select2-selection--single { border-color: #005654; box-shadow: 0 0 0 3px rgba(0,86,84,.1); outline: none; }
        .filter-bar .select2-dropdown { border: 1.5px solid #d0e8e7; border-radius: 10px; font-size: 13.5px; }
        .filter-bar .select2-container--default .select2-search--dropdown .select2-search__field { border: 1.5px solid #d0e8e7; border-radius: 8px; padding: 5px 10px; font-size: 13px; }
        .filter-bar .select2-container--default .select2-results__option--highlighted[aria-selected] { background: #005654; }
        .filter-bar .select2-container--default .select2-selection--single .select2-selection__clear { margin-right: 20px; color: #aaa; font-size: 16px; }
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
        <div class="sidebar-dropdown open">
            <button class="sidebar-link sidebar-dropdown-toggle active w-100" onclick="toggleSidebarDropdown(this)">
                <i class="bi bi-people-fill"></i>
                <span>Akun</span>
                <i class="bi bi-chevron-down sidebar-chevron ms-auto"></i>
            </button>
            <div class="sidebar-submenu">
                <a href="{{ route('master.user.index') }}?tab=user" class="sidebar-sublink {{ $tab === 'user' ? 'active' : '' }}">
                    <i class="bi bi-person-fill"></i> Manajemen User
                </a>
                <a href="{{ route('master.user.index') }}?tab=role" class="sidebar-sublink {{ $tab === 'role' ? 'active' : '' }}">
                    <i class="bi bi-shield-fill"></i> Manajemen Role
                </a>
                <a href="{{ route('master.user.index') }}?tab=karyawan" class="sidebar-sublink {{ $tab === 'karyawan' ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill"></i> Data Karyawan
                </a>
            </div>
        </div>
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
        <div class="topbar-title">Master Akun & Role</div>
        <div class="topbar-sub">Sistem Informasi Rekam Medis</div>
    </div>

    <div class="container-fluid px-4 px-md-5 py-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" style="border-radius:12px;" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" style="border-radius:12px;" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- ══════════════════════════════════════ -->
        <!-- TAB: MANAJEMEN USER                    -->
        <!-- ══════════════════════════════════════ -->
        <div id="tab-user" class="{{ $tab !== 'user' ? 'd-none' : '' }}">
            @php
                $userByName      = $users->keyBy(fn($u) => strtolower($u->name));
                $searchUser      = request('search');
                $filterUserUnit  = request('filter_user_unit');
                $filterUserPosisi = request('filter_user_posisi');

                $empFiltered = $employees;
                if ($searchUser) {
                    $s = strtolower($searchUser);
                    $empFiltered = $empFiltered->filter(fn($e) => str_contains(strtolower($e->nama_karyawan), $s));
                }
                if ($filterUserUnit) {
                    $empFiltered = $empFiltered->filter(fn($e) => $e->unit === $filterUserUnit);
                }
                if ($filterUserPosisi) {
                    $empFiltered = $empFiltered->filter(fn($e) => $e->posisi_pekerjaan === $filterUserPosisi);
                }

                $empDenganAkun = $empFiltered->filter(fn($e) => isset($userByName[strtolower($e->nama_karyawan)]));
                $empTanpaAkun  = $empFiltered->filter(fn($e) => !isset($userByName[strtolower($e->nama_karyawan)]));
            @endphp

            <!-- Filter -->
            <div class="filter-bar mb-3">
                <form method="GET" action="{{ route('master.user.index') }}"
                      class="d-flex align-items-center gap-2 flex-wrap w-100">
                    <input type="hidden" name="tab" value="user">
                    <div class="search-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" value="{{ $searchUser }}" placeholder="Cari nama karyawan...">
                    </div>
                    <select id="sel_user_unit" name="filter_user_unit" class="filter-select" style="width:160px;">
                        <option value="">Semua Unit</option>
                        @foreach($filterUnits as $val)
                            <option value="{{ $val }}" {{ $filterUserUnit == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    <select id="sel_user_posisi" name="filter_user_posisi" class="filter-select" style="width:180px;">
                        <option value="">Semua Posisi</option>
                        @foreach($filterPosisis as $val)
                            <option value="{{ $val }}" {{ $filterUserPosisi == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-search"><i class="bi bi-search"></i> Cari</button>
                    @if($searchUser || $filterUserUnit || $filterUserPosisi)
                        <a href="{{ route('master.user.index') }}?tab=user" class="btn-reset"><i class="bi bi-x-circle"></i> Reset</a>
                    @endif
                </form>
            </div>

            <!-- Sub-tab nav -->
            <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                <div class="tab-nav">
                    <button class="tab-btn active" id="subtab-btn-aktif" onclick="switchSubTab('aktif')">
                        <i class="bi bi-person-check-fill"></i> Sudah Punya Akun
                        <span class="count">{{ $empDenganAkun->count() }}</span>
                    </button>
                    <button class="tab-btn" id="subtab-btn-belum" onclick="switchSubTab('belum')">
                        <i class="bi bi-person-x-fill"></i> Belum Punya Akun
                        <span class="count">{{ $empTanpaAkun->count() }}</span>
                    </button>
                </div>
                @if($empTanpaAkun->count() > 0)
                <form action="{{ route('master.user.storeAll') }}" method="POST" class="ms-auto"
                      onsubmit="return confirm('Buat akun untuk semua {{ $empTanpaAkun->count() }} karyawan yang belum punya akun? Role ditentukan otomatis dari jabatan & unit.')">
                    @csrf
                    <button type="submit" class="btn-tambah">
                        <i class="bi bi-people-fill"></i> Buat Semua Akun ({{ $empTanpaAkun->count() }})
                    </button>
                </form>
                @endif
            </div>

            <!-- Sub-tab: Sudah Punya Akun -->
            <div id="subtab-aktif">
                <div class="table-card">
                    <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>NIP</th>
                                <th>Nama Karyawan</th>
                                <th>Unit</th>
                                <th>Posisi</th>
                                <th>Jabatan</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($empDenganAkun->values() as $i => $emp)
                            @php
                                $user    = $userByName[strtolower($emp->nama_karyawan)];
                                $roleObj = $allRoles->firstWhere('name', $user->role);
                                $bgColor  = $roleObj ? $roleObj->color . '22' : '#6c757d22';
                                $txtColor = $roleObj ? $roleObj->color : '#6c757d';
                            @endphp
                            <tr>
                                <td style="color:#888; font-size:13px;">{{ $i + 1 }}</td>
                                <td><code style="background:#f4f4f4; padding:2px 8px; border-radius:6px; font-size:12.5px;">{{ $emp->nip }}</code></td>
                                <td style="font-weight:600;">{{ $emp->nama_karyawan }}</td>
                                <td style="color:#666; font-size:13px;">{{ $emp->unit }}</td>
                                <td style="color:#666; font-size:13px;">{{ $emp->posisi_pekerjaan }}</td>
                                <td style="color:#666; font-size:13px;">{{ $emp->jabatan ?? '-' }}</td>
                                <td><code style="background:#f4f4f4; padding:2px 8px; border-radius:6px; font-size:12.5px;">{{ $user->username }}</code></td>
                                <td>
                                    <span class="badge-role" style="background:{{ $bgColor }}; color:{{ $txtColor }};">
                                        {{ $roleObj ? $roleObj->label : $user->role }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn-icon btn-icon-edit" title="Edit Role"
                                            onclick="openEditUserRole({{ $user->id }}, '{{ addslashes($emp->nama_karyawan) }}', '{{ addslashes($user->role) }}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('master.user.destroy', $user->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Yakin hapus akun {{ addslashes($emp->nama_karyawan) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-icon btn-icon-delete" title="Hapus Akun">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <i class="bi bi-people"></i>
                                        <p>Belum ada karyawan yang memiliki akun.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>

            <!-- Sub-tab: Belum Punya Akun -->
            <div id="subtab-belum" class="d-none">
                <div class="table-card">
                    <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>NIP</th>
                                <th>Nama Karyawan</th>
                                <th>Unit</th>
                                <th>Posisi</th>
                                <th>Jabatan</th>
                                <th>Role (otomatis)</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($empTanpaAkun->values() as $i => $emp)
                            @php
                                $jabatanBawah = ['STAFF', 'PENANGGUNG JAWAB', 'DOKTER SPESIALIS'];
                                $jabatanUp    = strtoupper(trim($emp->jabatan ?? ''));
                                $unitSlug     = 'unit_' . \Illuminate\Support\Str::slug(strtolower($emp->unit), '_');
                                if (in_array($jabatanUp, $jabatanBawah)) {
                                    $autoRole = $allRoles->firstWhere('name', 'user');
                                } else {
                                    $autoRole = $allRoles->firstWhere('name', $unitSlug) ?? $allRoles->firstWhere('name', 'user');
                                }
                                $roleBg  = $autoRole ? $autoRole->color . '22' : '#6c757d22';
                                $roleTxt = $autoRole ? $autoRole->color : '#6c757d';
                            @endphp
                            <tr>
                                <td style="color:#888; font-size:13px;">{{ $i + 1 }}</td>
                                <td><code style="background:#f4f4f4; padding:2px 8px; border-radius:6px; font-size:12.5px;">{{ $emp->nip }}</code></td>
                                <td style="font-weight:600;">{{ $emp->nama_karyawan }}</td>
                                <td style="color:#666; font-size:13px;">{{ $emp->unit }}</td>
                                <td style="color:#666; font-size:13px;">{{ $emp->posisi_pekerjaan }}</td>
                                <td style="color:#666; font-size:13px;">{{ $emp->jabatan ?? '-' }}</td>
                                <td>
                                    <span class="badge-role" style="background:{{ $roleBg }}; color:{{ $roleTxt }};">
                                        {{ $autoRole ? $autoRole->label : 'User' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('master.user.storeOne', $emp->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-icon" title="Buat Akun" style="color:#005654;">
                                            <i class="bi bi-person-plus-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="bi bi-person-check"></i>
                                        <p>Semua karyawan sudah memiliki akun.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════ -->
        <!-- TAB: MANAJEMEN ROLE                    -->
        <!-- ══════════════════════════════════════ -->
        <div id="tab-role" class="{{ $tab !== 'role' ? 'd-none' : '' }}">
        
            <!-- Filter + Tambah -->
            <div class="filter-bar mb-3">
                <form method="GET" action="{{ route('master.user.index') }}"
                      class="d-flex align-items-center gap-2 flex-wrap w-100">
                    <input type="hidden" name="tab" value="role">
                    <div class="search-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search_role" value="{{ request('search_role') }}" placeholder="Cari nama / label role...">
                    </div>
                    <button type="submit" class="btn-search"><i class="bi bi-search"></i> Cari</button>
                    @if(request('search_role'))
                        <a href="{{ route('master.user.index') }}?tab=role" class="btn-reset"><i class="bi bi-x-circle"></i> Reset</a>
                    @endif
                    <div class="ms-auto">
                        <button type="button" class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambahRole">
                            <i class="bi bi-plus-lg"></i> Tambah Role
                        </button>
                    </div>
                </form>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width:48px;">#</th>
                            <th>Nama Role</th>
                            <th>Label</th>
                            <th>Deskripsi</th>
                            <th>Halaman Login</th>
                            <th class="text-center">Warna</th>
                            <th class="text-center">Jumlah User</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $i => $role)
                        <tr>
                            <td style="color:#888; font-size:13px;">{{ $i + 1 }}</td>
                            <td><code style="background:#f4f4f4; padding:2px 8px; border-radius:6px; font-size:12.5px;">{{ $role->name }}</code></td>
                            <td>
                                <span class="badge-role" style="background:{{ $role->color }}22; color:{{ $role->color }};">
                                    {{ $role->label }}
                                </span>
                            </td>
                            <td style="color:#888; font-size:13px;">{{ $role->description ?? '—' }}</td>
                            <td style="font-size:13px;">
                                <code style="background:#f4f4f4; padding:2px 8px; border-radius:6px; font-size:12px; color:#005654;">
                                    {{ $role->redirect_to ?? '—' }}
                                </code>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <span class="color-swatch" style="background:{{ $role->color }};"></span>
                                    <code style="font-size:12px; color:#888;">{{ $role->color }}</code>
                                </div>
                            </td>
                            <td class="text-center">
                                <span style="font-weight:700; color:#005654;">{{ $role->users()->count() }}</span>
                                <span style="color:#aaa; font-size:12px;"> user</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn-icon btn-icon-edit" title="Edit"
                                            onclick="openEditRole({{ $role->id }}, '{{ $role->name }}', '{{ addslashes($role->label) }}', '{{ addslashes($role->description ?? '') }}', '{{ $role->color }}', '{{ $role->redirect_to ?? '/permintaan' }}', '{{ addslashes(json_encode($role->allowed_groups ?? [])) }}')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('master.role.destroy', $role->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin hapus role \'{{ $role->label }}\'? Pastikan tidak ada user yang menggunakan role ini.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-delete" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="bi bi-shield"></i>
                                    <p>Belum ada role.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════ -->
        <!-- TAB: DATA KARYAWAN                     -->
        <!-- ══════════════════════════════════════ -->
        <div id="tab-karyawan" class="{{ $tab !== 'karyawan' ? 'd-none' : '' }}">

            <div class="filter-bar mb-4">
                <form method="GET" action="{{ route('master.user.index') }}"
                      class="d-flex align-items-center gap-2 flex-wrap w-100">
                    <input type="hidden" name="tab" value="karyawan">
                    <div class="search-wrap">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search_karyawan" value="{{ request('search_karyawan') }}" placeholder="Cari nama / profesi...">
                    </div>
                    <select id="kar_filter_unit" name="filter_unit" class="filter-select" style="width:160px;">
                        <option value="">Semua Unit</option>
                        @foreach($filterUnits as $val)
                            <option value="{{ $val }}" {{ request('filter_unit') == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    <select id="kar_filter_posisi" name="filter_posisi" class="filter-select" style="width:180px;">
                        <option value="">Semua Posisi</option>
                        @foreach($filterPosisis as $val)
                            <option value="{{ $val }}" {{ request('filter_posisi') == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    <select id="kar_filter_jabatan" name="filter_jabatan" class="filter-select" style="width:160px;">
                        <option value="">Semua Jabatan</option>
                        @foreach($filterJabatans as $val)
                            <option value="{{ $val }}" {{ request('filter_jabatan') == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-search"><i class="bi bi-search"></i> Cari</button>
                    @if(request('search_karyawan') || request('filter_unit') || request('filter_posisi') || request('filter_jabatan'))
                        <a href="{{ route('master.user.index') }}?tab=karyawan" class="btn-reset"><i class="bi bi-x-circle"></i> Reset</a>
                    @endif
                    <div class="ms-auto">
                        <button type="button" class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambahKaryawan">
                            <i class="bi bi-plus-lg"></i> Tambah Karyawan
                        </button>
                    </div>
                </form>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width:48px;">#</th>
                            <th>NIP</th>
                            <th>Nama Karyawan</th>
                            <th>Unit</th>
                            <th>Posisi Pekerjaan</th>
                            <th>Profesi</th>
                            <th>Jabatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $i => $emp)
                        <tr>
                            <td style="color:#888; font-size:13px;">{{ $i + 1 }}</td>
                            <td><code style="background:#f4f4f4; padding:2px 8px; border-radius:6px; font-size:12.5px;">{{ $emp->nip }}</code></td>
                            <td style="font-weight:600;">{{ $emp->nama_karyawan }}</td>
                            <td>{{ $emp->unit }}</td>
                            <td>{{ $emp->posisi_pekerjaan }}</td>
                            <td>{{ $emp->profesi }}</td>
                            <td>{{ $emp->jabatan }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn-icon btn-icon-edit" title="Edit"
                                        onclick="openEditKaryawan({{ $emp->id }}, '{{ addslashes($emp->nip) }}', '{{ addslashes($emp->nama_karyawan) }}', '{{ addslashes($emp->unit) }}', '{{ addslashes($emp->posisi_pekerjaan) }}', '{{ addslashes($emp->profesi) }}', '{{ addslashes($emp->jabatan) }}')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('master.employee.destroy', $emp->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin hapus karyawan {{ $emp->nama_karyawan }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-delete" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="bi bi-person-badge"></i>
                                    <p>Belum ada data karyawan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ══════════════════════════════════════ -->
<!-- MODAL: TAMBAH ROLE                     -->
<!-- ══════════════════════════════════════ -->
<div class="modal fade" id="modalTambahRole" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('master.role.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" style="color:#005654;">Tambah Role Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Role <span style="color:#aaa; font-weight:400;">(slug, huruf kecil & underscore)</span></label>
                        <input type="text" name="name" class="form-control" placeholder="contoh: kepala_unit" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Label Tampilan</label>
                        <input type="text" name="label" class="form-control" placeholder="contoh: Kepala Unit" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span style="color:#aaa; font-weight:400;">(opsional)</span></label>
                        <input type="text" name="description" class="form-control" placeholder="Deskripsi singkat role ini">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Halaman Setelah Login</label>
                        <select name="redirect_to" class="form-select" required>
                            <option value="/permintaan">Permintaan Surat</option>
                            <option value="/layanan">Layanan (Form Pengajuan)</option>
                            <option value="/user/permintaan">Riwayat Permintaan Saya</option>
                            <option value="/master/user">Master Akun & Role</option>
                            <option value="/master/layanan">Master Layanan</option>
                            <option value="/master/kategori">Master Kategori</option>
                        </select>
                        <div style="font-size:12px; color:#888; margin-top:4px;">Halaman yang dituju saat user dengan role ini berhasil login.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hak Akses Halaman</label>
                        <div style="background:#f8fffe; border:1.5px solid #d0e8e7; border-radius:10px; padding:12px 16px;">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="allowed_groups[]" value="user" id="ag_add_user">
                                <label class="form-check-label" for="ag_add_user" style="font-size:13.5px;">
                                    <strong>Layanan & Pengajuan</strong>
                                    <span style="color:#888; font-size:12px; display:block;">Akses /layanan dan /user/permintaan</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="allowed_groups[]" value="rekam_medis" id="ag_add_staff">
                                <label class="form-check-label" for="ag_add_staff" style="font-size:13.5px;">
                                    <strong>Permintaan Surat (Staff)</strong>
                                    <span style="color:#888; font-size:12px; display:block;">Akses /permintaan dan manajemen surat</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="allowed_groups[]" value="admin" id="ag_add_admin">
                                <label class="form-check-label" for="ag_add_admin" style="font-size:13.5px;">
                                    <strong>Master / Admin</strong>
                                    <span style="color:#888; font-size:12px; display:block;">Akses /master (layanan, user, kategori)</span>
                                </label>
                            </div>
                        </div>
                        <div style="font-size:12px; color:#888; margin-top:4px;">Centang halaman yang boleh diakses oleh role ini.</div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Warna Badge</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="color" name="color" id="colorPickerAdd" value="#005654"
                                   class="form-control form-control-color" style="width:50px; height:38px; border-radius:10px; padding:2px;">
                            <span style="font-size:13px; color:#888;">Pilih warna untuk badge role</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" style="border-radius:10px;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom">Simpan Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════ -->
<!-- MODAL: EDIT ROLE                       -->
<!-- ══════════════════════════════════════ -->
<div class="modal fade" id="modalEditRole" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEditRole" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" style="color:#005654;">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Role</label>
                        <input type="text" id="editRoleName" class="form-control" disabled style="background:#f8f8f8; color:#888;">
                        <div style="font-size:12px; color:#aaa; margin-top:4px;">Nama role tidak dapat diubah karena digunakan sebagai referensi.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Label Tampilan</label>
                        <input type="text" name="label" id="editRoleLabel" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span style="color:#aaa; font-weight:400;">(opsional)</span></label>
                        <input type="text" name="description" id="editRoleDesc" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Halaman Setelah Login</label>
                        <select name="redirect_to" id="editRoleRedirect" class="form-select" required>
                            <option value="/permintaan">Permintaan Surat</option>
                            <option value="/layanan">Layanan (Form Pengajuan)</option>
                            <option value="/user/permintaan">Riwayat Permintaan Saya</option>
                            <option value="/master/user">Master Akun & Role</option>
                            <option value="/master/layanan">Master Layanan</option>
                            <option value="/master/kategori">Master Kategori</option>
                        </select>
                        <div style="font-size:12px; color:#888; margin-top:4px;">Halaman yang dituju saat user dengan role ini berhasil login.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hak Akses Halaman</label>
                        <div style="background:#f8fffe; border:1.5px solid #d0e8e7; border-radius:10px; padding:12px 16px;">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="allowed_groups[]" value="user" id="ag_edit_user">
                                <label class="form-check-label" for="ag_edit_user" style="font-size:13.5px;">
                                    <strong>Layanan & Pengajuan</strong>
                                    <span style="color:#888; font-size:12px; display:block;">Akses /layanan dan /user/permintaan</span>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="allowed_groups[]" value="rekam_medis" id="ag_edit_staff">
                                <label class="form-check-label" for="ag_edit_staff" style="font-size:13.5px;">
                                    <strong>Permintaan Surat (Staff)</strong>
                                    <span style="color:#888; font-size:12px; display:block;">Akses /permintaan dan manajemen surat</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="allowed_groups[]" value="admin" id="ag_edit_admin">
                                <label class="form-check-label" for="ag_edit_admin" style="font-size:13.5px;">
                                    <strong>Master / Admin</strong>
                                    <span style="color:#888; font-size:12px; display:block;">Akses /master (layanan, user, kategori)</span>
                                </label>
                            </div>
                        </div>
                        <div style="font-size:12px; color:#888; margin-top:4px;">Centang halaman yang boleh diakses oleh role ini.</div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Warna Badge</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="color" name="color" id="colorPickerEdit"
                                   class="form-control form-control-color" style="width:50px; height:38px; border-radius:10px; padding:2px;">
                            <span style="font-size:13px; color:#888;">Pilih warna untuk badge role</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" style="border-radius:10px;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    function toggleSidebarDropdown(btn) {
        btn.closest('.sidebar-dropdown').classList.toggle('open');
    }
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.sidebar-sublink.active').forEach(el => {
            el.closest('.sidebar-dropdown')?.classList.add('open');
        });

        // Select2 untuk filter unit & posisi di tab user
        if (typeof $.fn.select2 !== 'undefined') {
            $('#sel_user_unit').select2({
                placeholder: 'Semua Unit',
                allowClear: true,
                width: '160px',
                language: { noResults: () => 'Unit tidak ditemukan', searching: () => 'Mencari...' }
            }).on('select2:select select2:clear', function() {
                this.closest('form').submit();
            });

            $('#sel_user_posisi').select2({
                placeholder: 'Semua Posisi',
                allowClear: true,
                width: '200px',
                language: { noResults: () => 'Posisi tidak ditemukan', searching: () => 'Mencari...' }
            }).on('select2:select select2:clear', function() {
                this.closest('form').submit();
            });
        }

        // Select2 for employee picker — tidak digunakan lagi (form panel dihapus)

            // Select2 untuk dropdown role di modal edit user
            $('#er_role').select2({
                dropdownParent: $('#modalEditUserRole'),
                placeholder: '-- Pilih Role --',
                allowClear: false,
                width: '100%',
                language: {
                    noResults: () => 'Role tidak ditemukan',
                    searching: () => 'Mencari...'
                }
            });

            // Select2 untuk filter di tab karyawan
            const karOpts = {
                allowClear: true,
                language: { noResults: () => 'Tidak ditemukan', searching: () => 'Mencari...' }
            };
            $('#kar_filter_unit').select2({ ...karOpts, placeholder: 'Semua Unit', width: '160px' })
                .on('select2:select select2:clear', function() { this.closest('form').submit(); });
            $('#kar_filter_posisi').select2({ ...karOpts, placeholder: 'Semua Posisi', width: '200px' })
                .on('select2:select select2:clear', function() { this.closest('form').submit(); });
            $('#kar_filter_jabatan').select2({ ...karOpts, placeholder: 'Semua Jabatan', width: '160px' })
                .on('select2:select select2:clear', function() { this.closest('form').submit(); });
    });

    function pisahkanNama(namaLengkap) {
        const GELAR_DEPAN  = ['dr', 'drg', 'drs', 'dra', 'prof', 'ir', 'ns', 'apt', 'ners', 'kh', 'hj', 'h'];
        const GELAR_BELAKANG = [
            's.kep','s.farm','s.gz','s.ked','s.si','s.km','s.kl','s.pd','s.t','s.e','s.h','s.sos','s.kom','s.ip','s.psi',
            'm.kes','m.kep','m.farm','m.si','m.pd','m.m','m.t','m.h','m.sc','m.kom','ph.d',
            'sp.a','sp.b','sp.og','sp.pd','sp.rad','sp.an','sp.jp','sp.s','sp.m','sp.kk','sp.p','sp.u','sp.tht',
            'sp.gk','sp.mk','sp.kj','sp.f','sp.n','sp.pa','sp.pk','sp.paru','sp.em','sp.ba','sp.bs','sp.bo','sp.btkv',
            'ns','apt','ners','amd','amk','amg','amf','skm','skep','sst','ssi','bsn','mars','mkm','mm','se','dr',
        ];
        // Semua setelah koma pertama adalah gelar
        const idxKoma = namaLengkap.indexOf(',');
        const bagian  = idxKoma !== -1 ? namaLengkap.substring(0, idxKoma).trim() : namaLengkap.trim();
        const kata    = bagian.split(/\s+/);
        // Buang gelar depan
        let i = 0;
        while (i < kata.length && GELAR_DEPAN.includes(kata[i].toLowerCase().replace(/\.$/, ''))) i++;
        // Buang gelar belakang dari akhir
        const kataNama = kata.slice(i);
        while (kataNama.length > 1 && GELAR_BELAKANG.includes(kataNama[kataNama.length - 1].toLowerCase().replace(/\.$/, ''))) {
            kataNama.pop();
        }
        // Bersihkan titik trailing dari setiap kata nama
        const bersih = kataNama.map(k => k.replace(/\.+$/, ''));
        return { depan: bersih[0] || '', belakang: bersih[1] || '' };
    }

    function generateUsername() {
        // Digunakan oleh modal edit user (via editUserNamaDepan/Belakang)
        const depan = (document.getElementById('editUserNamaDepan')?.value.trim().split(/\s+/)[0] || '').toLowerCase();
        const belakang = (document.getElementById('editUserNamaBelakang')?.value.trim().split(/\s+/)[0] || '').toLowerCase();
        if (document.getElementById('editUserUsername')) {
            document.getElementById('editUserUsername').value = belakang ? depan + '.' + belakang : depan;
        }
    }

    function updateFullName() {
        const depan = document.getElementById('editUserNamaDepan')?.value.trim() || '';
        const belakang = document.getElementById('editUserNamaBelakang')?.value.trim() || '';
        if (document.getElementById('editUserName')) {
            document.getElementById('editUserName').value = belakang ? depan + ' ' + belakang : depan;
        }
    }

    // Auto-generate username di modal edit user
    function generateEditUserUsername() {
        const depan = document.getElementById('editUserNamaDepan').value.trim().toLowerCase().replace(/\s+/g, '');
        const belakang = document.getElementById('editUserNamaBelakang').value.trim().toLowerCase().replace(/\s+/g, '');
        document.getElementById('editUserUsername').value = belakang ? depan + '.' + belakang : depan;
    }
    function updateEditUserFullName() {
        const depan = document.getElementById('editUserNamaDepan').value.trim();
        const belakang = document.getElementById('editUserNamaBelakang').value.trim();
        document.getElementById('editUserName').value = belakang ? depan + ' ' + belakang : depan;
    }
    document.getElementById('editUserNamaDepan')?.addEventListener('input', () => { generateEditUserUsername(); updateEditUserFullName(); });
    document.getElementById('editUserNamaBelakang')?.addEventListener('input', () => { generateEditUserUsername(); updateEditUserFullName(); });

    function switchSubTab(name) {
        ['aktif','belum'].forEach(t => {
            document.getElementById('subtab-' + t).classList.toggle('d-none', t !== name);
            document.getElementById('subtab-btn-' + t).classList.toggle('active', t === name);
        });
    }

    function switchTab(tab) {
        ['user','role','karyawan'].forEach(t => {
            document.getElementById('tab-' + t).classList.toggle('d-none', t !== tab);
        });
        document.querySelectorAll('.tab-btn').forEach((btn, i) => {
            const tabs = ['user','role','karyawan'];
            btn.classList.toggle('active', tabs[i] === tab);
        });
    }

    function openEditUserRole(userId, namaKaryawan, currentRole) {
        document.getElementById('formEditUserRole').action = `/master/user/${userId}`;
        document.getElementById('er_nama_display').value   = namaKaryawan;
        $('#er_role').val(currentRole).trigger('change');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditUserRole')).show();
    }

    function openEditUser(id, name, username, role) {
        document.getElementById('formEditUser').action = `/master/user/${id}`;
        // Pisahkan nama lengkap jadi depan & belakang
        const parts = name.trim().split(/\s+/);
        const depan = parts[0] || '';
        const belakang = parts.slice(1).join(' ');
        document.getElementById('editUserNamaDepan').value = depan;
        document.getElementById('editUserNamaBelakang').value = belakang;
        document.getElementById('editUserUsername').value = username;
        document.getElementById('editUserName').value = name;
        // Set role
        const roleSelect = document.querySelector('#modalEditUser select[name="role"]');
        if (roleSelect) roleSelect.value = role;
        // Reset password fields
        document.querySelector('#modalEditUser input[name="password"]').value = '';
        document.querySelector('#modalEditUser input[name="password_confirmation"]').value = '';
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditUser')).show();
    }

    function openEditRole(id, name, label, description, color, redirectTo, allowedGroups) {
        document.getElementById('formEditRole').action = `/master/role/${id}`;
        document.getElementById('editRoleName').value  = name;
        document.getElementById('editRoleLabel').value = label;
        document.getElementById('editRoleDesc').value  = description;
        document.getElementById('colorPickerEdit').value = color;
        document.getElementById('editRoleRedirect').value = redirectTo || '/permintaan';
        // Set checkboxes
        const groups = allowedGroups ? JSON.parse(allowedGroups) : [];
        document.getElementById('ag_edit_user').checked  = groups.includes('user');
        document.getElementById('ag_edit_staff').checked = groups.includes('rekam_medis');
        document.getElementById('ag_edit_admin').checked = groups.includes('admin');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditRole')).show();
    }

    function openEditKaryawan(id, nip, nama, unit, posisi, profesi, jabatan) {
        document.getElementById('formEditKaryawan').action = `/master/employee/${id}`;
        document.getElementById('editNip').value    = nip;
        document.getElementById('editNama').value   = nama;
        document.getElementById('editUnit').value   = unit;
        document.getElementById('editPosisi').value = posisi;
        document.getElementById('editProfesi').value = profesi;
        document.getElementById('editJabatan').value = jabatan;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditKaryawan')).show();
    }

    // Buka modal tambah role jika ada error validasi
    @if($errors->any() && $tab === 'role')
        document.addEventListener('DOMContentLoaded', () => {
            new bootstrap.Modal(document.getElementById('modalTambahRole')).show();
        });
    @endif

    // Buka tab karyawan jika redirect dengan tab=karyawan
    @if($tab === 'karyawan')
        document.addEventListener('DOMContentLoaded', () => switchTab('karyawan'));
    @endif
</script>
<!-- ══════════════════════════════════════ -->
<!-- MODAL: EDIT USER                        -->
<!-- ══════════════════════════════════════ -->
<div class="modal fade" id="modalEditUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEditUser" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" style="color:#005654;">Edit Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert" style="background:#e6f7f6; color:#005654; border-radius:8px; padding:8px 12px; font-size:13px; margin-bottom:16px;">
                        <i class="bi bi-info-circle me-1"></i>
                        Username dibuat otomatis dari nama depan dan nama belakang.
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label">Nama Depan</label>
                            <input type="text" id="editUserNamaDepan" name="nama_depan" class="form-control" required placeholder="Nama depan">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Belakang</label>
                            <input type="text" id="editUserNamaBelakang" name="nama_belakang" class="form-control" placeholder="Nama belakang">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" id="editUserUsername" name="username" class="form-control"
                               style="background:#f4fbfa; color:#005654; font-weight:600;">
                        <div style="font-size:12px; color:#888; margin-top:4px;">Format: namadepan.namabelakang — bisa diedit manual jika perlu.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" id="editUserName" name="name" class="form-control" required>
                    </div>
                    <div style="border-top:1.5px dashed #d0e8e7; margin:16px 0;"></div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            @foreach($allRoles as $role)
                                <option value="{{ $role->name }}">{{ $role->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control">
                        <div style="font-size:12px; color:#888; margin-top:4px;">Kosongkan jika tidak ingin mengubah password.</div>
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" style="border-radius:10px;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════ -->
<!-- MODAL: TAMBAH KARYAWAN                 -->
<!-- ══════════════════════════════════════ -->
<div class="modal fade" id="modalTambahKaryawan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('master.employee.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" style="color:#005654;">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Pegawai" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Karyawan</label>
                            <input type="text" name="nama_karyawan" class="form-control" placeholder="Nama lengkap" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Unit</label>
                            <input type="text" name="unit" class="form-control" placeholder="Unit kerja" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Posisi Pekerjaan</label>
                            <input type="text" name="posisi_pekerjaan" class="form-control" placeholder="Posisi pekerjaan" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Profesi</label>
                            <input type="text" name="profesi" class="form-control" placeholder="Profesi" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" placeholder="Jabatan" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" style="border-radius:10px;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════ -->
<!-- MODAL: EDIT KARYAWAN                   -->
<!-- ══════════════════════════════════════ -->
<div class="modal fade" id="modalEditKaryawan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="formEditKaryawan" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" style="color:#005654;">Edit Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" id="editNip" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Karyawan</label>
                            <input type="text" name="nama_karyawan" id="editNama" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Unit</label>
                            <input type="text" name="unit" id="editUnit" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Posisi Pekerjaan</label>
                            <input type="text" name="posisi_pekerjaan" id="editPosisi" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Profesi</label>
                            <input type="text" name="profesi" id="editProfesi" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" id="editJabatan" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" style="border-radius:10px;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════ -->
<!-- MODAL: EDIT ROLE USER                  -->
<!-- ══════════════════════════════════════ -->
<div class="modal fade" id="modalEditUserRole" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formEditUserRole" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" style="color:#005654;"><i class="bi bi-shield-fill me-2" style="color:#81BD41;"></i>Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Karyawan</label>
                        <input type="text" id="er_nama_display" class="form-control" disabled
                               style="background:#f4fbfa; color:#005654; font-weight:600;">
                    </div>
                    <div class="mb-1">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role" id="er_role" class="form-select" required style="width:100%;">
                            @foreach($allRoles as $role)
                                <option value="{{ $role->name }}">{{ $role->label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" style="border-radius:10px;" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom"><i class="bi bi-save me-1"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
