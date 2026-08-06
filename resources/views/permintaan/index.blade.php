<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/imagesicon.jpg') }}">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Permintaan Layanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; }
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #e6f7f6, #f4fbfa);
        min-height: 100vh;
        display: flex;
        margin: 0;
        overflow-x: hidden;
    }

    /* ── SIDEBAR ── */
    .sidebar {
        width: 240px; min-height: 100vh; flex-shrink: 0;
        background: #005654;
        display: flex; flex-direction: column;
        position: fixed; top: 0; left: 0; bottom: 0;
        z-index: 100;
    }
    .sidebar-brand {
        padding: 20px 20px 16px;
        border-bottom: 1px solid rgba(255,255,255,.1);
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
    .sidebar-footer {
        padding: 16px 12px;
        border-top: 1px solid rgba(255,255,255,.1);
    }
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

    /* ── MAIN CONTENT ── */
    .main-wrapper {
        margin-left: 240px;
        flex: 1;
        min-height: 100vh;
        display: flex; flex-direction: column;
        overflow-x: hidden;
        min-width: 0;
    }
    .topbar {
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,.06);
        padding: 14px 28px;
    }
    .topbar-title { font-size: 18px; font-weight: 800; color: #005654; }
    .topbar-sub { font-size: 12px; color: #6b8f8a; }

    /* ── FILTER BAR ── */
    .filter-bar {
        background: #fff; border-radius: 14px;
        padding: 16px 20px; box-shadow: 0 2px 12px rgba(0,0,0,.05);
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    }
    .search-wrap { position: relative; }
    .search-wrap .bi-search {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%); color: #aaa; font-size: 14px; pointer-events: none;
    }
    .search-wrap input {
        padding-left: 36px; border-radius: 10px;
        border: 1.5px solid #d0e8e7; height: 38px;
        font-size: 13.5px; width: 220px;
        transition: border-color .2s, box-shadow .2s;
    }
    .search-wrap input:focus { border-color: #005654; box-shadow: 0 0 0 3px rgba(0,86,84,.1); outline: none; }
    .filter-select {
        border-radius: 10px; border: 1.5px solid #d0e8e7;
        height: 38px; font-size: 13.5px; padding: 0 12px;
        width: 200px; background: #fff; color: #333;
        transition: border-color .2s, box-shadow .2s; appearance: auto;
    }
    .filter-select:focus { border-color: #005654; box-shadow: 0 0 0 3px rgba(0,86,84,.1); outline: none; }

    /* Select2 custom styling */
    .select2-container .select2-selection--single {
        height: 38px; border-radius: 10px; border: 1.5px solid #d0e8e7;
        display: flex; align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px; font-size: 13.5px; color: #333; padding-left: 12px; padding-right: 30px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px; right: 8px;
    }
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #005654; box-shadow: 0 0 0 3px rgba(0,86,84,.1); outline: none;
    }
    .select2-dropdown {
        border-radius: 10px; border: 1.5px solid #d0e8e7;
        box-shadow: 0 4px 16px rgba(0,0,0,.1); font-size: 13.5px;
    }
    .select2-results__options {
        max-height: 220px; overflow-y: auto;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border-radius: 8px; border: 1.5px solid #d0e8e7; font-size: 13px; padding: 6px 10px;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: #005654; outline: none;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #2563EB;
    }
    .select2-container { width: 200px !important; }
    .date-wrap { position: relative; display: inline-flex; align-items: center; }
    .date-wrap .date-placeholder {
        position: absolute; left: 12px; color: #aaa;
        font-size: 13px; pointer-events: none; white-space: nowrap;
    }
    .date-wrap input[type="date"] {
        border-radius: 10px; border: 1.5px solid #d0e8e7;
        height: 38px; font-size: 13.5px; width: 165px;
        padding: 0 12px; transition: border-color .2s, box-shadow .2s;
    }
    .date-wrap input[type="date"]:focus { border-color: #005654; box-shadow: 0 0 0 3px rgba(0,86,84,.1); outline: none; }
    .btn-search {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 18px; background: #005654; color: #fff;
        font-size: 13.5px; font-weight: 600; border-radius: 10px;
        border: none; cursor: pointer; transition: background .2s, transform .15s;
    }
    .btn-search:hover { background: #007a77; transform: translateY(-1px); }
    .btn-reset {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 14px; border-radius: 10px; font-size: 13.5px; font-weight: 500;
        border: 1.5px solid #d0d0d0; color: #666; background: #fff; text-decoration: none; transition: all .2s;
    }
    .btn-reset:hover { border-color: #005654; color: #005654; background: #f0f9f8; }

    /* ── TABLE CARD ── */
    .table-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.06); }
    .table-card .table-responsive { overflow-x: auto; overflow-y: auto; max-height: 75vh; border-radius: 16px; }
    .table thead th { position: sticky; top: 0; z-index: 2; }
    .table { margin-bottom: 0; }
    .table thead th {
        background: #005654; color: #fff;
        font-size: 11.5px; font-weight: 600;
        letter-spacing: .4px; text-transform: uppercase;
        padding: 13px 14px; border: none; white-space: nowrap;
    }
    .table tbody td {
        padding: 12px 14px; vertical-align: middle;
        border-bottom: 1px solid #f3f3f3; font-size: 13px; color: #2d2d2d;
    }
    .table tbody tr:last-child td { border-bottom: none; }
    .table tbody tr { transition: background .15s; }
    .table tbody tr:hover { background: #f7fdfc; }

    .cell-no-req { font-weight: 700; color: #1a4a8a; font-size: 12.5px; }
    .cell-muted { color: #888; font-size: 12.5px; }
    .cell-primary { font-weight: 600; color: #1a1a2e; }

    .badge-layanan {
        display: inline-block; padding: 3px 10px;
        border-radius: 999px; font-size: 11.5px; font-weight: 600;
        background: #e8f4ff; color: #1a6fb5; white-space: nowrap;
    }

    /* ── BADGE STATUS ── */
    .badge-status {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 999px;
        font-size: 11.5px; font-weight: 700; letter-spacing: .3px;
        white-space: nowrap; cursor: pointer; border: none;
        transition: opacity .2s, transform .15s;
    }
    .badge-status:hover { opacity: .85; transform: translateY(-1px); }
    .badge-status .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
    .status-pending  { background: #fff8e1; color: #b8860b; }
    .status-pending .dot  { background: #f0ad00; }
    .status-diproses { background: #e8f0fe; color: #1a56db; }
    .status-diproses .dot { background: #3b82f6; }
    .status-selesai  { background: #e6f4ea; color: #1a7a3c; }
    .status-selesai .dot  { background: #22c55e; }


    /* ── STATUS DROPDOWN ── */
    .status-dropdown {
        position: fixed; z-index: 9999; background: #fff; border-radius: 12px;
        box-shadow: 0 8px 28px rgba(0,0,0,.13); padding: 6px 0; min-width: 148px;
        display: none; border: 1px solid #f0f0f0;
    }
    .status-dropdown.show { display: block; }
    .status-option {
        display: flex; align-items: center; gap: 8px; width: 100%; padding: 8px 14px;
        text-align: left; border: none; background: none;
        font-size: 13px; font-weight: 500; cursor: pointer; transition: background .15s; color: #333;
    }
    .status-option:hover { background: #f4fbfa; color: #005654; }
    .status-option .opt-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .status-wrapper { position: relative; display: inline-block; }

    /* ── ACTION BUTTONS ── */
    .btn-icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px; border-radius: 8px; border: none; background: transparent;
        transition: background .2s, color .2s, transform .15s; font-size: 15px; text-decoration: none; cursor: pointer;
    }
    .btn-icon-print { color: #1a6fb5; }
    .btn-icon-print:hover { background: #ddeeff; color: #0d4f8a; transform: translateY(-1px); }
    .btn-icon-edit { color: #b8860b; }
    .btn-icon-edit:hover { background: #fff3cd; color: #856404; transform: translateY(-1px); }
    .btn-icon-delete { color: #c0392b; }
    .btn-icon-delete:hover { background: #fde8e8; color: #922b21; transform: translateY(-1px); }

    .empty-state { padding: 60px 20px; text-align: center; color: #aaa; }
    .empty-state i { font-size: 48px; margin-bottom: 12px; display: block; color: #c8e6e5; }
    .empty-state p { font-size: 14px; margin: 0; }
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
        <a href="{{ route('permintaan.index') }}" class="sidebar-link active-page">
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
        <div class="topbar-title">Data Permintaan Layanan</div>
        <div class="topbar-sub">Sistem Informasi Rekam Medis</div>
    </div>

    <div class="container-fluid px-4 px-md-5 py-4">

        <!-- Filter bar -->
        <div class="filter-bar mb-4">
            <form method="GET" action="{{ url('/permintaan') }}"
                  class="d-flex align-items-center gap-2 flex-wrap w-100">

                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data...">
                </div>

                <select name="layanan" id="filterLayanan" class="filter-select">
                    <option value="">Semua Layanan</option>
                    @foreach($layanans as $lay)
                        <option value="{{ $lay->nama_layanan }}"
                            {{ request('layanan') == $lay->nama_layanan ? 'selected' : '' }}>
                            {{ $lay->nama_layanan }}
                        </option>
                    @endforeach
                </select>

                <div class="date-wrap">
                    @if(!request('tanggal'))<span class="date-placeholder">Tgl. Pengajuan</span>@endif
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                           style="{{ !request('tanggal') ? 'color:transparent;' : '' }}"
                           onfocus="this.style.color=''; this.previousElementSibling && (this.previousElementSibling.style.display='none')"
                           onblur="if(!this.value){ this.style.color='transparent'; this.previousElementSibling && (this.previousElementSibling.style.display='') }">
                </div>

                <div class="date-wrap">
                    @if(!request('tgl_dibuat'))<span class="date-placeholder">Tgl. Dibuat</span>@endif
                    <input type="date" name="tgl_dibuat" value="{{ request('tgl_dibuat') }}"
                           style="{{ !request('tgl_dibuat') ? 'color:transparent;' : '' }}"
                           onfocus="this.style.color=''; this.previousElementSibling && (this.previousElementSibling.style.display='none')"
                           onblur="if(!this.value){ this.style.color='transparent'; this.previousElementSibling && (this.previousElementSibling.style.display='') }">
                </div>

                <button type="submit" class="btn-search"><i class="bi bi-search"></i> Cari</button>

                @if(request('search') || request('layanan') || request('tanggal') || request('tgl_dibuat'))
                    <a href="{{ url('/permintaan') }}" class="btn-reset"><i class="bi bi-x-circle"></i> Reset</a>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle" style="min-width:1200px;">
                    <thead>
                        <tr>
                            <th>No Permintaan</th>
                            <th>Tgl. Pengajuan</th>
                            <th>User Pengaju</th>
                            <th>Kode RM</th>
                            <th>Nama Pasien</th>
                            <th>No Telepon</th>
                            <th>Layanan</th>
                            <th class="text-center">Status</th>
                            <th>Tgl. Dibuat</th>
                            <th>Nm. Penerima</th>
                            <th>Nm. Petugas RM</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $row)
                        @php
                            $statusMap = ['pending'=>'Pending','diproses'=>'Diproses','selesai'=>'Selesai'];
                            $s = $row->status ?? 'pending';
                            $dotColors = ['pending'=>'#f0ad00','diproses'=>'#3b82f6','selesai'=>'#22c55e'];
                        @endphp
                        <tr>
                            <td class="cell-no-req">{{ $row->no_permintaan }}</td>
                            <td class="cell-muted">
                                {{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}
                                <div style="font-size:11px;color:#bbb;">{{ \Carbon\Carbon::parse($row->tanggal)->format('H:i') }}</div>
                            </td>
                            <td class="cell-primary">{{ $row->user ? $row->user->name : '-' }}</td>
                            <td class="cell-primary">{{ $row->kode_rm }}</td>
                            <td class="cell-primary">{{ $row->nama }}</td>
                            <td class="cell-muted">{{ $row->no_telepon ?? '-' }}</td>
                            <td><span class="badge-layanan">{{ $row->layanan }}</span></td>
                            <td class="text-center">
                                <div class="status-wrapper" id="sw-{{ $row->id }}">
                                    <button class="badge-status status-{{ $s }}"
                                            onclick="toggleDropdown({{ $row->id }}, event)">
                                        <span class="dot"></span>
                                        {{ $statusMap[$s] ?? $s }}
                                        <i class="bi bi-chevron-down" style="font-size:9px; margin-left:2px;"></i>
                                    </button>
                                    <div class="status-dropdown" id="dd-{{ $row->id }}">
                                        @foreach($statusMap as $val => $label)
                                            <button class="status-option"
                                                    onclick="updateStatus({{ $row->id }}, '{{ $val }}')">
                                                <span class="opt-dot" style="background:{{ $dotColors[$val] ?? '#aaa' }};"></span>
                                                {{ $label }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                            <td class="cell-muted" id="tgl-dibuat-{{ $row->id }}">
                                @if($row->tgl_dibuat)
                                    {{ \Carbon\Carbon::parse($row->tgl_dibuat)->format('d/m/Y') }}
                                    <div style="font-size:11px;color:#bbb;">{{ \Carbon\Carbon::parse($row->tgl_dibuat)->format('H:i') }}</div>
                                @else
                                    <span style="color:#ccc;">—</span>
                                @endif
                            </td>
                            <td class="cell-muted">{{ $row->nm_penerima ?? '—' }}</td>
                            <td class="cell-muted">{{ $row->nm_petugas_rm ?? '—' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    @php
                                        $hasTemplate = !$row->is_lain_lain && !empty($layananTemplateMap[$row->layanan] ?? null);
                                    @endphp

                                    {{-- Cetak: hanya tampil jika ada template --}}
                                    @if($hasTemplate)
                                    <a href="{{ route('permintaan.cetak', $row->id) }}"
                                       class="btn-icon btn-icon-print" target="_blank" title="Cetak">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                    @else
                                    {{-- Download file jika sudah diupload --}}
                                    @if($row->file_surat)
                                    <button class="btn-icon btn-icon-print" title="Lihat Surat"
                                            onclick="previewSurat('{{ asset('storage/' . $row->file_surat) }}')">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </button>
                                    @endif
                                    @endif

                                    {{-- Edit: hanya untuk layanan dengan template --}}
                                    @if($hasTemplate)
                                    <a href="{{ route('permintaan.edit', $row->id) }}"
                                       class="btn-icon btn-icon-edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @else
                                    {{-- Upload: untuk layanan tanpa template --}}
                                    <button class="btn-icon btn-icon-edit" title="Upload Surat"
                                            onclick="openUpload({{ $row->id }}, '{{ $row->no_permintaan }}')">
                                        <i class="bi bi-upload"></i>
                                    </button>
                                    @endif

                                    <form action="{{ route('permintaan.destroy', $row->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-delete" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>Belum ada data permintaan layanan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($data->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $data->links() }}
            </div>
        @endif

    </div>
</div>

<!-- Modal Upload Surat -->
<div class="modal fade" id="modalUpload" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; border:none;">
            <div class="modal-header" style="background:#005654; border-radius:16px 16px 0 0; padding:18px 24px;">
                <h6 class="modal-title text-white fw-700 mb-0" style="font-weight:700;">
                    <i class="bi bi-upload me-2"></i>Upload Surat
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formUpload" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted mb-3" style="font-size:13px;">
                        No. Permintaan: <strong id="uploadNoReq"></strong>
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-600" style="font-size:13px; font-weight:600;">File Surat (PDF, maks. 5MB)</label>
                        <input type="file" name="file_surat" class="form-control" accept=".pdf" required
                               style="border-radius:10px; border:1.5px solid #dde6e5; font-size:13px;">
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f0f0f0; padding:14px 24px;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                            style="border-radius:10px; font-size:13px; font-weight:600;">Batal</button>
                    <button type="submit" class="btn text-white fw-bold"
                            style="background:#005654; border-radius:10px; font-size:13px; font-weight:700;">
                        <i class="bi bi-upload me-1"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openUpload(id, noReq) {
        document.getElementById('uploadNoReq').textContent = noReq;
        document.getElementById('formUpload').action = `/permintaan/${id}/upload`;
        new bootstrap.Modal(document.getElementById('modalUpload')).show();
    }

    function previewSurat(url) {
        const win = window.open(url, '_blank');
        win.onload = function() { win.print(); };
    }
</script>

<script>
    function toggleSidebarDropdown(btn) {
        const dropdown = btn.closest('.sidebar-dropdown');
        dropdown.classList.toggle('open');
    }
    // Auto-open if any sublink is active
    document.querySelectorAll('.sidebar-sublink.active').forEach(el => {
        el.closest('.sidebar-dropdown')?.classList.add('open');
    });



    const statusLabel = { pending: 'Pending', diproses: 'Diproses', selesai: 'Selesai' };
    const dotColors   = { pending: '#f0ad00', diproses: '#3b82f6', selesai: '#22c55e' };

    function toggleDropdown(id, e) {
        e.stopPropagation();
        document.querySelectorAll('.status-dropdown').forEach(d => {
            if (d.id !== 'dd-' + id) d.classList.remove('show');
        });
        const dd  = document.getElementById('dd-' + id);
        const btn = e.currentTarget;
        const rect = btn.getBoundingClientRect();
        dd.style.top  = (rect.bottom + window.scrollY + 4) + 'px';
        dd.style.left = (rect.left  + window.scrollX) + 'px';
        dd.classList.toggle('show');
    }

    document.querySelectorAll('.status-dropdown').forEach(d => document.body.appendChild(d));
    document.addEventListener('click', () => {
        document.querySelectorAll('.status-dropdown').forEach(d => d.classList.remove('show'));
    });

    function updateStatus(id, status) {
        fetch(`/permintaan/${id}/status`, {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ status })
        })
        .then(r => r.json())
        .then(res => {
            if (!res.success) return;
            const btn = document.querySelector(`#sw-${id} .badge-status`);
            btn.className = `badge-status status-${res.status}`;
            btn.innerHTML = `<span class="dot"></span>${statusLabel[res.status]}<i class="bi bi-chevron-down" style="font-size:9px;margin-left:2px;"></i>`;
            document.getElementById('dd-' + id).classList.remove('show');
            const tglCell = document.getElementById('tgl-dibuat-' + id);
            if (tglCell && res.tgl_dibuat) tglCell.innerHTML = res.tgl_dibuat;
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#filterLayanan').select2({
            placeholder: 'Semua Layanan',
            allowClear: true,
            width: '200px'
        });
    });
</script>
</body>
</html>
