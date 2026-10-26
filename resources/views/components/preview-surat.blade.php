@props([
    'layanan',
    'height' => '700px',
])

@php
    $previewUrl = \Illuminate\Support\Facades\Route::has('master.layanan.preview')
        ? route('master.layanan.preview', $layanan->id) : null;
    $liveUrl = \Illuminate\Support\Facades\Route::has('master.layanan.preview-live')
        ? route('master.layanan.preview-live', $layanan->id) : null;
@endphp

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white d-flex align-items-center justify-content-between">
        <strong><i class="bi bi-eye me-2"></i>Preview Surat</strong>
        <span id="preview-status-{{ $layanan->id }}" class="text-muted small">Memuat...</span>
    </div>
    <div class="card-body p-0">
        <iframe id="preview-iframe-{{ $layanan->id }}" src="{{ $previewUrl }}" style="width:100%;height:{{ $height }};border:0;"></iframe>
    </div>
</div>

@once
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@endonce

<script>
(function () {
    var $ = window.jQuery;
    if (!$) return;
    var form = document.querySelector('form[action*="master/layanan"]');
    var iframe = document.getElementById('preview-iframe-{{ $layanan->id }}');
    var status = document.getElementById('preview-status-{{ $layanan->id }}');
    var liveUrl = '{{ $liveUrl }}';
    var csrf = document.querySelector('input[name="_token"]')?.value;
    var timer = null;

    function updatePreview() {
        if (!form || !liveUrl) return;
        var fd = new FormData(form);
        fd.delete('_method');
        status.textContent = 'Memperbarui...';
        fetch(liveUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'text/html' },
            body: fd
        }).then(function (r) { return r.text(); }).then(function (html) {
            iframe.srcdoc = html;
            status.textContent = 'Terbaru';
        }).catch(function () {
            status.textContent = 'Gagal memperbarui';
        });
    }

    if (form) {
        form.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(updatePreview, 800);
        });
        form.addEventListener('change', function () {
            clearTimeout(timer);
            timer = setTimeout(updatePreview, 300);
        });
    }
})();
</script>
