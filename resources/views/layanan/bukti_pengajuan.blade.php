<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/imagesicon.jpg') }}">
<meta charset="UTF-8">
<title>Bukti Permintaan - {{ $data->no_permintaan }}</title>
<style>
    @page { size: A4 landscape; margin: 1.5cm 2cm; }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: "Courier New", Courier, monospace;
        font-size: 10pt;
        color: #000;
        background: #fff;
        padding: 30px 40px;
    }
    .kop {
        position: relative;
        padding-bottom: 8px;
    }
    .kop-left { font-size: 9.5pt; line-height: 1.6; }
    .kop-left .rs-name { font-size: 12pt; font-weight: bold; }
    .kop-right {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
        white-space: nowrap;
    }
    .kop-right .judul {
        font-size: 10.5pt;
        font-weight: bold;
        text-decoration: underline;
        letter-spacing: 0.5px;
    }
    .kop-right .nomor-row {
        display: flex;
        gap: 6px;
        margin-top: 6px;
        font-size: 10pt;
        justify-content: center;
    }
    hr.solid { border: none; border-top: 1.5px solid #000; margin: 8px 0; }
    hr.dashed { border: none; border-top: 1.5px dashed #000; margin: 8px 0; }
    .info-table { width: 100%; border-collapse: collapse; }
    .info-table td {
        vertical-align: top;
        padding: 2px 4px;
        font-size: 9.5pt;
        line-height: 1.5;
    }
    .info-table .lbl { width: 130px; white-space: nowrap; }
    .info-table .sep { width: 12px; text-align: center; }
    .two-col { display: flex; gap: 0; margin-top: 10px; }
    .two-col .col { flex: 1; }
    .two-col .col:first-child { padding-right: 10px; }
    .layanan-val { font-size: 10pt; font-weight: bold; }
    .dokter-val { font-size: 13pt; font-weight: bold; letter-spacing: 1px; margin-top: 2px; }
    .nb-section { margin-top: 14px; font-size: 9pt; }
    .nb-section .nb-title { font-weight: bold; margin-bottom: 4px; }
    .nb-section ul { padding-left: 18px; }
    .nb-section ul li { margin-bottom: 4px; line-height: 1.5; }
    .footer-meta { text-align: right; font-size: 9pt; line-height: 1.6; }
    .footer-row { display: flex; justify-content: space-between; align-items: flex-end; margin-top: 6px; }
    .screen-actions { display: flex; gap: 10px; margin-bottom: 20px; }
    .btn-print {
        padding: 9px 22px; background: #005654; color: #fff;
        border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer;
    }
    .btn-print:hover { background: #007a77; }
    .btn-back {
        padding: 9px 22px; background: #fff; color: #005654;
        border: 1.5px solid #c0dedd; border-radius: 8px;
        font-size: 13px; font-weight: 600; text-decoration: none;
    }
    .btn-back:hover { background: #e8f5f4; }
    @media print {
        body { padding: 0; }
        .screen-actions { display: none; }
    }
</style>
</head>
<body>

<div class="screen-actions">
    <button class="btn-print" onclick="window.print()">&#128438; Cetak Bukti</button>
    <a class="btn-back" href="{{ route('user.permintaan') }}">&#8592; Kembali</a>
</div>

<!-- KOP SURAT -->
<div class="kop">
    <div class="kop-left">
        <div class="rs-name">RS. AZRA</div>
        <div>Jl Raya Pajajaran No. 219&nbsp; BOGOR 16153</div>
        <div>Telp. 0251-8318456, 8370349</div>
        <div>Fax. 0251-8331773</div>
        <div>Unit Rekam Medis Ext. 131/391</div>
    </div>
    <div class="kop-right">
        <div class="judul">BUKTI PERMINTAAN KORESPONDENSI</div>
        <div class="nomor-row">
            <span>NOMOR</span>
            <span>&nbsp;:&nbsp;</span>
            <span><strong>{{ $data->no_permintaan }}</strong></span>
        </div>
    </div>
</div>

<hr class="solid">

<!-- INFO UTAMA 2 KOLOM -->
<div class="two-col">
    <div class="col">
        <table class="info-table">
            <tr>
                <td class="lbl">TGL PERMINTAAN</td>
                <td class="sep">:</td>
                <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-M-Y') }}</td>
            </tr>
            <tr><td colspan="3" style="height:40px;"></td></tr>
            <tr>
                <td class="lbl">NO. RM</td>
                <td class="sep">:</td>
                <td>{{ $data->kode_rm ?? '' }}</td>
            </tr>
            <tr>
                <td class="lbl">NAMA</td>
                <td class="sep">:</td>
                <td>{{ $data->nama ?? '' }}</td>
            </tr>
            <tr>
                <td class="lbl">UMUR</td>
                <td class="sep">:</td>
                <td>{{ $data->umur ?? '' }}@if($data->jenis_kelamin)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; JK &nbsp;: &nbsp;{{ $data->jenis_kelamin }}@endif</td>
            </tr>
            <tr>
                <td class="lbl">ALAMAT</td>
                <td class="sep">:</td>
                <td>{{ $data->alamat ?? '' }}</td>
            </tr>
            <tr>
                <td class="lbl">TELP</td>
                <td class="sep">:</td>
                <td>{{ collect([$data->no_telepon, $data->no_hp])->filter()->implode(', ') }}</td>
            </tr>
            <tr>
                <td class="lbl">LAYANAN</td>
                <td class="sep">:</td>
                <td>
                    <span class="layanan-val">{{ $data->layanan }}</span>
                    @if($data->is_lain_lain && $data->keterangan_lain_lain)
                        <br><span style="font-size:9pt;">{!! nl2br(e($data->keterangan_lain_lain)) !!}</span>
                    @endif                </td>
            </tr>
            @if($data->nama_dokter)
            <tr>
                <td class="lbl">DOKTER</td>
                <td class="sep">:</td>
                <td><span class="dokter-val">{{ $data->nama_dokter }}</span></td>
            </tr>
            @endif
        </table>
    </div>
    <div class="col">
        <table class="info-table">
            <tr>
                <td class="lbl">NAMA PENERIMA</td>
                <td class="sep">:</td>
                <td>{{ $data->nm_penerima ?? '' }}</td>
            </tr>
            <tr>
                <td class="lbl">NAMA PETUGAS RM</td>
                <td class="sep">:</td>
                <td>{{ $data->nm_petugas_rm ?? '' }}</td>
            </tr>
            <tr>
                <td class="lbl">NAMA PEMINTA</td>
                <td class="sep">:</td>
                <td>{{ $data->nama_peminta ?? '' }}</td>
            </tr>
            <tr>
                <td class="lbl">TELP PEMINTA</td>
                <td class="sep">:</td>
                <td>{{ $data->email_peminta ?? '' }}</td>
            </tr>
            <tr>
                <td class="lbl">FAX</td>
                <td class="sep">:</td>
                <td>{{ $data->no_whatsapp ?? '' }}</td>
            </tr>
            <tr>
                <td class="lbl">UP</td>
                <td class="sep">:</td>
                <td>
                    {{ $data->up ?? '' }}
                    @if($data->tgl_rencana_kirim)
                        {{ \Carbon\Carbon::parse($data->tgl_rencana_kirim)->format('d/m/Y') }}
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

<hr class="dashed" style="margin-top:16px;">

<!-- FOOTER NB -->
<div class="footer-row">
    <div class="nb-section">
        <div class="nb-title">N.B. :</div>
        <ul>
            <li>Semua permintaan yang berhubungan dengan diagnosa &amp; tindakan medis tidak<br>bisa dilayani melalui telepon.</li>
            <li>Harus ada persetujuan dari pasien/wali yang diberi kuasa.</li>
            <li>Formulir Asuransi harus dilengkapi tanda tangan pasien, wali sebelum diserahkan.</li>
        </ul>
    </div>
    <div class="footer-meta">
        User ID &nbsp;: {{ auth()->user()->username ?? auth()->user()->name }}<br>
        Print Date : {{ \Carbon\Carbon::now()->format('d M Y') }}<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ \Carbon\Carbon::now()->format('h:i:sA') }}
    </div>
</div>

</body>
</html>
