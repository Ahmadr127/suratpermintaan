<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/imagesicon.jpg') }}">
<meta charset="UTF-8">
<title>{{ $layanan->judul_surat ?? $layanan->nama_layanan }}</title>
<style>
    @page { size: A4; margin: 2.5cm; }
    body {
        font-family: "Times New Roman", serif;
        font-size: 11pt;
        line-height: 1.6;
        margin: 60px;
    }
    .center { text-align: center; }
    .bold { font-weight: bold; }
    .underline { text-decoration: underline; }
    .italic { font-style: italic; }
    .mt-5 { margin-top: 5px; }
    .mt-20 { margin-top: 20px; }
    .mt-30 { margin-top: 30px; }
    .mt-60 { margin-top: 60px; }
    table { width: 100%; border-collapse: collapse; }
    td { vertical-align: top; padding: 0; line-height: 1.3; }
    .field-label { width: 180px; }
    .field-sep { width: 10px; }
    @media print { body { margin: 0; } }
</style>
</head>
<body>

{{-- ===== HEADER ===== --}}
<div class="center bold underline">{{ strtoupper($layanan->judul_surat ?? $layanan->nama_layanan) }}</div>
@if($layanan->judul_surat_en)
<div class="center italic">{{ $layanan->judul_surat_en }}</div>
@endif

<div class="center">
    No. {{ $data->no_permintaan }}/RM/RS.AZRA/{{ \Carbon\Carbon::parse($data->tanggal)->format('m') }}/{{ \Carbon\Carbon::parse($data->tanggal)->format('Y') }}
</div>

{{-- ===== KALIMAT PEMBUKA ===== --}}
@if($layanan->kalimat_pembuka)
<div class="mt-20">
    {!! \App\Helpers\SuratHelper::renderIsi($layanan->kalimat_pembuka, $data) !!}
    @if($layanan->kalimat_pembuka_en)
    <br><span class="italic">{!! \App\Helpers\SuratHelper::renderIsi($layanan->kalimat_pembuka_en, $data) !!}</span>
    @endif
</div>
@endif

{{-- ===== BIODATA DINAMIS ===== --}}
@if($layanan->biodataFields->count())
<table class="mt-20">
    @foreach($layanan->biodataFields as $field)
    @if($field->is_admin_field) @continue @endif
    @php
        $val = $data->{$field->field_key} ?? null;
        $display = $val !== null && $val !== '' ? $val : '.........................';
        // suffix ID dan EN digabung di belakang nilai: "Budi , Ny / Mrs"
        if ($field->suffix || $field->suffix_en) {
            $suffixParts = array_filter([$field->suffix, $field->suffix_en]);
            $display = ($val !== null && $val !== '' ? $val : '.........................') . ' , ' . implode(' / ', $suffixParts);
        }
    @endphp
    <tr>
        <td class="field-label">{{ $field->label }}@if($field->label_en)<br><span class="italic">{{ $field->label_en }}</span>@endif</td>
        <td class="field-sep">:</td>
        <td>{{ $display }}</td>
    </tr>
    @endforeach
</table>
@endif

{{-- ===== ISI SURAT DINAMIS ===== --}}
@if($layanan->isiTemplate)
<div class="mt-20">
    {!! \App\Helpers\SuratHelper::renderIsi($layanan->isiTemplate->isi_id, $data) !!}
    @if($layanan->isiTemplate->isi_en)
    <br><span class="italic">{!! \App\Helpers\SuratHelper::renderIsi($layanan->isiTemplate->isi_en, $data) !!}</span>
    @endif
</div>
@endif

{{-- ===== KALIMAT PENUTUP ===== --}}
@if($layanan->kalimat_penutup)
<div class="mt-20">
    <span class="underline">{{ $layanan->kalimat_penutup }}</span><br>
    @if($layanan->kalimat_penutup_en)
    <span class="italic">{{ $layanan->kalimat_penutup_en }}</span>
    @endif
</div>
@endif

{{-- ===== FOOTER / TTD ===== --}}
@if($layanan->ttd_kiri_label || $layanan->ttd_kanan_label)
@php $tglStr = 'Bogor, ' . \Carbon\Carbon::parse($data->tanggal)->translatedFormat('F d') . '<sup>th</sup>, ' . \Carbon\Carbon::parse($data->tanggal)->format('Y'); @endphp
<table class="mt-60">
    <tr>
        <td width="50%">
            @if($layanan->ttd_tanggal_posisi === 'kiri')
                {!! $tglStr !!}<br><br>
            @endif
            @if($layanan->ttd_kiri_label)
                {{ $layanan->ttd_kiri_label }}<br>
                @if($layanan->ttd_kiri_label_en)<span class="italic">{{ $layanan->ttd_kiri_label_en }}</span>@endif
                <br><br><br><br>
                <u>{{ $data->nama_dokter ?? '.......................' }}</u>
            @endif
        </td>
        <td width="50%" class="center">
            @if($layanan->ttd_tanggal_posisi === 'kanan')
                {!! $tglStr !!}<br><br>
            @endif
            @if($layanan->ttd_kanan_label)
                <span style="display:inline-block; max-width:180px; font-size:10pt;">{{ $layanan->ttd_kanan_label }}</span><br>
                @if($layanan->ttd_kanan_label_en)<span class="italic" style="display:inline-block; max-width:180px; font-size:10pt;">{{ $layanan->ttd_kanan_label_en }}</span>@endif
                <br><br><br><br>
                @php
                    $ttdKanan = $layanan->ttd_kanan_sumber === 'dokter'
                        ? ($data->nama_dokter ?? '.......................')
                        : ($data->nama_persetujuan ?? '...................');
                @endphp
                <u>{{ $ttdKanan }}</u>
            @endif
        </td>
    </tr>
</table>
@endif

<script>
    window.onload = function() { window.print(); }
</script>
</body>
</html>
