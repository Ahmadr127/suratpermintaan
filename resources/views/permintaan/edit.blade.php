<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/imagesicon.jpg') }}">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Permintaan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
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

    /* SIDEBAR */
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

    /* SIDEBAR DROPDOWN */
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

    /* MAIN */
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

    .form-card {
        background: #fff; border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,.06);
        padding: 32px;
    }
    .section-title {
        font-size: 15px; font-weight: 700; color: #005654;
        margin-bottom: 16px; padding-bottom: 8px;
        border-bottom: 2px solid #e6f7f6;
    }
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
                <a href="{{ route('master.user.index') }}?tab=role" class="sidebar-sublink">
                    <i class="bi bi-person-badge-fill"></i> Data Karyawan
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
        <div class="topbar-title">Edit Permintaan</div>
        <div class="topbar-sub">Sistem Informasi Rekam Medis</div>
    </div>

    <div class="container-fluid px-4 px-md-5 py-4">
        <div class="row align-items-start g-4">
        <div class="col-xl-8 col-lg-7">
        <div class="form-card">

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('permintaan.update', $data->id) }}" id="form-kiri">
                @csrf
                @method('PUT')

                <div class="section-title">Data Pasien</div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Layanan</label>
                        <input type="text" value="{{ $data->layanan }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Pasien</label>
                        <input type="text" value="{{ $data->nama }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Umur</label>
                        <input type="number" value="{{ $data->umur }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Kode RM</label>
                        <input type="text" value="{{ $data->kode_rm }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea rows="2" class="form-control" readonly>{{ $data->alamat }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No Telepon</label>
                        <input type="text" value="{{ $data->no_telepon ?? '-' }}" class="form-control" readonly>
                    </div>
                </div>

                <hr class="my-4">

                {{-- FIELD ISI SURAT — diisi admin --}}
                @php
                    $fieldLabels = [
                        'diagnosis'             => 'Diagnosis',
                        'tgl_masuk'             => 'Tanggal Masuk',
                        'tgl_keluar'            => 'Tanggal Keluar',
                        'tgl_periksa'           => 'Tanggal Periksa',
                        'tgl_berobat'           => 'Tanggal Berobat',
                        'tgl_lahir_bayi'        => 'Tanggal Lahir Bayi',
                        'jam_lahir_bayi'        => 'Jam Lahir Bayi',
                        'poliklinik'            => 'Poliklinik',
                        'status_kehamilan'      => 'Status Kehamilan',
                        'usia_kehamilan_minggu' => 'Usia Kehamilan (Minggu)',
                        'usia_kehamilan_hari'   => 'Usia Kehamilan (Hari)',
                        'no_surat_kelahiran'    => 'No. Surat Kelahiran',
                        'jenis_kelamin_bayi'    => 'Jenis Kelamin Bayi',
                        'kondisi_ibu'           => 'Kondisi Ibu',
                        'nama_dokter'           => 'Nama Dokter',
                        'nama_persetujuan'      => 'Nama Persetujuan',
                    ];
                    $dateFields   = ['tgl_masuk','tgl_keluar','tgl_periksa','tgl_berobat','tgl_lahir_bayi'];
                    $timeFields   = ['jam_lahir_bayi'];
                    $numberFields = ['usia_kehamilan_minggu','usia_kehamilan_hari'];
                @endphp

                @if($isiFields->count())
                <div class="section-title mt-4">Isi Surat</div>
                <div class="row">
                    @foreach($isiFields as $key)
                    @php
                        $label = $fieldLabels[$key] ?? ucfirst(str_replace('_', ' ', $key));
                        $type  = in_array($key, $dateFields) ? 'date' : (in_array($key, $timeFields) ? 'time' : (in_array($key, $numberFields) ? 'number' : 'text'));
                    @endphp
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ $label }}</label>
                        @if($key === 'nama_dokter')
                            <select name="nama_dokter" id="select-dokter-isi" form="form-kiri" class="form-select">
                                <option value="">-- Pilih Dokter --</option>
                                @foreach($doctors as $dokter)
                                    <option value="{{ $dokter->nama_karyawan }}"
                                        {{ old('nama_dokter', $data->nama_dokter) === $dokter->nama_karyawan ? 'selected' : '' }}>
                                        {{ $dokter->nama_karyawan }} - {{ $dokter->posisi_pekerjaan }}
                                    </option>
                                @endforeach
                            </select>
                        @elseif($key === 'jenis_kelamin_bayi')
                            <select name="jenis_kelamin_bayi" form="form-kiri" class="form-select">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old($key, $data->$key) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old($key, $data->$key) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        @else
                            <input type="{{ $type }}" name="{{ $key }}" form="form-kiri"
                                   value="{{ old($key, $data->$key) }}" class="form-control"
                                   placeholder="{{ $label }}">
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

            </form>
        </div>
        </div>

        {{-- CARD KANAN: Administrasi --}}
        <div class="col-xl-4 col-lg-5">
        <div class="form-card">
            <div class="section-title">Administrasi</div>

                <div class="mb-3">
                    <label class="form-label">Nama Penerima</label>
                    <input type="text" name="nm_penerima" form="form-kiri" value="{{ old('nm_penerima', $data->nm_penerima) }}" class="form-control">
                </div>

                @if($allLayananFields->contains('diagnosis') && !$isiFields->contains('diagnosis'))
                <div class="mb-3">
                    <label class="form-label">Diagnosis</label>
                    <input type="text" name="diagnosis" form="form-kiri" value="{{ old('diagnosis', $data->diagnosis) }}" class="form-control">
                </div>
                @endif

                @if($layananConfig?->ttd_kanan_label)
                <div class="mb-3">
                    <label class="form-label">Nama Persetujuan</label>
                    <small class="text-muted d-block mb-1" style="font-size:11px;">Untuk TTD: {{ $layananConfig->ttd_kanan_label }}</small>
                    <input type="text" name="nama_persetujuan" form="form-kiri" value="{{ old('nama_persetujuan', $data->nama_persetujuan) }}" class="form-control" placeholder="Nama yang menandatangani">
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Petugas RM</label>
                    <input type="text" name="nm_petugas_rm" form="form-kiri" value="{{ auth()->user()->name }}" class="form-control" readonly>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="submit" form="form-kiri" class="btn btn-success px-4">Update</button>
                    <a href="{{ route('permintaan.index') }}" class="btn btn-secondary px-4">Kembali</a>
                </div>
        </div>
        </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#select-dokter', {
        placeholder: '-- Cari atau Pilih Dokter --',
        allowEmptyOption: true,
    });

    function toggleSidebarDropdown(btn) {
        const dropdown = btn.closest('.sidebar-dropdown');
        dropdown.classList.toggle('open');
    }
    document.querySelectorAll('.sidebar-sublink.active').forEach(el => {
        el.closest('.sidebar-dropdown')?.classList.add('open');
    });
</script>
</body>
</html>