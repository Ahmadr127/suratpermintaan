<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/imagesicon.jpg') }}">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Status Permintaan</title>
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
    }

    /* ── TOP BAR ── */
    .top-bar { background: #005654; height: 36px; }

    /* ── HEADER ── */
    .main-header {
        background: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,.06);
        padding: 16px 0;
    }
    .main-logo { height: 45px; width: auto; }
    .main-title { font-size: 20px; font-weight: 800; color: #005654; line-height: 1.1; }
    .sub-title { font-size: 12px; color: #6b8f8a; font-weight: 500; }
    .header-actions { display: flex; align-items: center; gap: 16px; }
    .user-info {
        display: flex; align-items: center; gap: 8px;
        padding: 8px 16px; background: #f0f9f8;
        border-radius: 10px; color: #005654;
        font-weight: 600; font-size: 14px;
    }
    .user-info i { font-size: 18px; }
    .btn-nav {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 14px; border-radius: 12px;
        font-size: 13px; font-weight: 500;
        text-decoration: none; transition: all .2s;
        border: 1px solid #d0d0d0; color: #555; background: transparent;
    }
    .btn-nav:hover {
        border-color: #005654; color: #005654;
        background: #f0f9f8; transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,86,84,.1);
    }
    .btn-nav.active { background: #005654; color: #fff; border-color: #005654; font-weight: 600; }
    .btn-nav.active:hover { background: #007a77; border-color: #007a77; }
    .divider-v { width: 1px; height: 28px; background: #d8d8d8; margin: 0 4px; }
    .btn-logout { padding: 8px 14px; font-weight: 600; border-radius: 10px; transition: all .2s; }
    .btn-logout:hover { transform: translateY(-1px); box-shadow: 0 4px 8px rgba(220,53,69,.3); }

    /* ── FILTER BAR ── */
    .filter-bar {
        background: #fff;
        border-radius: 14px;
        padding: 16px 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,.05);
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    }
    .search-wrap { position: relative; }
    .search-wrap .bi-search {
        position: absolute; left: 12px; top: 50%;
        transform: translateY(-50%); color: #aaa; font-size: 14px;
        pointer-events: none;
    }
    .search-wrap input {
        padding-left: 36px; border-radius: 10px;
        border: 1.5px solid #d0e8e7; height: 38px;
        font-size: 13.5px; width: 240px;
        transition: border-color .2s, box-shadow .2s;
    }
    .search-wrap input:focus {
        border-color: #005654;
        box-shadow: 0 0 0 3px rgba(0,86,84,.1);
        outline: none;
    }
    .date-wrap { position: relative; display: inline-flex; align-items: center; }
    .date-wrap .date-placeholder {
        position: absolute; left: 12px; color: #aaa;
        font-size: 13px; pointer-events: none; white-space: nowrap;
    }
    .date-wrap input[type="date"] {
        border-radius: 10px; border: 1.5px solid #d0e8e7;
        height: 38px; font-size: 13.5px; width: 170px;
        padding: 0 12px; transition: border-color .2s, box-shadow .2s;
    }
    .date-wrap input[type="date"]:focus {
        border-color: #005654;
        box-shadow: 0 0 0 3px rgba(0,86,84,.1);
        outline: none;
    }
    .btn-search {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 18px; background: #005654; color: #fff;
        font-size: 13.5px; font-weight: 600; border-radius: 10px;
        border: none; cursor: pointer; transition: background .2s, transform .15s;
    }
    .btn-search:hover { background: #007a77; transform: translateY(-1px); }
    .btn-reset {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 14px; border-radius: 10px;
        font-size: 13.5px; font-weight: 500;
        border: 1.5px solid #d0d0d0; color: #666;
        background: #fff; text-decoration: none;
        transition: all .2s;
    }
    .btn-reset:hover { border-color: #005654; color: #005654; background: #f0f9f8; }

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
    .select2-results__options { max-height: 220px; overflow-y: auto; }
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

    /* ── TABLE CARD ── */
    .table-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,.06);
        overflow: hidden;
    }
    .table-scroll-wrap {
        overflow-x: auto;
        overflow-y: auto;
        max-height: 520px;
    }
    .table-scroll-wrap::-webkit-scrollbar { height: 8px; width: 8px; }
    .table-scroll-wrap::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    .table-scroll-wrap::-webkit-scrollbar-thumb { background: #b0cece; border-radius: 4px; }
    .table-scroll-wrap::-webkit-scrollbar-thumb:hover { background: #005654; }
    .table { margin-bottom: 0; }
    .table thead th {
        background: #005654; color: #fff;
        font-size: 12px; font-weight: 600;
        letter-spacing: .4px; text-transform: uppercase;
        padding: 14px 18px; border: none;
        white-space: nowrap;
    }
    .table thead th:first-child { border-radius: 0; }
    .table tbody td {
        padding: 14px 18px;
        vertical-align: middle;
        border-bottom: 1px solid #f3f3f3;
        font-size: 13.5px; color: #2d2d2d;
    }
    .table tbody tr:last-child td { border-bottom: none; }
    .table tbody tr { transition: background .15s; }
    .table tbody tr:hover { background: #f7fdfc; }

    /* ── CELLS ── */
    .cell-no-req { font-weight: 700; color: #1a4a8a; font-size: 13px; }
    .cell-muted { color: #888; font-size: 13px; }

    /* ── BADGE LAYANAN ── */
    .badge-layanan {
        display: inline-block; padding: 4px 12px;
        border-radius: 999px; font-size: 12px; font-weight: 600;
        background: #e8f4ff; color: #1a6fb5; white-space: nowrap;
    }

    /* ── BADGE STATUS ── */
    .badge-status {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 999px;
        font-size: 12px; font-weight: 700; letter-spacing: .3px;
        white-space: nowrap;
    }
    .badge-status .dot {
        width: 6px; height: 6px; border-radius: 50%;
        display: inline-block; flex-shrink: 0;
    }
    .status-pending  { background: #fff8e1; color: #b8860b; }
    .status-pending .dot  { background: #f0ad00; }
    .status-proses   { background: #e8f0fe; color: #1a56db; }
    .status-proses .dot   { background: #3b82f6; }
    .status-selesai  { background: #e6f4ea; color: #1a7a3c; }
    .status-selesai .dot  { background: #22c55e; }

    /* ── ACTION BUTTONS ── */
    .btn-action {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 14px; border-radius: 8px;
        font-size: 12.5px; font-weight: 600;
        text-decoration: none; border: none; cursor: pointer;
        transition: all .2s; white-space: nowrap;
    }
    .btn-detail {
        background: #e8f4ff; color: #1a6fb5;
    }
    .btn-detail:hover { background: #cce4ff; color: #0d4f8a; transform: translateY(-1px); }
    .btn-dl {
        background: #005654; color: #fff;
    }
    .btn-dl:hover { background: #007a77; color: #fff; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(0,86,84,.2); }
    .btn-preview {
        background: #e8f4ff; color: #1a6fb5;
    }
    .btn-preview:hover { background: #cce4ff; color: #0d4f8a; transform: translateY(-1px); }

    .btn-disabled {
        background: #f0f0f0; color: #aaa; cursor: not-allowed;
    }
    .btn-bukti {
        background: #fff8e1; color: #8a6000;
    }
    .btn-bukti:hover { background: #ffeea0; color: #6b4a00; transform: translateY(-1px); }
    .empty-state {
        padding: 60px 20px; text-align: center; color: #aaa;
    }
    .empty-state i { font-size: 48px; margin-bottom: 12px; display: block; color: #c8e6e5; }
    .empty-state p { font-size: 14px; margin: 0; }

    /* ── PAGINATION ── */
    .pagination .page-link {
        border-radius: 8px; margin: 0 2px;
        border: 1.5px solid #d0e8e7; color: #005654;
        font-size: 13px; font-weight: 500;
    }
    .pagination .page-item.active .page-link {
        background: #005654; border-color: #005654; color: #fff;
    }
    .pagination .page-link:hover { background: #f0f9f8; }
</style>
</head>
<body>

<div class="top-bar"></div>

<!-- HEADER -->
<div class="main-header">
    <div class="container-fluid px-5 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <img src="{{ asset('assets/logo.png') }}" class="main-logo" alt="Logo">
            <div>
                <div class="main-title">Layanan Pasien</div>
                <div class="sub-title">Sistem Informasi Rekam Medis</div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('layanan.index') }}" class="btn-nav"><i class="bi bi-plus-circle me-1"></i> Ajukan Layanan</a>
            <a href="{{ route('user.permintaan') }}" class="btn-nav active"><i class="bi bi-list-check me-1"></i> History Permintaan</a>
            <div class="divider-v"></div>
            <div class="user-info">
                <i class="bi bi-person-circle"></i>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-logout">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="container-fluid px-4 px-md-5 py-4">

    <!-- Filter bar -->
    <div class="filter-bar mb-4">
        <form method="GET" action="{{ route('user.permintaan') }}"
              class="d-flex align-items-center gap-2 flex-wrap w-100">

            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari no, nama...">
            </div>

            <select name="layanan" id="filterLayanan" class="form-select" style="width:200px; height:38px; border-radius:10px; border:1.5px solid #d0e8e7; font-size:13.5px;">
                <option value="">-- Semua Layanan --</option>
                @foreach($layanans as $layanan)
                    <option value="{{ $layanan->nama_layanan }}"
                        {{ request('layanan') == $layanan->nama_layanan ? 'selected' : '' }}>
                        {{ $layanan->nama_layanan }}
                    </option>
                @endforeach
            </select>

            <div class="date-wrap">
                @if(!request('tgl_pengajuan'))
                    <span class="date-placeholder">Tgl. Pengajuan</span>
                @endif
                <input type="date" name="tgl_pengajuan" value="{{ request('tgl_pengajuan') }}"
                       style="{{ !request('tgl_pengajuan') ? 'color:transparent;' : '' }}"
                       onfocus="this.style.color=''; this.previousElementSibling && (this.previousElementSibling.style.display='none')"
                       onblur="if(!this.value){ this.style.color='transparent'; this.previousElementSibling && (this.previousElementSibling.style.display='') }">
            </div>

            <div class="date-wrap">
                @if(!request('tgl_dibuat'))
                    <span class="date-placeholder">Tgl. Dibuat</span>
                @endif
                <input type="date" name="tgl_dibuat" value="{{ request('tgl_dibuat') }}"
                       style="{{ !request('tgl_dibuat') ? 'color:transparent;' : '' }}"
                       onfocus="this.style.color=''; this.previousElementSibling && (this.previousElementSibling.style.display='none')"
                       onblur="if(!this.value){ this.style.color='transparent'; this.previousElementSibling && (this.previousElementSibling.style.display='') }">
            </div>

            <button type="submit" class="btn-search">
                <i class="bi bi-search"></i> Cari
            </button>

            @if(request('search') || request('layanan') || request('tgl_pengajuan') || request('tgl_dibuat'))
                <a href="{{ route('user.permintaan') }}" class="btn-reset">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
            @endif

        </form>
    </div>

    <!-- Table -->
    <div class="table-card">
        <div class="table-scroll-wrap">
            <table class="table table-hover align-middle" style="min-width:900px; margin-bottom:0;">
                <thead>
                    <tr style="position:sticky; top:0; z-index:2;">
                        <th class="text-center" style="width:48px;">No</th>
                        <th>No Permintaan</th>
                        <th>Nama Pasien</th>
                        <th>No Rekam Medis</th>
                        <th>Layanan</th>
                        <th>Tgl. Pengajuan</th>
                        <th class="text-center">Status</th>
                        <th>Tgl. Dibuat</th>
                        <th>Petugas RM</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($data as $row)
                    <tr>
                        <td class="text-center cell-muted">{{ $loop->iteration }}</td>
                        <td class="cell-no-req">{{ $row->no_permintaan }}</td>
                        <td>{{ $row->nama }}</td>
                        <td class="cell-muted">{{ $row->kode_rm }}</td>
                        <td>
                            <span class="badge-layanan">{{ $row->layanan }}</span>
                        </td>
                        <td class="cell-muted">
                            {{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}
                            <div style="font-size:11px; color:#bbb;">{{ \Carbon\Carbon::parse($row->tanggal)->format('H:i') }}</div>
                        </td>
                        <td class="text-center">
                            @php $s = $row->status ?? 'pending'; @endphp
                            <span class="badge-status status-{{ $s }}">
                                <span class="dot"></span>
                                {{ ['pending'=>'Pending','proses'=>'Diproses','selesai'=>'Selesai'][$s] ?? $s }}
                            </span>
                        </td>
                        <td class="cell-muted">
                            @if($row->tgl_dibuat)
                                {{ \Carbon\Carbon::parse($row->tgl_dibuat)->format('d/m/Y') }}
                                <div style="font-size:11px; color:#bbb;">{{ \Carbon\Carbon::parse($row->tgl_dibuat)->format('H:i') }}</div>
                            @else
                                <span style="color:#ccc;">—</span>
                            @endif
                        </td>
                        <td class="cell-muted">{{ $row->nm_petugas_rm ?? '—' }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <a href="{{ route('user.permintaan.show', $row->id) }}"
                                   class="btn-action btn-detail">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="{{ route('user.permintaan.bukti', $row->id) }}"
                                   class="btn-action btn-bukti" target="_blank" title="Cetak Bukti Pengajuan">
                                    <i class="bi bi-printer"></i> Bukti
                                </a>
                                @if($row->status == 'selesai')
                                    <a href="{{ route('user.permintaan.preview', $row->id) }}"
                                       target="_blank" rel="noopener noreferrer"
                                       class="btn-action btn-preview">
                                        <i class="bi bi-eye-fill"></i> Preview
                                    </a>
                                    <a href="{{ route('user.permintaan.download', $row->id) }}"
                                       class="btn-action btn-dl">
                                        <i class="bi bi-download"></i> Unduh
                                    </a>
                                @else
                                    <span class="btn-action btn-disabled">
                                        <i class="bi bi-clock"></i> Menunggu
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>Belum ada permintaan layanan yang diajukan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(method_exists($data, 'links'))
        <div class="d-flex justify-content-end mt-3">
            {{ $data->links() }}
        </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#filterLayanan').select2({
            placeholder: '— Semua Layanan —',
            allowClear: true,
            width: 'resolve',
            dropdownAutoWidth: true,
        });
    });
</script>
</body>
</html>
