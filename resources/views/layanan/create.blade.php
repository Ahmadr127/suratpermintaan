<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/imagesicon.jpg') }}">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Entri Transaksi Korespondensi Pasien</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<style>
*, *::before, *::after { box-sizing: border-box; }
body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #e6f7f6, #f4fbfa); min-height: 100vh; }

/* TOP BAR */
.top-bar { background: #005654; height: 36px; }
.main-header { background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,.06); padding: 16px 0; }
.main-logo { height: 45px; width: auto; }
.main-title { font-size: 20px; font-weight: 800; color: #005654; line-height: 1.1; }
.sub-title { font-size: 12px; color: #6b8f8a; font-weight: 500; }
.header-actions { display: flex; align-items: center; gap: 16px; }
.btn-nav {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 14px; border-radius: 12px; font-size: 13px; font-weight: 500;
    text-decoration: none; border: 1px solid #d0d0d0; color: #555; background: transparent; transition: all .2s;
}
.btn-nav:hover { border-color: #005654; color: #005654; background: #f0f9f8; transform: translateY(-1px); box-shadow: 0 4px 8px rgba(0,86,84,.1); }
.btn-nav.active { background: #005654; color: #fff; border-color: #005654; font-weight: 600; }
.btn-nav.active:hover { background: #007a77; border-color: #007a77; }
.divider-v { width: 1px; height: 28px; background: #d8d8d8; margin: 0 4px; }
.user-info {
    display: flex; align-items: center; gap: 8px; padding: 8px 16px;
    background: #f0f9f8; border-radius: 10px; color: #005654; font-weight: 600; font-size: 14px;
}
.user-info i { font-size: 18px; }
.btn-logout { padding: 8px 14px; font-weight: 600; border-radius: 10px; transition: all .2s; }
.btn-logout:hover { transform: translateY(-1px); box-shadow: 0 4px 8px rgba(220,53,69,.3); }

/* WINDOW CHROME */
.win-wrapper { max-width: 900px; margin: 24px auto; }
.win-titlebar {
    background: linear-gradient(to right, #005654, #007a77);
    color: #fff; padding: 7px 14px;
    border-radius: 12px 12px 0 0;
    display: flex; align-items: center; justify-content: space-between;
    font-size: 13px; font-weight: 600;
}
.win-titlebar .win-btns { display: flex; gap: 5px; }
.win-btn { width: 13px; height: 13px; border-radius: 50%; border: 1px solid rgba(0,0,0,.15); cursor: pointer; }
.win-btn.close { background: #e05c5c; }
.win-btn.min   { background: #f0c040; }
.win-btn.max   { background: #5cb85c; }

.win-body {
    background: #f4fbfa;
    border: 1px solid #b8dbd9;
    border-top: none;
    border-radius: 0 0 12px 12px;
    padding: 0;
    box-shadow: 0 4px 20px rgba(0,86,84,.08);
}

/* TOP INFO BAR */
.info-bar {
    background: #e8f5f4;
    border-bottom: 1px solid #c8e6e4;
    padding: 7px 16px;
    display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
}
.info-bar-item { display: flex; align-items: center; gap: 6px; font-size: 12.5px; }
.info-bar-item label { font-weight: 600; color: #005654; white-space: nowrap; margin: 0; }
.info-bar-item .val-box {
    background: #fff; border: 1px solid #a8d0ce;
    border-radius: 6px; padding: 2px 10px;
    font-size: 12.5px; font-weight: 600; color: #1a2e2d;
    min-width: 140px;
}
.info-bar-item .val-box.new-badge {
    background: #fffbe6; color: #8a6000; border-color: #d4b000; font-style: italic;
}
.info-bar-item input[type="date"] {
    background: #fff; border: 1px solid #a8d0ce; border-radius: 6px;
    padding: 2px 8px; font-size: 12.5px; color: #1a2e2d;
}

/* FORM SECTIONS */
.form-section {
    background: #fff;
    border: 1px solid #c8e0de;
    border-radius: 8px;
    margin: 10px 14px;
}
.form-section-header {
    background: linear-gradient(to right, #e8f5f4, #f0f9f8);
    border-bottom: 1px solid #c8e0de;
    padding: 6px 14px;
    font-size: 12px; font-weight: 700; color: #005654;
    border-radius: 8px 8px 0 0;
}

/* FIELD ROWS */
.field-row {
    display: flex; align-items: center;
    padding: 5px 14px; gap: 8px;
    border-bottom: 1px solid #f0f7f6;
}
.field-row:last-child { border-bottom: none; }
.field-row label {
    font-size: 12px; font-weight: 600; color: #4a6a68;
    min-width: 130px; margin: 0; white-space: nowrap;
}
.field-row .field-input {
    flex: 1;
    background: #fafcfc; border: 1.5px solid #c8e0de;
    border-radius: 7px; padding: 4px 10px;
    font-size: 10px; color: #1a2e2d;
    transition: border-color .15s, box-shadow .15s;
}
.field-row .field-input:focus {
    border-color: #005654; outline: none;
    box-shadow: 0 0 0 3px rgba(0,86,84,.08);
    background: #fff;
}
.field-row .field-input::placeholder { color: rgba(0, 0, 0, 0.25); }
.field-row .field-input.short { max-width: 90px; }
.field-row .field-input.medium { max-width: 180px; }
.field-row .field-input.wide { max-width: 320px; }

/* INLINE PAIR */
.field-pair { display: flex; align-items: center; gap: 16px; flex: 1; }
.field-pair .sub-label { font-size: 12px; font-weight: 600; color: #4a6a68; white-space: nowrap; }

/* TABS */
.tab-bar {
    display: flex; gap: 0;
    padding: 10px 14px 0;
    border-bottom: 2px solid #c8e0de;
}
.tab-btn {
    padding: 5px 20px; font-size: 12.5px; font-weight: 600;
    border: 1.5px solid #c8e0de; border-bottom: none;
    background: #e8f5f4; color: #4a6a68;
    cursor: pointer; border-radius: 8px 8px 0 0;
    margin-right: 3px; transition: background .15s;
}
.tab-btn.active { background: #fff; color: #005654; border-color: #c8e0de; border-bottom: 2px solid #fff; margin-bottom: -2px; }
.tab-content { display: none; }
.tab-content.active { display: block; }

/* SELECT2 override */
.select2-container .select2-selection--single {
    height: 30px !important; border: 1.5px solid #c8e0de !important;
    border-radius: 7px !important; background: #fafcfc !important;
    display: flex; align-items: center; padding: 0 10px;
}
.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #005654 !important; box-shadow: 0 0 0 3px rgba(0,86,84,.08) !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 28px !important; font-size: 12.5px; color: #1a2e2d; padding: 0;
}
.select2-container--default .select2-selection--single .select2-selection__arrow { height: 28px !important; }
.select2-dropdown { border: 1.5px solid #c8e0de !important; border-radius: 8px !important; font-size: 12.5px; box-shadow: 0 8px 24px rgba(0,0,0,.1) !important; }
.select2-container--default .select2-results__option--highlighted { background: #005654 !important; }
.select2-search--dropdown .select2-search__field {
    border: 1.5px solid #c8e0de !important; border-radius: 6px !important;
    padding: 4px 8px; font-size: 12px; outline: none;
}
.select2-search--dropdown .select2-search__field:focus {
    border-color: #005654 !important; box-shadow: 0 0 0 2px rgba(0,86,84,.08);
}

/* BOTTOM ACTIONS */
.win-footer {
    background: #e8f5f4;
    border-top: 1px solid #c8e0de;
    padding: 10px 16px;
    display: flex; gap: 8px; align-items: center;
    border-radius: 0 0 12px 12px;
}
.btn-action {
    padding: 6px 20px; font-size: 12.5px; font-weight: 600;
    border-radius: 8px; border: 1.5px solid #c8e0de;
    background: #fff; color: #4a6a68; cursor: pointer; transition: all .15s;
    text-decoration: none; display: inline-flex; align-items: center; gap: 5px;
}
.btn-action:hover { border-color: #005654; color: #005654; background: #f0f9f8; }
.btn-action.primary { background: #005654; color: #fff; border-color: #005654; }
.btn-action.primary:hover { background: #007a77; box-shadow: 0 4px 12px rgba(0,86,84,.25); }

/* SEARCH ICON BUTTON */
.btn-search {
    background: #e8f5f4; border: 1.5px solid #c8e0de;
    border-radius: 7px; padding: 3px 9px; cursor: pointer;
    font-size: 11px; color: #005654; transition: background .15s;
}
.btn-search:hover { background: #d0eeec; }
.dokter-item:hover { background: #f0f9f8 !important; }
.karyawan-item:hover { background: #f0f9f8 !important; }
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
            <a href="{{ route('layanan.index') }}" class="btn-nav active"><i class="bi bi-plus-circle me-1"></i> Ajukan Layanan</a>
            <a href="{{ route('user.permintaan') }}" class="btn-nav"><i class="bi bi-list-check me-1"></i> History Permintaan</a>
            <div class="divider-v"></div>
            <div class="user-info"><i class="bi bi-person-circle"></i> <span>{{ auth()->user()->name }}</span></div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-logout"><i class="bi bi-box-arrow-right"></i></button>
            </form>
        </div>
    </div>
</div>

<!-- ALERTS -->
<div class="win-wrapper">
    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-3" style="border-radius:6px; font-size:13px;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mb-3" style="border-radius:6px; font-size:13px;">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            @foreach($errors->all() as $e) {{ $e }}<br> @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('layanan.store') }}" id="mainForm">
    @csrf

    <!-- WINDOW -->
    <div class="win-titlebar">
        <span><i class="bi bi-file-earmark-text me-2"></i>Entri Transaksi Korespondensi Pasien</span>
        <div class="win-btns">
            <div class="win-btn close"></div>
            <div class="win-btn min"></div>
            <div class="win-btn max"></div>
        </div>
    </div>

    <div class="win-body">

        <!-- TOP INFO BAR -->
        <div class="info-bar">
            <div class="info-bar-item">
                <label>No. Bukti</label>
                <div class="val-box" id="noBuktiDisplay">KOR{{ date('ymd') }}{{ str_pad(rand(1,999), 3, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="info-bar-item">
                <div class="val-box new-badge">*** Data Baru</div>
            </div>
            <div class="info-bar-item ms-auto">
                <label>Tanggal Permintaan</label>
                <input type="date" name="tanggal_permintaan" value="{{ date('Y-m-d') }}" readonly style="background:#fff;">
            </div>
        </div>

        <!-- DATA PASIEN -->
        <div class="form-section mx-3 mt-3">
            <div class="form-section-header"><i class="bi bi-person-vcard me-1"></i>Data Pasien</div>

            <div class="field-row">
                <label>No. RM</label>
                <input type="text" name="kode_rm" id="kodeRm" class="field-input medium" placeholder="Cari No. RM..." value="{{ old('kode_rm') }}">
                <button type="button" class="btn-search" onclick="cariRM()"><i class="bi bi-search"></i></button>
                <div class="field-pair ms-3">
                    <span class="sub-label">Umur</span>
                    <input type="number" name="umur" id="umurInput" class="field-input short" placeholder="Thn" min="0" value="{{ old('umur') }}">
                </div>
            </div>

            <div class="field-row">
                <label>Nama Pasien</label>
                <input type="text" name="nama" id="namaInput" class="field-input wide" placeholder="Nama lengkap pasien" value="{{ old('nama') }}">
                <div class="field-pair ms-3">
                    <span class="sub-label">Jenis Kelamin</span>
                    <select name="jenis_kelamin" id="jenisKelaminInput" class="field-input medium">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin')=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin')=='Perempuan'?'selected':'' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="field-row">
                <label>Tempat/Tgl Lahir</label>
                <input type="text" name="tempat_lahir" class="field-input medium" placeholder="Kota lahir" value="{{ old('tempat_lahir') }}">
                <input type="date" name="tgl_lahir" class="field-input medium ms-2" value="{{ old('tgl_lahir') }}">
            </div>

            <div class="field-row">
                <label>Alamat</label>
                <input type="text" name="alamat" class="field-input" placeholder="Alamat lengkap pasien" value="{{ old('alamat') }}">
            </div>

            <div class="field-row">
                <label>No. Telp</label>
                <input type="tel" name="no_telepon" class="field-input medium" placeholder="No. Telepon" value="{{ old('no_telepon') }}">
                <div class="field-pair ms-3">
                    <span class="sub-label">HP</span>
                    <input type="tel" name="no_hp" class="field-input medium" placeholder="No. HP / WhatsApp" value="{{ old('no_hp') }}">
                </div>
            </div>
        </div>

        <!-- TABS -->
        <div class="px-3 mt-3">
            <div class="tab-bar">
                <button type="button" class="tab-btn active" onclick="switchTab('koresponden', this)">Koresponden</button>
            </div>

            <!-- TAB: KORESPONDEN -->
            <div id="tab-koresponden" class="tab-content active">
                <div class="form-section" style="border-top:none; border-radius:0 4px 4px 4px;">

                    <div class="field-row">
                        <label>Nama Penerima</label>
                        <input type="text" name="nm_penerima" id="nmPenerimaInput" class="field-input wide"
                            value="{{ old('nm_penerima', auth()->user()->name) }}" readonly
                            style="background:#f0f9f8; color:#005654; font-weight:600; cursor:default;">
                    </div>

                    <div class="field-row">
                        <label>Nama Petugas RM</label>
                        <input type="text" name="nm_petugas_rm" id="nmPetugasRmInput" class="field-input wide" placeholder="Nama petugas rekam medis" value="{{ old('nm_petugas_rm') }}" readonly style="cursor:pointer; background:#fafcfc;">
                        <button type="button" class="btn-search ms-1" onclick="bukaKaryawanModal()"><i class="bi bi-search"></i></button>
                    </div>

                    <div class="field-row">
                        <label>Layanan</label>
                        <select name="layanan" id="layananSelect" class="field-input" style="max-width:280px;" required>
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($kategoris as $kategori)
                                @if($kategori->layanans->count() > 0)
                                    <optgroup label="{{ $kategori->nama }}">
                                        @foreach($kategori->layanans as $layanan)
                                            <option value="{{ $layanan->nama_layanan }}" {{ old('layanan')==$layanan->nama_layanan?'selected':'' }}>
                                                {{ $layanan->nama_layanan }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            @endforeach
                            <option value="lain-lain" {{ old('layanan')=='lain-lain'?'selected':'' }}>Lain-lain</option>
                        </select>
                    </div>

                    <div class="field-row" style="align-items: flex-start;">
                        <label style="padding-top: 4px;">Keterangan</label>
                        <textarea name="keterangan" id="keteranganInput" class="field-input" placeholder="Keterangan tambahan" rows="3" style="resize: vertical;">{{ old('keterangan') }}</textarea>
                    </div>

                    <!-- Field Nama Suami (khusus surat kelahiran) -->
                    <div class="field-row field-nama-suami" style="display:none;">
                        <label>Nama Suami</label>
                        <input type="text" name="nama_suami" class="field-input wide" placeholder="Nama suami / ayah bayi" value="{{ old('nama_suami') }}">
                    </div>

                    <!-- Field Bangsa (khusus surat kelahiran) -->
                    <div class="field-row field-bangsa" style="display:none;">
                        <label>Bangsa</label>
                        <input type="text" name="bangsa" class="field-input medium" placeholder="Contoh: Indonesia" value="{{ old('bangsa') }}">
                    </div>

                    <!-- Field Nama Dokter (dikonfigurasi per layanan) -->
                    <div id="fieldNamaDokter" style="display:none;">
                        <div style="border-top: 2px solid #d0e0ec; margin: 6px 0;"></div>
                        <div class="field-row">
                            <label>Dokter</label>
                            <input type="text" name="nama_dokter" id="namaDokterInput" class="field-input wide" placeholder="Nama dokter" value="{{ old('nama_dokter') }}" readonly style="cursor:pointer; background:#fafcfc;">
                            <button type="button" class="btn-search ms-1" onclick="bukaDokterModal()"><i class="bi bi-search"></i></button>
                        </div>
                    </div>

                    <!-- Bagian Korespondensi Lanjutan -->
                    <div id="dokterSection" style="display:none;">
                        <div style="border-top: 2px solid #d0e0ec; margin: 6px 0;"></div>

                        <div class="field-row">
                            <label>Nama Peminta</label>
                            <input type="text" name="nama_peminta" class="field-input wide" placeholder="Nama peminta surat" value="{{ old('nama_peminta') }}">
                        </div>

                        <div class="field-row">
                            <label>Email</label>
                            <input type="email" name="email_peminta" class="field-input wide" placeholder="email@contoh.com" value="{{ old('email_peminta') }}">
                        </div>

                        <div class="field-row">
                            <label>No. Whatsapp</label>
                            <input type="tel" name="no_whatsapp" class="field-input medium" placeholder="08xxxxxxxxxx" value="{{ old('no_whatsapp') }}">
                        </div>

                        <div class="field-row">
                            <label>UP</label>
                            <input type="text" name="up" class="field-input wide" placeholder="Untuk perhatian / ditujukan kepada" value="{{ old('up') }}">
                        </div>

                        <div class="field-row">
                            <label>Jumlah Form Asuransi</label>
                            <input type="number" name="jumlah_form_asuransi" class="field-input short" placeholder="0" min="0" value="{{ old('jumlah_form_asuransi', 0) }}">
                        </div>

                        <div class="field-row">
                            <label>Tgl Rencana Kirim</label>
                            <input type="date" name="tgl_rencana_kirim" class="field-input medium" value="{{ old('tgl_rencana_kirim') }}">
                        </div>
                    </div>

                </div>
            </div>


        </div>

        <!-- FOOTER ACTIONS -->
        <div class="win-footer">
            <button type="submit" class="btn-action primary"><i class="bi bi-save me-1"></i>Simpan</button>
            <a href="{{ route('user.permintaan') }}" class="btn-action">Hapus</a>
            <a href="{{ route('user.permintaan') }}" class="btn-action">Browse</a>
            <a href="{{ route('user.permintaan') }}" class="btn-action">Lihat</a>
        </div>

    </div><!-- /win-body -->
    </form>
</div><!-- /win-wrapper -->

<!-- MODAL PILIH DOKTER -->
<div id="modalDokter" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,.45); align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:14px; width:480px; max-width:95vw; box-shadow:0 12px 40px rgba(0,0,0,.2); overflow:hidden;">
        <div style="background:linear-gradient(to right,#005654,#007a77); padding:12px 18px; display:flex; align-items:center; justify-content:space-between;">
            <span style="color:#fff; font-weight:700; font-size:14px;"><i class="bi bi-person-badge me-2"></i>Pilih Dokter</span>
            <button type="button" onclick="tutupDokterModal()" style="background:none; border:none; color:#fff; font-size:20px; line-height:1; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:12px 16px; border-bottom:1px solid #e0eeec;">
            <input type="text" id="searchDokterInput" oninput="filterDokter(this.value)"
                placeholder="Cari nama dokter..."
                style="width:100%; border:1.5px solid #c8e0de; border-radius:8px; padding:6px 12px; font-size:13px; outline:none;">
        </div>
        <div id="listDokter" style="max-height:320px; overflow-y:auto; padding:8px 0;">
            @foreach($doctors as $dokter)
            <div class="dokter-item" data-nama="{{ $dokter->nama_karyawan }}"
                onclick="pilihDokter('{{ $dokter->nama_karyawan }}')"
                style="padding:9px 18px; cursor:pointer; font-size:13px; display:flex; flex-direction:column; border-bottom:1px solid #f0f7f6; transition:background .12s;">
                <span style="font-weight:600; color:#1a2e2d;">{{ $dokter->nama_karyawan }}</span>
                <span style="font-size:11px; color:#6b8f8a;">{{ $dokter->posisi_pekerjaan }}</span>
            </div>
            @endforeach
            <div id="dokterEmptyState" style="display:none; padding:32px 18px; text-align:center; color:#aaa;">
                <i class="bi bi-search" style="font-size:28px; display:block; margin-bottom:8px; color:#c8e0de;"></i>
                <span style="font-size:13px;">Dokter tidak ditemukan</span>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PILIH PETUGAS RM -->
<div id="modalKaryawan" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,.45); align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:14px; width:480px; max-width:95vw; box-shadow:0 12px 40px rgba(0,0,0,.2); overflow:hidden;">
        <div style="background:linear-gradient(to right,#005654,#007a77); padding:12px 18px; display:flex; align-items:center; justify-content:space-between;">
            <span style="color:#fff; font-weight:700; font-size:14px;"><i class="bi bi-person-vcard me-2"></i>Pilih Petugas RM</span>
            <button type="button" onclick="tutupKaryawanModal()" style="background:none; border:none; color:#fff; font-size:20px; line-height:1; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:12px 16px; border-bottom:1px solid #e0eeec;">
            <input type="text" id="searchKaryawanInput" oninput="filterKaryawan(this.value)"
                placeholder="Cari nama karyawan..."
                style="width:100%; border:1.5px solid #c8e0de; border-radius:8px; padding:6px 12px; font-size:13px; outline:none;">
        </div>
        <div id="listKaryawan" style="max-height:320px; overflow-y:auto; padding:8px 0;">
            @foreach($karyawans as $kar)
            <div class="karyawan-item" data-nama="{{ $kar->nama_karyawan }}"
                onclick="pilihKaryawan('{{ $kar->nama_karyawan }}')"
                style="padding:9px 18px; cursor:pointer; font-size:13px; display:flex; flex-direction:column; border-bottom:1px solid #f0f7f6; transition:background .12s;">
                <span style="font-weight:600; color:#1a2e2d;">{{ $kar->nama_karyawan }}</span>
                <span style="font-size:11px; color:#6b8f8a;">{{ $kar->posisi_pekerjaan }}{{ $kar->unit ? ' — '.$kar->unit : '' }}</span>
            </div>
            @endforeach
            <div id="karyawanEmptyState" style="display:none; padding:32px 18px; text-align:center; color:#aaa;">
                <i class="bi bi-person-x" style="font-size:28px; display:block; margin-bottom:8px; color:#c8e0de;"></i>
                <span style="font-size:13px;">Karyawan tidak ditemukan</span>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
// Konfigurasi tampilan field per layanan dari server
const layananConfigMap = @json($layananConfigMap ?? []);

function switchTab(name, btn) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}

function cariRM() {
    var rm = document.getElementById('kodeRm').value.trim();
    if (!rm) { alert('Masukkan No. RM terlebih dahulu.'); return; }
    alert('Fitur pencarian RM: ' + rm);
}

function updateFieldVisibility(layananNama) {
    const config = layananConfigMap[layananNama] || {
        show_nama_dokter:    false,
        show_dokter_section: false,
        show_nama_suami:     false,
        show_bangsa:         false,
    };

    // Field nama dokter (independen, selalu tampil untuk lain-lain)
    document.getElementById('fieldNamaDokter').style.display =
        (config.show_nama_dokter || layananNama === 'lain-lain') ? 'block' : 'none';

    // Bagian korespondensi lanjutan (selalu tampil untuk lain-lain)
    document.getElementById('dokterSection').style.display =
        (config.show_dokter_section || layananNama === 'lain-lain') ? 'block' : 'none';

    // Field nama suami
    document.querySelectorAll('.field-nama-suami').forEach(el => {
        el.style.display = config.show_nama_suami ? 'flex' : 'none';
    });

    // Field bangsa
    document.querySelectorAll('.field-bangsa').forEach(el => {
        el.style.display = config.show_bangsa ? 'flex' : 'none';
    });
}

$(document).ready(function () {
    $('#layananSelect').select2({
        placeholder: '-- Pilih Layanan --',
        allowClear: false,
        width: '280px',
        language: {
            noResults: function () { return 'Layanan tidak ditemukan'; },
            searching: function () { return 'Mencari...'; }
        }
    });

    $('#layananSelect').on('change', function () {
        var val = $(this).val();

        // Keterangan placeholder
        if (val === 'lain-lain') {
            $('#keteranganInput').attr('placeholder', 'Nama layanan (baris 1)\nDeskripsi detail (baris 2, 3, dst...)');
            $('#keteranganInput').attr('required', true);
            $('.field-keterangan-lain').hide();
        } else {
            $('#keteranganInput').attr('placeholder', 'Keterangan tambahan');
            $('#keteranganInput').removeAttr('required');
            $('.field-keterangan-lain').hide();
        }

        // Update visibilitas field
        updateFieldVisibility(val);
    });

    // Inisialisasi saat halaman load (jika ada old value)
    var initialVal = $('#layananSelect').val();
    if (initialVal) {
        updateFieldVisibility(initialVal);
        if (initialVal === 'lain-lain') {
            $('#keteranganInput').attr('placeholder', 'Nama layanan (baris 1)\nDeskripsi detail (baris 2, 3, dst...)');
        }
    }

    $('#mainForm').on('submit', function (e) {
        if ($('#layananSelect').val() === 'lain-lain' && !$('#keteranganInput').val().trim()) {
            e.preventDefault();
            alert('Harap isi keterangan layanan terlebih dahulu.');
        }
    });
});

function bukaDokterModal() {
    document.getElementById('searchDokterInput').value = '';
    filterDokter('');
    const modal = document.getElementById('modalDokter');
    modal.style.display = 'flex';
    setTimeout(() => document.getElementById('searchDokterInput').focus(), 100);
}

function tutupDokterModal() {
    document.getElementById('modalDokter').style.display = 'none';
}

function pilihDokter(nama) {
    document.getElementById('namaDokterInput').value = nama;
    tutupDokterModal();
}

function filterDokter(q) {
    const keyword = q.toLowerCase();
    let visible = 0;
    document.querySelectorAll('.dokter-item').forEach(function(el) {
        const nama = el.getAttribute('data-nama').toLowerCase();
        const show = nama.includes(keyword);
        el.style.display = show ? 'flex' : 'none';
        if (show) visible++;
    });
    const empty = document.getElementById('dokterEmptyState');
    if (empty) empty.style.display = visible === 0 ? 'block' : 'none';
}

// Tutup modal saat klik backdrop
document.getElementById('modalDokter').addEventListener('click', function(e) {
    if (e.target === this) tutupDokterModal();
});

function bukaKaryawanModal() {
    document.getElementById('searchKaryawanInput').value = '';
    filterKaryawan('');
    const modal = document.getElementById('modalKaryawan');
    modal.style.display = 'flex';
    setTimeout(() => document.getElementById('searchKaryawanInput').focus(), 100);
}

function tutupKaryawanModal() {
    document.getElementById('modalKaryawan').style.display = 'none';
}

function pilihKaryawan(nama) {
    document.getElementById('nmPetugasRmInput').value = nama;
    tutupKaryawanModal();
}

function filterKaryawan(q) {
    const keyword = q.toLowerCase();
    let visible = 0;
    document.querySelectorAll('.karyawan-item').forEach(function(el) {
        const nama = el.getAttribute('data-nama').toLowerCase();
        const show = nama.includes(keyword);
        el.style.display = show ? 'flex' : 'none';
        if (show) visible++;
    });
    const empty = document.getElementById('karyawanEmptyState');
    if (empty) empty.style.display = visible === 0 ? 'block' : 'none';
}

document.getElementById('modalKaryawan').addEventListener('click', function(e) {
    if (e.target === this) tutupKaryawanModal();
});
</script>
</body>
</html>
