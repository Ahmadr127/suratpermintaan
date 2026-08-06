<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/imagesicon.jpg') }}">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Permintaan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; }
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #e6f7f6, #f4fbfa);
        min-height: 100vh;
    }
    .top-bar { background: #005654; height: 36px; }
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

    /* Detail card */
    .detail-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,.07);
        border: none;
        overflow: hidden;
    }
    .detail-header {
        background: linear-gradient(135deg, #005654, #007a77);
        padding: 28px 32px;
        color: #fff;
    }
    .detail-header .req-number {
        font-size: 13px; font-weight: 600;
        opacity: .8; letter-spacing: .5px;
        text-transform: uppercase;
    }
    .detail-header h5 {
        font-size: 22px; font-weight: 800; margin: 4px 0 0;
    }
    .detail-body { padding: 28px 32px; }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .info-item label {
        display: block;
        font-size: 11px; font-weight: 700;
        color: #6b8f8a; text-transform: uppercase;
        letter-spacing: .6px; margin-bottom: 4px;
    }
    .info-item .value {
        font-size: 15px; font-weight: 600; color: #1a1a2e;
    }
    .info-item .value.muted { color: #6c757d; font-weight: 400; }

    .badge-layanan {
        display: inline-block; padding: 5px 14px;
        border-radius: 999px; font-size: 13px; font-weight: 600;
        background: #ddf0ff; color: #0a5a8a;
    }
    .badge-status {
        display: inline-block; padding: 5px 14px;
        border-radius: 999px; font-size: 13px; font-weight: 700;
        letter-spacing: .3px;
    }
    .status-pending  { background: #fff3cd; color: #856404; }
    .status-proses   { background: #cfe2ff; color: #084298; }
    .status-selesai  { background: #d1e7dd; color: #0a3622; }

    .divider-h { border: none; border-top: 1px solid #f0f0f0; margin: 24px 0; }

    .btn-back {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 20px; border-radius: 10px;
        font-size: 14px; font-weight: 600;
        text-decoration: none; transition: all .2s;
        border: 1.5px solid #d0e8e7; color: #005654; background: #fff;
    }
    .btn-back:hover {
        background: #f0f9f8; border-color: #005654;
        transform: translateY(-1px); box-shadow: 0 4px 10px rgba(0,86,84,.1);
    }
    .btn-download-main {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 24px; border-radius: 10px;
        font-size: 14px; font-weight: 700;
        text-decoration: none; transition: all .2s;
        background: #005654; color: #fff; border: none;
    }
    .btn-download-main:hover {
        background: #007a77; color: #fff;
        transform: translateY(-1px); box-shadow: 0 6px 16px rgba(0,86,84,.25);
    }
    .btn-download-main i { font-size: 16px; }

    .status-timeline {
        display: flex; align-items: center; gap: 0;
        margin: 20px 0 0;
    }
    .step {
        display: flex; flex-direction: column; align-items: center;
        flex: 1; position: relative;
    }
    .step:not(:last-child)::after {
        content: '';
        position: absolute; top: 14px; left: 50%;
        width: 100%; height: 2px;
        background: #e0e0e0; z-index: 0;
    }
    .step.done:not(:last-child)::after { background: #005654; }
    .step-dot {
        width: 28px; height: 28px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700; z-index: 1;
        border: 2px solid #e0e0e0; background: #fff; color: #aaa;
    }
    .step.done .step-dot { background: #005654; border-color: #005654; color: #fff; }
    .step.active .step-dot { background: #fff; border-color: #005654; color: #005654; }
    .step-label { font-size: 11px; font-weight: 600; color: #aaa; margin-top: 6px; text-align: center; }
    .step.done .step-label, .step.active .step-label { color: #005654; }
</style>
</head>
<body>

<div class="top-bar"></div>

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
            <div class="user-info"><i class="bi bi-person-circle"></i> <span>{{ auth()->user()->name }}</span></div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-logout"><i class="bi bi-box-arrow-right"></i></button>
            </form>
        </div>
    </div>
</div>

<div class="container py-5" style="max-width: 720px;">

    <div class="detail-card">

        <!-- Header -->
        <div class="detail-header">
            <div class="req-number"><i class="bi bi-hash"></i> No. Permintaan</div>
            <h5>{{ $data->no_permintaan }}</h5>
        </div>

        <div class="detail-body">

            <!-- Status Timeline -->
            @php
                $steps = ['pending', 'proses', 'selesai'];
                $currentIdx = array_search($data->status, $steps);
                if ($currentIdx === false) $currentIdx = -1;
            @endphp
            <div class="status-timeline">
                @foreach(['pending' => 'Pending', 'proses' => 'Diproses', 'selesai' => 'Selesai'] as $key => $label)
                    @php
                        $idx = array_search($key, $steps);
                        $cls = $idx < $currentIdx ? 'done' : ($idx == $currentIdx ? 'active done' : '');
                    @endphp
                    <div class="step {{ $cls }}">
                        <div class="step-dot">
                            @if($idx <= $currentIdx)
                                <i class="bi bi-check2"></i>
                            @else
                                {{ $idx + 1 }}
                            @endif
                        </div>
                        <div class="step-label">{{ $label }}</div>
                    </div>
                @endforeach
            </div>

            <hr class="divider-h">

            <!-- Info Grid -->
            <div class="info-grid">
                <div class="info-item">
                    <label>Nama Pasien</label>
                    <div class="value">{{ $data->nama }}</div>
                </div>
                <div class="info-item">
                    <label>No. Rekam Medis</label>
                    <div class="value">{{ $data->kode_rm }}</div>
                </div>
                <div class="info-item">
                    <label>Jenis Layanan</label>
                    <div class="value">
                        <span class="badge-layanan">{{ $data->layanan }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <label>Status</label>
                    <div class="value">
                        @php $s = $data->status ?? 'pending'; @endphp
                        <span class="badge-status status-{{ $s }}">
                            {{ ['pending'=>'Pending','proses'=>'Diproses','selesai'=>'Selesai'][$s] ?? $s }}
                        </span>
                    </div>
                </div>
                <div class="info-item">
                    <label>Tgl. Pengajuan</label>
                    <div class="value">{{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y, H:i') }}</div>
                </div>
                <div class="info-item">
                    <label>Tgl. Selesai</label>
                    <div class="value {{ !$data->tgl_dibuat ? 'muted' : '' }}">
                        {{ $data->tgl_dibuat ? \Carbon\Carbon::parse($data->tgl_dibuat)->format('d M Y, H:i') : 'Belum selesai' }}
                    </div>
                </div>
                <div class="info-item">
                    <label>Petugas RM</label>
                    <div class="value {{ !$data->nm_petugas_rm ? 'muted' : '' }}">
                        {{ $data->nm_petugas_rm ?? '-' }}
                    </div>
                </div>
                @if($data->nm_penerima)
                <div class="info-item">
                    <label>Nama Penerima</label>
                    <div class="value">{{ $data->nm_penerima }}</div>
                </div>
                @endif
            </div>

            <hr class="divider-h">

            <!-- Actions -->
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <a href="{{ route('user.permintaan') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                @if($data->status == 'selesai')
                    <div class="d-flex gap-2">
                        <a href="{{ route('user.permintaan.preview', $data->id) }}"
                           target="_blank" rel="noopener noreferrer"
                           class="btn-download-main" style="background:#1a6fb5;">
                            <i class="bi bi-eye-fill"></i> Preview
                        </a>
                        <a href="{{ route('user.permintaan.download', $data->id) }}"
                           class="btn-download-main">
                            <i class="bi bi-download"></i> Unduh Surat
                        </a>
                    </div>
                @else
                    <span class="text-muted" style="font-size:13px;">
                        <i class="bi bi-clock"></i> Surat tersedia setelah status selesai
                    </span>
                @endif
            </div>

        </div>
    </div>
</div>

</body>
</html>
