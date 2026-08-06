<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/imagesicon.jpg') }}">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Layanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    *, *::before, *::after { box-sizing: border-box; }
    body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #e6f7f6, #f4fbfa); min-height: 100vh; display: flex; margin: 0; overflow-x: hidden; }
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
    .btn-logout-sidebar { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 9px; border-radius: 10px; background: #7a2020; color: #fff; border: 1px solid #a03030; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .2s; }
    .btn-logout-sidebar:hover { background: #9b2828; }
    .sidebar-dropdown-toggle { background: none; border: none; text-align: left; width: 100%; }
    .sidebar-chevron { transition: transform .25s; font-size: 12px; }
    .sidebar-dropdown.open .sidebar-chevron { transform: rotate(180deg); }
    .sidebar-submenu { overflow: hidden; max-height: 0; transition: max-height .3s ease; }
    .sidebar-dropdown.open .sidebar-submenu { max-height: 200px; }
    .sidebar-sublink { display: flex; align-items: center; gap: 8px; padding: 8px 12px 8px 32px; border-radius: 8px; color: rgba(255,255,255,.65); font-size: 13px; font-weight: 500; text-decoration: none; transition: all .2s; margin-bottom: 1px; }
    .sidebar-sublink:hover { background: rgba(255,255,255,.1); color: #fff; }
    .sidebar-sublink.active { background: #6aaa30; color: #fff; font-weight: 600; }
    .main-wrapper { margin-left: 240px; flex: 1; min-height: 100vh; display: flex; flex-direction: column; overflow-x: hidden; min-width: 0; }
    .topbar { background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,.06); padding: 14px 28px; }
    .topbar-title { font-size: 18px; font-weight: 800; color: #005654; }
    .topbar-sub { font-size: 12px; color: #6b8f8a; }
    .form-card { background: #fff; border-radius: 18px; box-shadow: 0 8px 28px rgba(0,0,0,.07); padding: 32px 36px; margin-bottom: 24px; }
    .section-title { font-size: 15px; font-weight: 700; color: #005654; border-bottom: 2px solid #e0f0ef; padding-bottom: 8px; margin-bottom: 20px; }
    .form-label { font-weight: 600; font-size: 13px; color: #333; margin-bottom: 5px; }
    .form-label .text-muted { font-weight: 400; font-size: 11px; }
    .form-control, .form-select { border-radius: 10px; border: 1.5px solid #d0e8e7; font-size: 13px; transition: border-color .2s, box-shadow .2s; }
    .form-control:focus, .form-select:focus { border-color: #005654; box-shadow: 0 0 0 3px rgba(0,86,84,.1); outline: none; }
    .btn-simpan { display: flex; align-items: center; justify-content: center; gap: 6px; padding: 11px 28px; background: #005654; color: #fff; font-size: 14px; font-weight: 700; border-radius: 10px; border: none; cursor: pointer; transition: background .2s; }
    .btn-simpan:hover { background: #007a77; }
    .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px; border-radius: 10px; font-size: 13px; font-weight: 500; border: 1.5px solid #d0d0d0; color: #555; background: #fff; text-decoration: none; transition: all .2s; }
    .btn-back:hover { border-color: #005654; color: #005654; }
    /* Biodata row */
    .biodata-row { background: #f8fffe; border: 1.5px solid #d0e8e7; border-radius: 12px; padding: 14px 16px; margin-bottom: 10px; position: relative; }
    .btn-remove-row { position: absolute; top: 10px; right: 12px; background: none; border: none; color: #c0392b; font-size: 18px; cursor: pointer; line-height: 1; }
    .btn-add-row { display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; border: 1.5px dashed #005654; color: #005654; background: #f0f9f8; cursor: pointer; transition: all .2s; }
    .btn-add-row:hover { background: #e0f5f4; }
    .field-key-hint { font-size: 11px; color: #888; margin-top: 3px; }
    .placeholder-badge { display: inline-block; background: #e8f5e9; color: #2e7d32; border-radius: 6px; padding: 2px 8px; font-size: 11px; font-family: monospace; margin: 2px; cursor: pointer; }
    .placeholder-badge:hover { background: #c8e6c9; }
</style>
</head>
<body>
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
        <a href="{{ route('permintaan.index') }}" class="sidebar-link"><i class="bi bi-list-ul"></i> Permintaan</a>
        @if(auth()->user()->role === 'admin')
        <div class="sidebar-dropdown open">
            <button class="sidebar-link sidebar-dropdown-toggle w-100" onclick="toggleSidebarDropdown(this)">
                <i class="bi bi-gear-fill"></i><span>Master</span>
                <i class="bi bi-chevron-down sidebar-chevron ms-auto"></i>
            </button>
            <div class="sidebar-submenu">
                <a href="{{ route('master.kategori.index') }}" class="sidebar-sublink"><i class="bi bi-tags-fill"></i> Kategori</a>
                <a href="{{ route('master.layanan.index') }}" class="sidebar-sublink active"><i class="bi bi-file-earmark-text-fill"></i> Layanan</a>
            </div>
        </div>
        @endif
        @if(auth()->user()->role === 'admin')
        <div class="sidebar-dropdown">
            <button class="sidebar-link sidebar-dropdown-toggle w-100" onclick="toggleSidebarDropdown(this)">
                <i class="bi bi-people-fill"></i><span>Akun</span>
                <i class="bi bi-chevron-down sidebar-chevron ms-auto"></i>
            </button>
            <div class="sidebar-submenu">
                <a href="{{ route('master.user.index') }}?tab=user" class="sidebar-sublink"><i class="bi bi-person-fill"></i> Manajemen User</a>
                <a href="{{ route('master.user.index') }}?tab=role" class="sidebar-sublink"><i class="bi bi-shield-fill"></i> Manajemen Role</a>
                <a href="{{ route('master.user.index') }}?tab=karyawan" class="sidebar-sublink"><i class="bi bi-person-badge-fill"></i> Data Karyawan</a>
            </div>
        </div>
        @endif
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <i class="bi bi-person-circle"></i>
            <div><div class="name">{{ auth()->user()->name }}</div><div class="role">{{ ucfirst(auth()->user()->role) }}</div></div>
        </div>
        <form method="POST" action="{{ url('/logout') }}" class="m-0">
            @csrf
            <button type="submit" class="btn-logout-sidebar"><i class="bi bi-box-arrow-right"></i> Keluar</button>
        </form>
    </div>
</aside>

<div class="main-wrapper">
    <div class="topbar">
        <div class="topbar-title">Tambah Layanan</div>
        <div class="topbar-sub">Sistem Informasi Rekam Medis</div>
    </div>
    <div class="container-fluid px-4 px-md-5 py-4">
        <div class="mb-3">
            <a href="{{ route('master.layanan.index') }}" class="btn-back"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger" style="border-radius:10px; font-size:13px;">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="{{ route('master.layanan.store') }}">
        @csrf

        {{-- INFORMASI DASAR --}}
        <div class="form-card">
            <div class="section-title"><i class="bi bi-info-circle me-2"></i>Informasi Layanan</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_layanan" class="form-control" placeholder="Contoh: Surat Keterangan Rawat Inap" value="{{ old('nama_layanan') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategoriSelect" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Deskripsi <span class="text-muted">(opsional)</span></label>
                    <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi singkat layanan" value="{{ old('deskripsi') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Judul Surat (Indonesia)</label>
                    <input type="text" name="judul_surat" class="form-control" placeholder="SURAT KETERANGAN RAWAT INAP" value="{{ old('judul_surat') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Judul Surat (Inggris)</label>
                    <input type="text" name="judul_surat_en" class="form-control" placeholder="Inpatient Certificate" value="{{ old('judul_surat_en') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kalimat Pembuka (Indonesia) <span class="text-muted">— kosongkan jika tidak ada</span></label>
                    <textarea name="kalimat_pembuka" class="form-control" rows="2" placeholder="Yang bertanda tangan di bawah ini, dokter [[bold:Rumah Sakit Azra Bogor]], menerangkan bahwa:">{{ old('kalimat_pembuka') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Kalimat Pembuka (Inggris)</label>
                    <textarea name="kalimat_pembuka_en" class="form-control" rows="2" placeholder="The undersigned, the doctor of Azra Hospital Bogor, explained that:">{{ old('kalimat_pembuka_en') }}</textarea>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active" style="font-size:13px; font-weight:500;">Aktif</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="section-title mt-2" style="font-size:13px;"><i class="bi bi-toggles me-1"></i>Konfigurasi Field Tambahan di Form Pengajuan</div>
                    <div class="d-flex flex-wrap gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="show_dokter_section" id="show_dokter_section" value="1" {{ old('show_dokter_section') ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_dokter_section" style="font-size:13px; font-weight:500;">Tampilkan bagian Korespondensi (Nama Peminta, Email, dll)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="show_nama_dokter" id="show_nama_dokter" value="1" {{ old('show_nama_dokter', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_nama_dokter" style="font-size:13px; font-weight:500;">Tampilkan field Nama Dokter</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="show_nama_suami" id="show_nama_suami" value="1" {{ old('show_nama_suami') ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_nama_suami" style="font-size:13px; font-weight:500;">Tampilkan field Nama Suami</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="show_bangsa" id="show_bangsa" value="1" {{ old('show_bangsa') ? 'checked' : '' }}>
                            <label class="form-check-label" for="show_bangsa" style="font-size:13px; font-weight:500;">Tampilkan field Bangsa</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BIODATA FIELDS --}}
        <div class="form-card">
            <div class="section-title"><i class="bi bi-person-lines-fill me-2"></i>Kolom Biodata</div>
            <p class="text-muted" style="font-size:12.5px;">Tentukan kolom biodata yang tampil di surat. Urutan sesuai posisi di bawah.</p>

            <div id="biodata-container">
                <div class="biodata-row">
                    <button type="button" class="btn-remove-row" onclick="removeRow(this)" title="Hapus baris"><i class="bi bi-x-circle-fill"></i></button>
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="form-label">Label (ID)</label>
                            <input type="text" name="biodata_label[]" class="form-control" placeholder="Nama">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Label (EN)</label>
                            <input type="text" name="biodata_label_en[]" class="form-control" placeholder="Name">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Field Key</label>
                            <input type="text" name="biodata_field_key[]" class="form-control" placeholder="nama">
                            <div class="field-key-hint">Nama kolom di database</div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Suffix (ID)</label>
                            <input type="text" name="biodata_suffix[]" class="form-control" placeholder="Tahun">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Suffix (EN)</label>
                            <input type="text" name="biodata_suffix_en[]" class="form-control" placeholder="years old">
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-add-row mt-2" onclick="addBiodataRow()">
                <i class="bi bi-plus-circle"></i> Tambah Kolom Biodata
            </button>

            <div class="mt-3 p-3" style="background:#f8f9fa; border-radius:10px; font-size:12px;">
                <strong>Field key yang tersedia:</strong><br>
                <span class="placeholder-badge" onclick="copyText('nama')">nama</span>
                <span class="placeholder-badge" onclick="copyText('umur')">umur</span>
                <span class="placeholder-badge" onclick="copyText('bangsa')">bangsa</span>
                <span class="placeholder-badge" onclick="copyText('kode_rm')">kode_rm</span>
                <span class="placeholder-badge" onclick="copyText('alamat')">alamat</span>
                <span class="placeholder-badge" onclick="copyText('no_telepon')">no_telepon</span>
                <span class="placeholder-badge" onclick="copyText('diagnosis')">diagnosis</span>
                <span class="placeholder-badge" onclick="copyText('poliklinik')">poliklinik</span>
                <span class="placeholder-badge" onclick="copyText('tgl_masuk')">tgl_masuk</span>
                <span class="placeholder-badge" onclick="copyText('tgl_keluar')">tgl_keluar</span>
                <span class="placeholder-badge" onclick="copyText('tgl_periksa')">tgl_periksa</span>
                <span class="placeholder-badge" onclick="copyText('tgl_berobat')">tgl_berobat</span>
                <span class="placeholder-badge" onclick="copyText('usia_kehamilan_minggu')">usia_kehamilan_minggu</span>
                <span class="placeholder-badge" onclick="copyText('usia_kehamilan_hari')">usia_kehamilan_hari</span>
                <span class="placeholder-badge" onclick="copyText('no_surat_kelahiran')">no_surat_kelahiran</span>
                <span class="placeholder-badge" onclick="copyText('jenis_kelamin_bayi')">jenis_kelamin_bayi</span>
                <span class="placeholder-badge" onclick="copyText('tgl_lahir_bayi')">tgl_lahir_bayi</span>
                <span class="placeholder-badge" onclick="copyText('jam_lahir_bayi')">jam_lahir_bayi</span>
                <span class="placeholder-badge" onclick="copyText('nama_suami')">nama_suami</span>
                <span class="placeholder-badge" onclick="copyText('email_peminta')">email_peminta</span>
                <span class="placeholder-badge" onclick="copyText('no_whatsapp')">no_whatsapp</span>
                <span class="placeholder-badge" onclick="copyText('up')">up</span>
                <span class="placeholder-badge" onclick="copyText('jumlah_form_asuransi')">jumlah_form_asuransi</span>
                <span class="placeholder-badge" onclick="copyText('tgl_rencana_kirim')">tgl_rencana_kirim</span>
            </div>
        </div>

        {{-- ISI SURAT --}}
        <div class="form-card">
            <div class="section-title"><i class="bi bi-file-text me-2"></i>Isi Surat</div>
            <p class="text-muted" style="font-size:12.5px;">
                @verbatim
                Gunakan <code>{{field_key}}</code> untuk data dinamis.
                Format tanggal: <code>{{tgl_masuk|date:d F Y}}</code>.
                @endverbatim
                Format teks: <code>[[bold:teks]]</code>, <code>[[underline:teks]]</code>.
            </p>
            <div class="mb-3">
                <label class="form-label">Isi Surat (Indonesia)</label>
                <textarea name="isi_id" class="form-control" rows="5" placeholder="Adalah benar pasien [[bold:Rumah Sakit Azra Bogor]], yang dirawat pada tanggal [[bold:{&#123;tgl_masuk|date:d F Y&#125;}]] sampai [[bold:{&#123;tgl_keluar|date:d F Y&#125;}]], dengan diagnosis [[bold:{&#123;diagnosis&#125;}]].">{{ old('isi_id') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Isi Surat (Inggris) <span class="text-muted">(opsional)</span></label>
                <textarea name="isi_en" class="form-control" rows="5" placeholder="It is true that the patient of [[bold:Azra Hospital Bogor]], who was hospitalized from [[bold:{&#123;tgl_masuk|date_en:F d&#125;}]], with diagnosis [[bold:{&#123;diagnosis&#125;}]].">{{ old('isi_en') }}</textarea>
            </div>
        </div>

        {{-- KALIMAT PENUTUP --}}
        <div class="form-card">
            <div class="section-title"><i class="bi bi-chat-quote me-2"></i>Kalimat Penutup</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Penutup (Indonesia)</label>
                    <textarea name="kalimat_penutup" class="form-control" rows="2" placeholder="Demikianlah surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.">{{ old('kalimat_penutup') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penutup (Inggris)</label>
                    <textarea name="kalimat_penutup_en" class="form-control" rows="2" placeholder="Thus this statement was made so that those with an interest in understanding.">{{ old('kalimat_penutup_en') }}</textarea>
                </div>
            </div>
        </div>

        {{-- FOOTER / TTD --}}
        <div class="form-card">
            <div class="section-title"><i class="bi bi-pen me-2"></i>Footer / Tanda Tangan</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Label TTD Kiri (ID)</label>
                    <input type="text" name="ttd_kiri_label" class="form-control" placeholder="Dokter yang merawat," value="{{ old('ttd_kiri_label') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Label TTD Kiri (EN)</label>
                    <input type="text" name="ttd_kiri_label_en" class="form-control" placeholder="Attending Doctor," value="{{ old('ttd_kiri_label_en') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Label TTD Kanan (ID) <span class="text-muted">— kosongkan jika tidak ada</span></label>
                    <input type="text" name="ttd_kanan_label" class="form-control" placeholder="Menyetujui data kesehatan saya diberikan kepada pihak ketiga" value="{{ old('ttd_kanan_label') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Label TTD Kanan (EN)</label>
                    <input type="text" name="ttd_kanan_label_en" class="form-control" placeholder="Approving my health data given to third parties" value="{{ old('ttd_kanan_label_en') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">TTD Kanan diisi oleh</label>
                    <select name="ttd_kanan_sumber" class="form-select">
                        <option value="persetujuan" {{ old('ttd_kanan_sumber', 'persetujuan') === 'persetujuan' ? 'selected' : '' }}>Nama Persetujuan (diisi admin)</option>
                        <option value="dokter" {{ old('ttd_kanan_sumber') === 'dokter' ? 'selected' : '' }}>Nama Dokter (dari pengajuan)</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Posisi Tanggal</label>
                    <select name="ttd_tanggal_posisi" class="form-select">
                        <option value="">— Tidak tampilkan tanggal —</option>
                        <option value="kiri" {{ old('ttd_tanggal_posisi') === 'kiri' ? 'selected' : '' }}>Di atas TTD Kiri</option>
                        <option value="kanan" {{ old('ttd_tanggal_posisi') === 'kanan' ? 'selected' : '' }}>Di atas TTD Kanan</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="d-flex gap-3 mb-5">
            <button type="submit" class="btn-simpan"><i class="bi bi-save"></i> Simpan Layanan</button>
            <a href="{{ route('master.layanan.index') }}" class="btn-back">Batal</a>
        </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#kategoriSelect').select2({
        placeholder: '-- Pilih Kategori --',
        allowClear: true,
        width: '100%',
        language: {
            noResults: () => 'Kategori tidak ditemukan',
            searching: () => 'Mencari...'
        }
    });
});

function toggleSidebarDropdown(btn) {
    btn.closest('.sidebar-dropdown').classList.toggle('open');
}

function addBiodataRow() {
    const container = document.getElementById('biodata-container');
    const row = document.createElement('div');
    row.className = 'biodata-row';
    row.innerHTML = `
        <button type="button" class="btn-remove-row" onclick="removeRow(this)" title="Hapus baris"><i class="bi bi-x-circle-fill"></i></button>
        <div class="row g-2">
            <div class="col-md-3"><label class="form-label">Label (ID)</label><input type="text" name="biodata_label[]" class="form-control" placeholder="Nama"></div>
            <div class="col-md-3"><label class="form-label">Label (EN)</label><input type="text" name="biodata_label_en[]" class="form-control" placeholder="Name"></div>
            <div class="col-md-2"><label class="form-label">Field Key</label><input type="text" name="biodata_field_key[]" class="form-control" placeholder="nama"><div class="field-key-hint">Nama kolom di database</div></div>
            <div class="col-md-2"><label class="form-label">Suffix (ID)</label><input type="text" name="biodata_suffix[]" class="form-control" placeholder="Tahun"></div>
            <div class="col-md-2"><label class="form-label">Suffix (EN)</label><input type="text" name="biodata_suffix_en[]" class="form-control" placeholder="years old"></div>
            <div class="col-md-2 d-flex align-items-end pb-1">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="biodata_is_admin[]" value="1">
                    <label class="form-check-label" style="font-size:12px;">Diisi Admin</label>
                </div>
            </div>
        </div>`;
    container.appendChild(row);
}

function removeRow(btn) {
    const rows = document.querySelectorAll('.biodata-row');
    if (rows.length > 1) btn.closest('.biodata-row').remove();
}

function copyText(text) {
    navigator.clipboard.writeText(text).then(() => {
        const el = event.target;
        const orig = el.textContent;
        el.textContent = '✓ copied';
        setTimeout(() => el.textContent = orig, 1000);
    });
}
</script>
</body>
</html>
