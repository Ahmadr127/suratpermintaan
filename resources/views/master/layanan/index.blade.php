<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/imagesicon.jpg') }}">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Master Layanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; }
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #e6f7f6, #f4fbfa);
        min-height: 100vh; display: flex; margin: 0;
        overflow-x: hidden;
    }

    /* ── SIDEBAR ── */
    .sidebar {
        width: 240px; min-height: 100vh; flex-shrink: 0;
        background: #005654; display: flex; flex-direction: column;
        position: fixed; top: 0; left: 0; bottom: 0; z-index: 100;
    }
    .sidebar-brand {
        padding: 20px 20px 16px; border-bottom: 1px solid rgba(255,255,255,.1);
        display: flex; align-items: center; gap: 10px;
    }
    .sidebar-brand img { height: 38px; width: auto; filter: brightness(0) invert(1); }
    .sidebar-brand-text .title { font-size: 13px; font-weight: 800; color: #fff; line-height: 1.2; }
    .sidebar-brand-text .sub { font-size: 10px; color: rgba(255,255,255,.6); }
    .sidebar-nav { padding: 16px 12px; flex: 1; }
    .sidebar-label {
        font-size: 10px; font-weight: 700; color: rgba(255,255,255,.4);
        text-transform: uppercase; letter-spacing: .8px;
        padding: 0 8px; margin-bottom: 6px; margin-top: 12px;
    }
    .sidebar-link {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 12px; border-radius: 10px;
        color: rgba(255,255,255,.75); font-size: 13.5px; font-weight: 500;
        text-decoration: none; transition: all .2s; margin-bottom: 2px;
    }
    .sidebar-link i { font-size: 16px; flex-shrink: 0; }
    .sidebar-link:hover { background: rgba(255,255,255,.12); color: #fff; }
    .sidebar-link.active { background: rgba(255,255,255,.18); color: #fff; font-weight: 700; }
    .sidebar-link.active-page { background: #81BD41; color: #fff; font-weight: 700; }
    .sidebar-footer { padding: 16px 12px; border-top: 1px solid rgba(255,255,255,.1); }
    .sidebar-user {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 12px; border-radius: 10px;
        background: rgba(255,255,255,.08); margin-bottom: 8px;
    }
    .sidebar-user i { font-size: 20px; color: rgba(255,255,255,.8); }
    .sidebar-user .name { font-size: 13px; font-weight: 600; color: #fff; }
    .sidebar-user .role { font-size: 11px; color: rgba(255,255,255,.5); }
    .btn-logout-sidebar {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; padding: 9px; border-radius: 10px;
        background: #7a2020; color: #ffffff;
        border: 1px solid #a03030; font-size: 13px; font-weight: 600;
        cursor: pointer; transition: all .2s;
    }
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
    .main-wrapper { margin-left: 240px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; overflow-x: hidden; min-width: 0; }
    .topbar { background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.06); padding: 14px 28px; }
    .topbar-title { font-size: 18px; font-weight: 800; color: #005654; }
    .topbar-sub { font-size: 12px; color: #6b8f8a; }

    .filter-bar {
        background: #fff; border-radius: 14px; padding: 16px 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,.05);
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    }
    .search-wrap { position: relative; }
    .search-wrap .bi-search {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%); color: #aaa; font-size: 14px; pointer-events: none;
    }
    .search-wrap input {
        padding-left: 36px; border-radius: 10px; border: 1.5px solid #d0e8e7;
        height: 38px; font-size: 13.5px; width: 260px;
        transition: border-color .2s, box-shadow .2s;
    }
    .search-wrap input:focus { border-color: #005654; box-shadow: 0 0 0 3px rgba(0,86,84,.1); outline: none; }
    .btn-search {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 18px; background: #005654; color: #fff;
        font-size: 13.5px; font-weight: 600; border-radius: 10px;
        border: none; cursor: pointer; transition: background .2s;
    }
    .btn-search:hover { background: #007a77; }
    .btn-reset {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 14px; border-radius: 10px; font-size: 13.5px; font-weight: 500;
        border: 1.5px solid #d0d0d0; color: #666; background: #fff; text-decoration: none;
    }
    .btn-reset:hover { border-color: #005654; color: #005654; }
    .btn-tambah {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 18px; background: #005654; color: #fff;
        font-size: 13.5px; font-weight: 600; border-radius: 10px;
        text-decoration: none; transition: background .2s;
    }
    .btn-tambah:hover { background: #007a77; color: #fff; }

    /* ── LIST TABLE ── */
    .layanan-table {
        width: 100%; border-collapse: collapse;
        background: #fff; border-radius: 14px;
        overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.06);
    }
    .layanan-table thead tr { background: #005654; color: #fff; font-size: 12.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }
    .layanan-table thead th { padding: 12px 16px; white-space: nowrap; }
    .layanan-table tbody tr { border-bottom: 1px solid #f0f7f6; transition: background .12s; font-size: 13.5px; }
    .layanan-table tbody tr:last-child { border-bottom: none; }
    .layanan-table tbody tr:hover { background: #f4fbfa; }
    .layanan-table tbody tr.nonaktif { opacity: .55; }
    .layanan-table td { padding: 11px 16px; vertical-align: middle; }
    .layanan-table td.no { color: #aaa; font-size: 12px; width: 40px; text-align: center; }
    .layanan-name { font-weight: 600; color: #1a2e2d; }
    .layanan-desc { font-size: 12px; color: #6b8f8a; margin-top: 2px; }
    .badge-kat { display:inline-block; padding:2px 9px; border-radius:999px; font-size:11px; font-weight:600; color:#fff; }
    .badge-aktif { display:inline-block; padding:2px 9px; border-radius:999px; font-size:11px; font-weight:600; background:#d1f5ee; color:#0a6b52; }
    .badge-nonaktif { display:inline-block; padding:2px 9px; border-radius:999px; font-size:11px; font-weight:600; background:#ebebeb; color:#6c757d; }
    .btn-edit {
        display:inline-flex; align-items:center; gap:4px;
        padding:5px 12px; border-radius:8px; font-size:12.5px; font-weight:600;
        background:#fff8e1; color:#b8860b; border:none; cursor:pointer;
        text-decoration:none; transition:background .15s;
    }
    .btn-edit:hover { background:#fff3cd; color:#856404; }
    .btn-del {
        display:inline-flex; align-items:center; gap:4px;
        padding:5px 10px; border-radius:8px; font-size:12.5px; font-weight:600;
        background:#fde8e8; color:#c0392b; border:none; cursor:pointer; transition:background .15s;
    }
    .btn-del:hover { background:#fcc; color:#922b21; }
    .empty-state { padding: 60px 20px; text-align: center; color: #aaa; }
    .empty-state i { font-size: 48px; margin-bottom: 12px; display: block; color: #c8e6e5; }
    .empty-state p { font-size: 14px; margin: 0; }
    .d-contents { display: contents; }

    /* Select2 filter bar */
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
                <a href="{{ route('master.layanan.index') }}" class="sidebar-sublink active">
                    <i class="bi bi-file-earmark-text-fill"></i> Layanan
                </a>
            </div>
        </div>
        @endif
        @if(auth()->user()->role === 'admin')
        <div class="sidebar-dropdown">
            <button class="sidebar-link sidebar-dropdown-toggle w-100" onclick="toggleSidebarDropdown(this)">
                <i class="bi bi-people-fill"></i>
                <span>Akun</span>
                <i class="bi bi-chevron-down sidebar-chevron ms-auto"></i>
            </button>
            <div class="sidebar-submenu">
                <a href="{{ route('master.user.index') }}?tab=user" class="sidebar-sublink">
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
        <div class="topbar-title">Master Layanan</div>
        <div class="topbar-sub">Sistem Informasi Rekam Medis</div>
    </div>

    <div class="container-fluid px-4 px-md-5 py-4">

        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2 mb-4" style="border-radius:12px;">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        <div class="filter-bar mb-4">
            <form method="GET" action="{{ route('master.layanan.index') }}"
                  class="d-flex align-items-center gap-2 flex-wrap w-100">
                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari layanan...">
                </div>
                <button type="submit" class="btn-search"><i class="bi bi-search"></i> Cari</button>
                @if(request('search') || request('kategori'))
                    <a href="{{ route('master.layanan.index') }}" class="btn-reset"><i class="bi bi-x-circle"></i> Reset</a>
                @endif
                <select name="kategori" id="filterKategori" class="form-select" style="width:180px;height:38px;border-radius:10px;border:1.5px solid #d0e8e7;font-size:13px;">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>
                <div class="ms-auto">
                    <a href="{{ route('master.layanan.create') }}" class="btn-tambah">
                        <i class="bi bi-plus-lg"></i> Tambah Layanan
                    </a>
                </div>
            </form>
        </div>

        <table class="layanan-table">
            <thead>
                <tr>
                    <th class="no">#</th>
                    <th>Nama Layanan</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th style="width:130px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($layanans as $i => $layanan)
                <tr class="{{ $layanan->is_active ? '' : 'nonaktif' }}">
                    <td class="no">{{ $i + 1 }}</td>
                    <td>
                        <div class="layanan-name">{{ $layanan->nama_layanan }}</div>
                        @if($layanan->deskripsi)
                            <div class="layanan-desc">{{ $layanan->deskripsi }}</div>
                        @endif
                    </td>
                    <td>
                        @if($layanan->kategori)
                            <span class="badge-kat" style="background:{{ $layanan->kategori->warna }}">
                                {{ $layanan->kategori->nama }}
                            </span>
                        @else
                            <span style="color:#bbb; font-size:12px;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($layanan->is_active)
                            <span class="badge-aktif">Aktif</span>
                        @else
                            <span class="badge-nonaktif">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('master.layanan.edit', $layanan->id) }}" class="btn-edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('master.layanan.destroy', $layanan->id) }}"
                                  method="POST" class="d-contents"
                                  onsubmit="return confirm('Yakin hapus layanan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada data layanan.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#filterKategori').select2({
            placeholder: 'Semua Kategori',
            allowClear: true,
            width: '200px',
            language: {
                noResults: () => 'Kategori tidak ditemukan',
                searching: () => 'Mencari...'
            }
        }).on('select2:select select2:clear', function() {
            this.closest('form').submit();
        });
    });

    function toggleSidebarDropdown(btn) {
        btn.closest('.sidebar-dropdown').classList.toggle('open');
    }
    document.querySelectorAll('.sidebar-sublink.active').forEach(el => {
        el.closest('.sidebar-dropdown')?.classList.add('open');
    });
</script>
</body>
</html>
