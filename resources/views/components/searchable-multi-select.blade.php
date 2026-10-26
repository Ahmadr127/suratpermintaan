@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => [],
    'placeholder' => 'Pilih...',
    'class' => '',
])

@php
    $uid = 'sms_' . uniqid();
    $selected = is_array($selected) ? $selected : (empty($selected) ? [] : [$selected]);
    $selectedStr = array_map('strval', $selected);
    $optionsArr = is_array($options) ? $options : [];
@endphp

<div class="mb-3">
    @if($label)
        <label class="form-label" for="{{ $uid }}">{{ $label }}</label>
    @endif

    {{-- Select searchable (multi) --}}
    <select id="{{ $uid }}" name="{{ $name }}[]" class="form-select {{ $class }}" multiple>
        @foreach($optionsArr as $value => $text)
            <option value="{{ $value }}" {{ in_array((string) $value, $selectedStr, true) ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>

    {{-- Daftar item terpilih (di bawah input, tidak digabung di kotak input) --}}
    <div id="{{ $uid }}_selected" class="mt-2 d-flex flex-wrap gap-2"></div>
</div>

@once
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        /* Sembunyikan tag terpilih di dalam kotak input */
        .select2-container .select2-selection__choice { display: none !important; }
    </style>
@endonce

<script>
    (function () {
        var $ = window.jQuery;
        if (!$) return;
        $(function () {
            var $sel = $('#{{ $uid }}');
            var $list = $('#{{ $uid }}_selected');

            function renderSelected() {
                $list.empty();
                $sel.find('option:selected').each(function () {
                    var val = $(this).val();
                    var txt = $(this).text();
                    var $chip = $('<span class="badge bg-secondary d-inline-flex align-items-center gap-1" style="font-size:13px;padding:6px 10px;border-radius:999px;"></span>');
                    $chip.text(txt);
                    var $btn = $('<button type="button" class="btn-close btn-close-white" style="font-size:10px;" aria-label="Hapus"></button>');
                    $btn.on('click', function () {
                        $sel.find('option[value="' + val.replace(/"/g, '\\"') + '"]').prop('selected', false);
                        $sel.trigger('change');
                    });
                    $chip.append($btn);
                    $list.append($chip);
                });
            }

            $sel.select2({
                width: '100%',
                placeholder: '{{ $placeholder }}',
                allowClear: true,
                closeOnSelect: false
            });

            $sel.on('change', renderSelected);
            renderSelected();
        });
    })();
</script>
