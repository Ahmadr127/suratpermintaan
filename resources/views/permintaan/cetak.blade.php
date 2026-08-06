@if($data->layanan == 'Surat Keterangan Rawat Inap')

    @include('surat.rawat_inap', ['data' => $data])

@elseif($data->layanan == 'Surat Keterangan Rawat Jalan')

    @include('surat.rawat_jalan', ['data' => $data])

@elseif($data->layanan == 'Surat Keterangan Layak Terbang')

    @include('surat.layak_terbang', ['data' => $data])

@elseif($data->layanan == 'Surat Kehilangan Akte Lahir')

    @include('surat.kehilangan_akte', ['data' => $data])

@else

    <h3>Template surat tidak ditemukan</h3>

@endif